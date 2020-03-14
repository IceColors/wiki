<?php 
	include("header.php");
	require_once("functions.php");
	
	$database = connect();
	
	if(!isset($_GET["id"])){
		header("location: index.php");
		exit;
	}
	$articleQuery = sprintf('SELECT name, articleid, categoryid FROM articles WHERE articleid = %s', $_GET["id"]);
	$articleData = $database->query($articleQuery);
	$article = mysqli_fetch_assoc($articleData);
	
	$revisionsQuery = sprintf('SELECT date, textid, mediaid FROM revisions WHERE articleid = "%s"', $_GET["id"]);
	$revisionsData = $database->query($revisionsQuery);
?>

<nav class="nav">
	<a class="nav-link active" href="artikkel?id=<?php echo($article["articleid"]); ?>">Artikkel</a>
	<a class="nav-link" href="artikkelhistorie?id=<?php echo($article["articleid"]); ?>">Historikk</a>
	<?php
		if(checkIfLoggedIn()){
		?>
		<a class="nav-link" href="editartikkel?id=<?php echo($article["articleid"]); ?>">Rediger</a>
		<?php
		}
	?>
</nav>



<div class="row justify-content-center h-100">
	<?php
		$revisionsQuery = sprintf('SELECT date, textid, mediaid FROM revisions WHERE articleid = "%s"', $_GET["id"]);
		$revisionsData = $database->query($revisionsQuery);
		while($revision = mysqli_fetch_assoc($revisionsData)){
			$image = getRevisionMedia($revision);
		?>
		<div class="col">
			<div class="card m-2 h-100">
				<img class="card-img-top" style="height: 250px; object-fit: contain;" src="<?php  echo("/wiki" . $image["path"]); ?>" alt="Card image cap">
				<div class="card-body">
					<?php
						echo(sprintf('<h5 class="card-title"> %s </h5>', $revision["date"]));
						$longText = getRevisionText($revision)["content"];
						echo(sprintf('<p class="card-text">%s</p>', $longText));
					?>
				</div>
			</div>
		</div>
	<?php } ?>
</div>

<?php 
	include("footer.php");
?>


