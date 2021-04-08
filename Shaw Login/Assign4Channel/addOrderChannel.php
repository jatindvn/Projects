<!DOCTYPE html>
<html>
<head>
<title>Add Channels</title>
<style>
	tr,td
	{
		border-style:ridge;
	}
	table
	{
		text-align: center;
		
	}
	.yellow
	{
		background-color: yellow;
	}
	form { display: inline; }
</style>
</head>
<?php
error_reporting(E_WARNING);
print "<h1 align = center><b>Shaw Channel</b></h1>";
print "<h1 align = center><b>Your Cart/ Channel Lineup</b></h1>";
print "<h1 align = center>Order So Far for ".$_COOKIE['fname']." ".$_COOKIE['lname']."</h1><br /><br/>";
$mycon= mysqli_connect("localhost","root","","channelwatchdb");
if(count($_POST['channels'])>0)
{
$temp = $_POST['channels'];
$channels; $price;


for ($x=0;$x<count($temp);$x++)
{
	$channels=$temp[$x];
	$found = true;
	$sql2 = "select ch_price from channeltbl where ch_id ='".$channels."'";
	$res=mysqli_query($mycon,$sql2);
	if($res)
	{
		$temp1 = mysqli_fetch_array($res);
		$price = $temp1[0];
	}
	$sql3 = "select ord_price from ordertbl where ord_cust_id ='".$_COOKIE["id"]."' and ord_ch_id='".$channels."'"; 
	$res2 = mysqli_query($mycon,$sql3);
	
	if(mysqli_num_rows($res2)> 0)
	{
		$found=true;
	}
	else
	{
		$found=FALSE;
	}
	if(!$found)
	{
		$sql = "insert into ordertbl (ord_cust_id,ord_ch_id,ord_in_cart_ordered,ord_price) 
	   values ('".$_COOKIE['id']."','".$channels."','y','".$price."')";
		mysqli_query($mycon,$sql);
	}
}	
print "<p>Below is your Current Channel lineup (in WHITE) AND in your CART (in YELLOW)</p>";	
}
else
{
	print "<p >You did not select any channel!<br/>BUT below is your Current Channel lineup (in WHITE) AND in your CART (in YELLOW) from before</p>";
}
	$sql4= "select C.ch_title,O.ord_ch_id,C.ch_logo,C.ch_price,O.ord_in_cart_ordered from ordertbl as O 
	inner join channeltbl as C on C.ch_id=O.ord_ch_id 
	where O.ord_cust_id=".$_COOKIE['id']."
	order by O.ord_in_cart_ordered";	
	$result= mysqli_query($mycon,$sql4);
		$current=0;
		$incart=0;
		print "<table align='center' width=70%>";
		print "<tr><td style='height:50px'><b>Title</b></td>";
		print "<td><b>ID</b></td>";
		print "<td><b>Logo</b></td>";
		print "<td><b>Price</b></td></tr>";
		$style="";
	if($result)
	{
		$is_y=array();
		if(mysqli_num_rows($result)>0)
		{
			$chanarr= array();
			for($y=0;$y<(mysqli_num_rows($result));$y++)
			{
				$line=mysqli_fetch_array($result);
				$chanarr[$y]=$line[1];
				if(strcmp($line[4],"y")==0)
				{
					$incart+=$line[3];
					$style="yellow";
					$is_y[$y]=TRUE;
				}
				else
				{
					$is_y[$y]=FALSE;
					$current+=$line[3];
				}

				print"<tr><td class='$style'>$line[0]</td>";
				print"<td>$line[1]</td>";
				print"<td><img src='../logos/".$line[2]."' height='50px'</td>";
				print"<td class='$style'>***$line[3]***</td></tr>";
			
			}
			print "<tr><td style='text-align:right' colspan=3><b>Total:</b></td>";
			$all=$current+$incart;
			print "<td><b>Current: $".$current."<br/> Cart: **$".$incart."**<br/><hr width='100px'>Total: $".$all."</b></td></tr>";
		}
		print "</table><br/><br/>";
	}
	
	setcookie("usr",serialize($chanarr));
	if(in_array("FALSE",$is_y))
	{
		print "<form action='processChannelOrders.php' method='post'><p><center>Enter your Credit Number:<input type = 'password' name='number'/></center><p/><p><center><button type='submit' name='check'>CheckOut</button> Or </form><form action='channelLogin.php'><button type='submit'>LogOut</button></form></center></p>";
	}
	else
	{
		print "<center>PLEASE CLICK BROWSER BACK BUTTON TO RETRY <br/>Or <form action='channelLogin.php'><button type='submit'>LogOut</button></form></center>";
	}

?>
<body>
	
</body>
</html>