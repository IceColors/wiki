<!DOCTYPE html>
<html lang="no">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Wiki</title>
	<script src="https://unpkg.com/feather-icons"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style type="text/css">
	.nobull {
	list-style-type: none;
	}
	</style>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body class="d-flex flex-column min-vh-100">

<div class="navbar bg-light border">
	<a class="navbar-brand" href="index.php"> Wiki </a>
	<div class="d-inline-flex">
		<?php 
			require_once("functions.php");
			if(checkIfLoggedIn() == true){
				?>
				<a class="p-2 text-muted" href="minside.php"> Min side </a>
				<a class="p-2 text-muted" href="logout.php"> Logg ut </a>
			<?php }
			else {
				?> 
				<a class="p-2 text-muted" href="login.php"> Logg inn </a>
				<?php
			}
		?> 
	</div>
</div>
<div role="main" class="container-fluid flex-grow-1 d-flex">
	<div class="row flex-fill">
		<div class="col-md-2 d-none d-md-block bg-light border">
			<ul class="nav flex-column">
				<li class="nav-item">
					<a class="nav-link" href="index.php"> Forside </a> 
				</li>
				<li class="nav-item">
					<a class="nav-link" href="kategori.php"> Kategorier </a> 
				</li>
				<li class="nav-item">
					<a class="nav-link" href="artikkel.php"> Tilfeldig Artikkel </a> 
				</li>
				
			</ul>
		</div>
		<div class="col col-md-10">
			
	
