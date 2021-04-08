<?php
print "<h1 align='center'>Shaw Channel Order Process</h1>";
print "<h2 align='center'>Orders So Far for Simon Templar</h2><br/>";
$orders=unserialize($_COOKIE["usr"]);
if(!empty(trim($_POST["number"])))
{
	$myCon = mysqli_connect("localhost","root","","channelwatchdb");
	for ($i=0;$i<count($orders);$i++)
	{
		$sql = "update ordertbl set ord_in_cart_ordered = 'n' where ord_cust_id = ".$_COOKIE['id']." and ord_ch_id=".$orders[$i];
		$res=mysqli_query($myCon,$sql);
	}	
		
		if($res)
		{
			if(mysqli_affected_rows($myCon) == 0)
		{
			print "Order has ALREADY been processed !!!!";
		}
			print "<center><b>Thank You,Please Close Your Browser to exit<br/>Or <form action ='channelLogin.php'><button type='submit'> LogOut </button></form></b></center>";
		}
}
else
print "<center><b>PLEASE PRESS BROWSER BACK BUTTON AND RE-ENTER YOUR CREDIT CARD NUMBER</b></center>";


?>