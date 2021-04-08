<html>
<head>
<title>Login</title>
<?php
$errors=array();

   function validate_input()
   {
     global $errors;
      $myCon = mysqli_connect("localhost","root","","channelwatchdb");
    	$sql = "select * from customertbl where cust_lname='".$_POST['name']."' and cust_passw='".$_POST['pass']."'";
    	
     if(trim($_POST["name"])=="")
	 	$errors[0] = "***Your lastname?***";
	 elseif(strlen(trim($_POST["name"]))>20)
	 	$errors[0] = "***your lastname has TOO many characters?***";
	 else
	 	$errors[0]="";
	
	if(trim($_POST["pass"])=="")
	 	$errors[1] = "***Your password?***";
	 elseif(strlen(trim($_POST["pass"]))!= 7)
	 	$errors[1] = "***your password MUST HAVE 7 characters?***";
	 else
	 	$errors[1]="";
	 	
	 	if($errors[0]=="" && $errors[1]=="")
	 	{
			$res = mysqli_query ($myCon,$sql);
			if($res)
			{
				if(mysqli_num_rows($res)>0)
				{
					$errors[2]="";
					$result=mysqli_fetch_assoc($res);			
					
					setcookie("fname",$result["cust_fname"]);
					setcookie("lname",$result["cust_lname"]);
					setcookie("id",$result["cust_id"]);
				}
				else
					$errors[2]="***Your password DO NOT MATCH, Please Re-enter***";
			}
		}
		else
		{
			$errors[2]="";
		}
   }
   
   if(isset($_POST["login"]))
   {
   	validate_input();
   	if($errors[0] == "" && $errors[1] == "" && $errors[2]=="")
   	{
		header(("Location:titleSrch.php"));
	}
   	
   }
   else
   {
   	$errors[0]="";
   	$errors[1]="";
   	$errors[2]="";
   }
   

?>
</head>
<body>
<h1 align="center">Shaw Channel</h1>
<h2 align="center">Member Login</h2>
<form method="POST" action="<?php print($_SERVER['PHP_SELF']);?>" >
	<table style="table-layout: fixed; width: 85%; margin-left: 20%" align="center">
	<tr>
	<td style="text-align: right;"><label><b>Enter Your Lastname (MAX: 20characters)</b></label></td>
	<td style="text-align: left;"><input type="text" name="name" size="8" value="<?php if(isset($_POST['login']))print $_POST['name'];?>">
	</td>
	<td style="text-align: left;"><?php print "<nav style='color: red'>$errors[0]<nav>";?></td>
	</tr>
	
	<tr>
	<td style="text-align: right"><label><b>Enter Your Password (7 characters)</b></label></td>
	<td style="text-align: left"><input type="password" name="pass" size="4" value="<?php if(isset($_POST['login']))print $_POST['pass'];?>"></td>
	<td style="text-align: left"><?php print "<nav style='color: red'>$errors[1]</nav>"?></td>
	</tr>
	
	<tr>
	<td></td>
	<td style="text-align: left"><input type="submit" value="Login" name="login">  <button type="Clear" value="Reset">Clear</<button></td>
	<td></td>
	</tr>
	</table>
</form>

<?php print "<center><nav style='color: red'>$errors[2]</nav></center>"?>
<form method="post" action="addNewCust.php">
	<p style="text-align: center; color: blue;"><b>For New Members, Please login here </b><button type="submit">New Member</button></p>
</form>
</body>
</html>