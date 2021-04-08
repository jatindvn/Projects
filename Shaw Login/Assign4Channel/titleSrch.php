<!DOCTYPE html>
<html>
<head>
<title>Title Search</title>
<style>
	tr,td
	{
		border-style: ridge;
	}
</style>
</head>
<body style="text-align: center">
<h1>Shaw Channel</h1>
<h4>Welcome <?php print $_COOKIE["fname"]." ".$_COOKIE["lname"]?></h4>
<h2>Title Search</h2>
	<form action="fetchDisplayChannel.php" method="post">
		<table align="center">
			<tr>
				<td style="'padding-left:100px"><b>Title</b></td>
				<td colspan="2"><input type="text" name="srch"/></td>
				<td style="padding: 10px"><button type="submit" name="submit">Search</button></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<table>
						<tr>
							<td valign="top"><b>Search By:</b></td>
							<td>
								<select name="type">
									<option value="wt" selected="selected">Within Title</option>
									<option value="sw">Starting With</option>
									<option value="et">Exact Title</option>
								</select>
								<table>
									<tr>
										<td><input type="radio" value="ch_title" name="order" checked="checked"/><b>Order By Title</b></td>
									</tr>
									<tr>
										<td><input type="radio" value="ch_price" name="order"/><b>Order By Price (Highest)</b></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<b></b>Genre</b>
					<select name="category">
  					<option value="All" selected="selected">All</option>
  					<option value="e">Entertainment</option>
  					<option value="f">Family</option>
					<option value="i">Information</option>
					<option value="m">Movie</option>
					<option value="n">News/Buisness</option>
					<option value="o">Old TV Shows</option>
					<option value="s">Sci-Fi</option>
					<option value="t">Sports</option>
					</select>
					<br/><br />
					<b>Group by Genre</b>
					<input type="checkbox" name="groupgenre" value="group by ch_genre"/>
				</td>
				<td>&nbsp;</td>
			</tr>
		</table><br />
		<center><button type="reset">Clear</button></center>
	</form>
</body>
</html>