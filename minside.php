<?php 
	include ("header.php");
	require_once("functions.php");
	
	if(checkIfLoggedIn() == false){
		echo("<h1> Ikke logget inn </h1>");
		header('Location: index.php');
		exit;
	}
	
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	$database = connect();
	$articleidQuery = sprintf('SELECT DISTINCT articleid FROM revisions WHERE userid="%s" ORDER BY articleid;',$_SESSION["userid"] );
	$articleidData = $database->query($articleidQuery);
	
?>
<h1> Min side</h1>
<div class="row">
	<div class="col-6">
		<h3>Artikler du har redigert:</h3>
		<?php
			while($articleid = mysqli_fetch_assoc($articleidData)){
				$articleid = $articleid["articleid"];
				$articleQuery = sprintf('SELECT name FROM articles WHERE articleid="%s"', $articleid);
				$articleData = $database->query($articleQuery);
				$article = mysqli_fetch_assoc($articleData);
			?>
			<a href="<?php echo("artikkel?id=" . $articleid) ?>">
				<?php
					echo($article["name"]);
				?>
			</a>
			<br>
			<?php
			}
		?>
	</div>
	<div class="col-6">
		<h3>Dine bilder</h3>
		<?php
			$mediaQuery = sprintf('SELECT name, timestamp, path, description FROM media WHERE userid="%s"',$_SESSION["userid"] );
			$mediaData = $database->query($mediaQuery);
			while($media = mysqli_fetch_assoc($mediaData)){
			?>
			<div class="card m-2">
				
				<img class="card-img-top" style="height: 250px; object-fit: contain;" src="<?php  echo("/wiki" . $media["path"]); ?>" alt="Card image cap">
				<div class="card-body">
					Beskrivelse: <?php
						echo($media["description"]);
					?>
					<br><br>
					Lastet opp:	<?php
						echo($media["timestamp"]);
					?>
				</div>
			</div>
			<?php
			}
		?>
	</div>
</div>
<?php 
	include ("footer.php");
?>