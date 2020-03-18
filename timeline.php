<?php
	include("header.php");
	require_once("functions.php");
	
	function datostring($day, $month, $year){
		$result = "";
		$result = $result . $day;
		
		switch($month){
			case 1:
			$result = $result .  " Januar ";
			break;
			case 2:
			$result = $result . " Februar ";
			break;
			case 3:
			$result = $result . " Mars ";
			break;
			case 4:
			$result = $result . " April ";
			break;
			case 5:
			$result = $result . " Mai ";
			break;
			case 6:
			$result = $result . " Juni ";
			break;
			case 7:
			$result = $result . " Juli ";
			break;
			case 8:
			$result = $result . " August ";
			break;
			case 9:
			$result = $result . " September ";
			break;
			case 10:
			$result = $result . " Oktober ";
			break;
			case 11:
			$result = $result . " November ";
			break;
			case 12:
			$result = $result . " Desember ";
			break;
		}
		$result = $result . (string)$year;
		return($result);
	}
?>
<style>
	ul.timeline {
	list-style-type: none;
	position: relative;
	}
	ul.timeline:before {
	content: ' ';
	background: #d4d9df;
	display: inline-block;
	position: absolute;
	left: 29px;
	width: 2px;
	height: 100%;
	z-index: 400;
	}
	ul.timeline > li {
	margin: 20px 0;
	padding-left: 20px;
	}
	ul.timeline > li:before {
	content: ' ';
	background: white;
	display: inline-block;
	position: absolute;
	border-radius: 50%;
	border: 3px solid #22c0e8;
	left: 20px;
	width: 20px;
	height: 20px;
	z-index: 400;
	}
</style>
<?php
	$database = connect();
	
	$articleBCStartQuery = "SELECT importance, name, articleid, categoryid, substr(startdate, 2, 4) as startyear, substr(startdate, 6, 2) as startmonth, substr(startdate, 8, 2) as startday, substr(enddate, 1, 1) as minusorplus, substr(enddate, 2, 4) as endyear, substr(enddate, 6, 2) as endmonth, substr(enddate, 8, 2) as endday FROM `articles` WHERE startdate LIKE '-%' ORDER BY substr(startdate, 2, 4) DESC, substr(startdate, 6, 2),  substr(startdate, 8, 2);";
	$articleADStartQuery = "SELECT importance, name, articleid, categoryid, substr(startdate, 2, 4) as startyear, substr(startdate, 6, 2) as startmonth, substr(startdate, 8, 2) as startday, substr(enddate, 2, 4) as endyear, substr(enddate, 6, 2) as endmonth, substr(enddate, 8, 2) as endday FROM `articles` WHERE startdate LIKE '+%' ORDER BY substr(startdate, 2, 4) ASC, substr(startdate, 6, 2),  substr(startdate, 8, 2);";
	
	$articleBCStartData = $database->query($articleBCStartQuery);
	$articleADStartData = $database->query($articleADStartQuery);
	
?>


Dra slideren for å justere antall artikler
<div class="slidecontainer">
	<input type="range" min="0" max="15" value="0" class="slider" id="myRange">
</div>

<ul class="timeline">
	<?php
		while($article = mysqli_fetch_assoc($articleBCStartData)){
		?>
		<li class="timeelem" data-imp="<?php echo($article["importance"]); ?>">
			<a href="artikkel?id=<?php echo($article["articleid"]); ?>"><?php echo($article["name"]); ?></a>
			<p>
				<?php echo(datostring($article["startday"], $article["startmonth"], $article["startyear"]));  ?> fvt.
				- <?php echo(datostring($article["endday"], $article["endmonth"], $article["endyear"]));  ?>
				
				<?php
					if($article["minusorplus"] == "-"){
						echo("fvt.");
					}
					else{
						echo("evt.");
					}
				?>
			</p>
		</li>
		<?php
		}
	?>
	<?php
		while($article = mysqli_fetch_assoc($articleADStartData)){
		?>
		<li class="timeelem" data-imp="<?php echo($article["importance"]); ?>">
			<a href="artikkel?id=<?php echo($article["articleid"]); ?>"><?php echo($article["name"]); ?></a>
			<p><?php echo(datostring($article["startday"], $article["startmonth"], $article["startyear"]));  ?> evt. 
			</p>
			
		</li>
		<?php
		}
	?>
</ul>
<script>
	
	$(".timeelem").filter(function() {
		return $(this).data("imp") > $("#myRange").val();
	}).hide();
	$(".timeelem").filter(function() {
		return $(this).data("imp") <= $("#myRange").val();
	}).show();
	$("#myRange").change(function(value) {
		$(".timeelem").filter(function() {
			return $(this).data("imp") > $("#myRange").val();
		}).hide();
		$(".timeelem").filter(function() {
			return $(this).data("imp") <= $("#myRange").val();
		}).show();
	});
</script>
<?php
	include("footer.php");
?>			