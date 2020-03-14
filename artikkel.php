<?php 
	include("header.php");
	require_once("functions.php");
	
	$database = connect();
	
	$articleQuery = "";
	if(isset($_GET["id"])){
		$articleQuery = sprintf('SELECT name, articleid, categoryid FROM articles WHERE articleid = %s', $_GET["id"]);
		
	}
	else{
		$articleQuery = sprintf('SELECT name, articleid, categoryid FROM articles  
		ORDER BY RAND ( )  
		LIMIT 1  ');
	}
	$articleData = $database->query($articleQuery);
	$article = mysqli_fetch_assoc($articleData);
	$revision = getBestRevision($article["articleid"]);
	$image = getRevisionMedia($revision);
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
	<div class="col-sm-10 col-md-8 col-lg-4 col-xl-4 order-lg-2">
		<img class="card-img-top" src="<?php  echo("/wiki" . $image["path"]); ?>" alt="Card image cap">
	</div>
	
	<div class="col-11 col-md-10 col-lg-7 col-xl-6">
		<h2>
			<?php
				echo($article["name"]);
				$revision = getBestRevision($article["articleid"]);
				$image = getRevisionMedia($revision);
			?>
		</h2>
		<?php
			
			$text = getRevisionText($revision);
			echo($text["content"]);
			
		?>
	</div>
	
</div>
<?php 
	include("footer.php");
?>
