<!DOCTYPE html>
<html>
<head>
<title>Results</title>
<style>
	tr,td
	{
		border-style:ridge;
	}
	table
	{
		text-align: center;
		overflow: hidden;
	}
</style>
</head>
<?php
print "<h1 align='center'>Shaw Channel</h1>";
print "<h2 align='center'>Title Search Results</h2>";
print "<form action='addOrderChannel.php' method='post'><table align='center' width='70%'><tr>";
print "<td><b>Title</b></td>";
print "<td><b>id</b></td>";
print "<td><b>Logo</b></td>";
print "<td><b>Genre</b></td>";
print "<td><b>Price</b></td>";
print "<td><b>Add to<br/>Cart</b></td>";
$mycon= mysqli_connect("localhost","root","","channelwatchdb");
$sql = "select ch_id, ch_title, ch_genre, ch_price,ch_logo from channeltbl "; 
	    	
if(strcmp($_POST["category"],"All")!=0)
{
	$sql = $sql."where ch_genre='".$_POST["category"]."' ";
}

if(!empty(trim($_POST["srch"]) ))
{
	if(strcmp($_POST["category"],"All")==0)
		$sql= $sql."where ch_title ";
	else
	{
		$sql= $sql."and ch_title ";
	}
	
	switch($_POST["type"])
	{
		case "wt":
		$sql= $sql."like '%".$_POST["srch"]."%' ";
		break;
		
		case "sw":
		$sql= $sql."like '".$_POST["srch"]."%' ";
		break;
		
		case "et":
		$sql= $sql."='".$_POST["srch"]."' ";
		break;
	}
}

	if(!empty($_POST["groupgenre"]))
	{
		$sql=$sql."order by ch_genre,";
		if(strcmp($_POST["order"],"ch_price")==0)
			$sql = $sql."ch_price desc,ch_title";
		else
			$sql = $sql.$_POST['order'];
	}
	else
	{
		if(strcmp($_POST["order"],"ch_price")==0)
			$sql = $sql."order by ch_price desc,ch_title";
		else
			$sql = $sql."order by ch_title";
	}
	
$res=mysqli_query($mycon,$sql);
if($res)
{
	if(mysqli_num_rows($res)>0)
	{
		for($i=0;$i<mysqli_num_rows($res);$i++)
		{
			$arr= mysqli_fetch_array($res);
			print "<tr>";
			print "<td>$arr[1]</td>";
			print "<td>$arr[0]</td>";
			print "<td><img src='../logos/$arr[4]' height='50px'/></td>";
			switch($arr[2])
			{
				case "e":
				print "<td>Entertainment</td>";
				break;
				
				case "f":
				print "<td>Family</td>";
				break;
				
				case "i":
				print "<td>Information</td>";
				break;
				
				case "m":
				print "<td>Movie</td>";
				break;
				
				case "n":
				print "<td>News/Buisness</td>";
				break;
				
				case "o":
				print "<td>Old TV Shows</td>";
				break;
				
				case "s":
				print "<td>Sci-Fi</td>";
				break;
				
				case "t":
				print "<td>Sports</td>";
				break; 
			}
			print "<td>$arr[3]</td>";
			print "<td><input type='checkbox' name='channels[]' value='$arr[0]'  /></td>";
			print "</tr>";
		}
	}
}
print "</table><br/>";
print "<center><button type='submit'>Submit</button>  <button type='reset'>Clear</button></center></form>";
?>
<body>
	
</body>
</html>