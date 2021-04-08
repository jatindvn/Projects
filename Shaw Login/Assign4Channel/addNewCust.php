<html>
<head>
<title>Login</title>
<?php
$errors=array();

   function validate_input(&$result1)
   {
     global $errors;
    $match=FALSE;
       $myCon = mysqli_connect("localhost","root","","channelwatchdb"); // establish connection b/w databse and php

    	$sql = "select * from customertbl where cust_lname='".$_POST['lname']."' and cust_passw='".$_POST['pass']."'";
	    $sql2 = "insert into customertbl (cust_fname,cust_lname,cust_email,cust_passw) 
	    	values ('".$_POST['fname']."','".$_POST['lname']."','".$_POST['mail']."','".$_POST['pass']."')";
	    	$res = mysqli_query ($myCon,$sql);
	    	if($res)
	    	{
	    		if(mysqli_num_rows($res)>0)
				$match=true;
				else
				$match=FALSE;
			}
    
     if(trim($_POST["fname"])=="")
	 	$errors[0] = "***Your Firstname?***";
	 elseif(strlen(trim($_POST["fname"]))>20)
	 	$errors[0] = "***your Firstname has TOO many characters?***";
	 else
	 	$errors[0]="";
	
	if(trim($_POST["lname"])=="")
	 	$errors[1] = "***Your Lastname?***";
	 elseif(strlen(trim($_POST["lname"]))>20)
	 	$errors[1] = "***your Lastname has TOO many characters?***";
	 else
	 	$errors[1]="";
   
   if(trim($_POST["mail"])=="")
	 	$errors[2] = "***Your e-mail?***";
	 elseif(strlen(trim($_POST["mail"]))>20)
	 	$errors[2] = "***your e-mail has TOO many characters?***";
	 else
	 	$errors[2]="";
   
   if(trim($_POST["pass"])=="")
	 	$errors[3] = "***Your password?***";
	 elseif(strlen(trim($_POST["pass"]))!=7)
	 	$errors[3] = "***your Password MUST be 7 characters***";
	 elseif(is_numeric(trim($_POST["pass"])))
	 	$errors[3] = "***Your Password cannot be numeric***";
	 elseif(strcmp(ucfirst(trim($_POST["pass"])),trim($_POST["pass"]))==0)
	 	$errors[3] = "***Invalid character***";
	 else
	 	$errors[3]="";
	 	
	 	
	 	   	if($errors[0] == "" && $errors[1] == "" && $errors[2] == "" && $errors[3] == "")
	 	   	{
	 	   		if($match)
				 {
	 				$errors[3] = "***Password is prohibited,</br>please Re-enter ***";
	 			 }
	 			 else
	 			 mysqli_query($myCon,$sql2);
	 			 $result1 = mysqli_query ($myCon,$sql);
	 	   		 
	 	   	}
	 	
    mysqli_close($myCon);
   }
   
   if(isset($_POST["submit"]))
   {
   	validate_input($result1);
   	if($errors[0] == "" && $errors[1] == "" && $errors[2] == "" && $errors[3] == "")
   	{
   		$result=mysqli_fetch_assoc($result1);
		setcookie("fname",$result["cust_fname"]);
		setcookie("lname",$result["cust_lname"]);
		setcookie("id",$result["cust_id"]);
		header(("Location:titleSrch.php"));
	}

   }
   else
   {
   	$errors[0]="";
   	$errors[1]="";
   	$errors[2]="";
   	$errors[3]="";
   }
   

?>
<style>
	table,tr,td
	{
		border-style: ridge;
	}
</style>
</head>
<body>
<h1 align="center">Shaw Channel</h1>
<h2 align="center">New Member</h2>
<form method="POST" action="<?php print($_SERVER['PHP_SELF']);?>" >
	<table align="center" style="table-layout: fixed;">
	<tr>
	<td style="text-align: right;"><label>Enter Your <b>First name</b>(MAX 20 chars.)</label></td>
	<td style="text-align: left; padding-right: 100px"><input type="text" name="fname" size="8" value="<?php if(isset($_POST['submit']))print $_POST['fname'];?>">
	</td>
	<td style="text-align: left;"><?php print "<nav style='color: red'>$errors[0]<nav>";?></td>
	</tr>
	
	<tr>
	<td style="text-align: right"><label>Enter Your <b>Last name</b> (MAX 20 chars.)</label></td>
	<td style="text-align: left; padding-right: 100px"><input type="text" name="lname" size="8" value="<?php if(isset($_POST['submit']))print $_POST['lname'];?>"></td>
	<td style="text-align: left;"><?php print "<nav style='color: red'>$errors[1]<nav>"?></td>
	</tr>
	
	<tr>
	<td style="text-align: right"><label>Your <b>e-mail</b> address (MAX 20 chars.)</label></td>
	<td style="text-align: left; padding-right: 100px"><input type="text" name="mail" size="8" value="<?php if(isset($_POST['submit']))print $_POST['mail'];?>"></td>
	<td style="text-align: left"><?php print "<nav style='color: red'>$errors[2]<nav>"?></td>
	</tr>
	
	<tr>
	<td style="list-style-position: inside; text-align: right;">Your <b>password</b><br/>
	<ul>
		<li>MUST BE 7 CHARACTERS</li>
		<li><b>CANNOT</b> BE ALL DIGITS</li>
		<li><b>MUST BEGIN</b> with a lowercase LETTER of</br> the alphabet</li>
		<li><b>ONLY lowercare LETTERS OF THE</br> ALPHABET ALLOWED</b></li>
	</ul>
	</td>
	<td style="text-align: left; padding-right: 100px"><input type="text" name="pass" size="4" value="<?php if(isset($_POST['submit']))print $_POST['pass'];?>"></td>
	<td style="text-align: left"><?php print "<nav style='color: red'>$errors[3]<nav>"?></td>
	</tr>
	
	<tr>
	<td>&nbsp;</td>
	<td style="text-align: left"><input type="submit" value="Submit" name="submit"></td>
	<td>&nbsp;</td>
	</tr>
	</table>
</form>
</body>
</html>