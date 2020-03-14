<?php 
	include ("header.php");
	require_once("functions.php");
?>
<h1> Forsiden </h1>
<h3> Tilfeldige artikler </h2>
<div class="row justify-content-center">
	<?php
		$database = connect();
		
		$nOfItems = 4;
		$idArray = getNRandomArticleid($nOfItems);
		
		for($i=0; $i<$nOfItems;$i++){
			if($nOfItems % 3 == 0){
				echo('<div class="col-sm-6 col-xl-4">');
			}
			else if($nOfItems % 4 == 0){
				echo('<div class="col-sm-6 col-xl-3">');
			}
			else{
				echo('<div class="col-sm-6">');
			}
			$articleQuery = sprintf('SELECT name FROM articles WHERE articleid = %s', $idArray[$i]);
			$articleData = $database->query($articleQuery);
			$article = mysqli_fetch_assoc($articleData);
			$revision = getBestRevision($idArray[$i]);
			$image = getRevisionMedia($revision);
		?>
		<div class="card m-2 h-100">
			<img class="card-img-top" style="height: 250px; object-fit: contain;" src="<?php  echo("/wiki" . $image["path"]); ?>" alt="Card image cap">
			<div class="card-body">
				<?php
					
					echo(sprintf('<h5 class="card-title"> %s </h5>', $article["name"]));
					$longText = getRevisionText($revision)["content"];
					$text = "";
					if(strlen($longText) > 100){
						$pos = strpos($longText, ' ', 100);
						$text = htmlspecialchars(substr($longText, 0, $pos));
					}
					else{
						$text = htmlspecialchars($longText);
					}
					
					
					
					echo(sprintf('<p class="card-text">%s [...]</p>
					<a href="artikkel?id=%s" class="btn btn-primary">Gå til artikkelen</a>', $text, $idArray[$i]));
				?>
			</div>
		</div>
	</div>
	<?php }
	
?>

</div>


<?php 
	include ("footer.php");
	?>												