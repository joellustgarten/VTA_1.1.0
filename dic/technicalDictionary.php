<?php
ob_start();
require "C:/xampp/htdocs/VTA_1.1.0/PHP/connection.php";
$res;
if(!isset($_POST['submit'])){
    $searchTerm = "SELECT * FROM technical_dictionary";
    $res = mysqli_query($conn, $searchTerm);
	$number = mysqli_num_rows($res);
} elseif(isset($_POST['submit'])){
    $term = mysqli_real_escape_string($conn, $_POST['search']);
    $searchTerm = "SELECT * FROM technical_dictionary WHERE portuguese like '%{$term}%' or english like '%{$term}%' or german like '%{$term}%' or french like '%{$term}%' or spanish like '%{$term}%' or italian like '%{$term}%' or swedish like '%{$term}%'";
    $res = mysqli_query($conn, $searchTerm);
	$number = mysqli_num_rows($res);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>VAT 1.0 | Technical dictionary</title>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="header">
		<div class="frieze"></div>
		<div class="logo"><img src="logoNavBar.png" width="auto" height="30px" alt="VTA Logo" /></div>
		<div class="form">
			<form action="technicalDictionary.php" method="POST">
				<input class="search" type="search" placeholder="Term to translate..." name="search" required>
				<button class="btn btn-primary" type="submit" name="submit">SEARCH</button>
			</form>
		</div>

	</div>
	
	<div class="table">
	<div class="number"><h2>Number of hits in dictionary: <?php echo $number ?></h2></div>
		<table class="table">
			<thead>
				<tr>
					<th>Portuguese</th>
					<th>English</th>
					<th>German</th>
					<th>French</th>
					<th>Spanish</th>
					<th>Italian</th>
					<th>Swedish</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(mysqli_num_rows($res) > 0) {
				while($data = mysqli_fetch_assoc($res)){
				?>
				<tr>
					<td><?php echo $data['portuguese'];?></td>
					<td><?php echo $data['english'];?></td>
					<td><?php echo $data['german'];?></td>
					<td><?php echo $data['french'];?></td>
					<td><?php echo $data['spanish'];?></td>
					<td><?php echo $data['italian'];?></td>
					<td><?php echo $data['swedish'];?></td>
				</tr>
				<?php }} ?>
			</tbody>
		</table>
	</div>
</body>
</html>