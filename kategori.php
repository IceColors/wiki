<?php 
	include ("header.php");
	require_once("functions.php");
	
	function printChildren($database, $current){
		$childrenQuery = sprintf('SELECT categoryid, name FROM categories WHERE parentid = "%s"', 
		$current["categoryid"]);
		$childrenData = $database->query($childrenQuery);
		$len = mysqli_num_rows($childrenData);
		
		while($child = mysqli_fetch_assoc($childrenData)){
			$temp = "";
			if(checkIfLoggedIn()){
				$temp=sprintf('
				<form class="d-inline" method="post" action="">
				<input type="hidden" name="categoryid" value= "%s">
				<input type="text" name="name" value="%s">
				<input type="submit" name="submit" value="Bytt navn">
				<input type="submit" name="submit" value="Slett">
				</form>', $child["categoryid"], $child["name"]);
			}
			
			echo(sprintf('<li><i data-feather="folder"></i><a href = "?categoryid=%s"> %s </a> %s </li>', 
			$child["categoryid"], $child["name"], $temp));
		}
	}
	
	function printArticles($database, $current){
		$articleQuery = sprintf('SELECT name from articles WHERE categoryid = %s', $current["categoryid"]);
		$articleData = $database->query($articleQuery);
		$articleCount = mysqli_num_rows($articleData);
		
		while($article = mysqli_fetch_assoc($articleData)){
			echo(sprintf('<li><i data-feather="file-text"></i> %s </li>', $article["name"]));
		}
	}
	
	function treeRecursive($database, $ancestorVals, $currentIndex){
		if($currentIndex >= count($ancestorVals)){
			return;
		}		
		
		$current = $ancestorVals[$currentIndex];
		?>
		<li>
			<?php
				echo(sprintf('<i data-feather="folder"></i><a href = "?categoryid=%s"> %s </a>', 
				$current["categoryid"], $current["name"]));
			?>
			<ul class="nobull">
				<?php
					treeRecursive($database, $ancestorVals, $currentIndex+1);
					printArticles($database, $current);
					if($currentIndex + 1 >= count($ancestorVals)){
						printChildren($database, $current);
						if(checkIfLoggedIn()){
							echo(sprintf('
							<li><i data-feather="file-text"></i>
							<a href="createartikkel?categoryid=%s">Lag ny artikkel</a>
							</li>
							
							<li><i data-feather="folder"></i>
							<form class="d-inline" method="post" action="">
							<input type="text" name="name">
							<input type="hidden" name="parentid" value= "%s">
							<input type="submit" name="submit" value="Lag ny kategori">
							</form>
							</li>
							
							', $current["categoryid"], $current["categoryid"]));
						}
					}
				?>
			</ul>
		</li>
		<?php
	}
	
	if(isset($_POST["submit"])){
		if(checkIfLoggedIn()){
			// Hvis ikke kategori er valgt, gå ut ifra at vi er på kategori nr 1
			$categoryid = 1;
			$database = connect();
			
			// Ny kategori
			if(isset($_POST["submit"]) and isset($_POST["parentid"]) and $_POST["submit"] == "Lag ny kategori"){
				
				$insertQuery = sprintf('INSERT INTO categories (name, parentid) VALUES ("%s", %s)', $_POST["name"], $_POST["parentid"]);
				$database->query($insertQuery);
			}
			
			// Slett kategori
			else if (isset($_POST["submit"]) and $_POST["submit"] == "Slett"){
				$deleteQuery = sprintf('DELETE FROM categories WHERE categoryid = %s', $_POST["categoryid"]);
				$database->query($deleteQuery);
			}
			
			// Bytt navn på kategpri
			else if (isset($_POST["submit"]) and $_POST["submit"] == "Bytt navn"){
				$changeNameQuery = sprintf('UPDATE categories SET name = "%s" WHERE categoryid = %s', $_POST["name"], $_POST["categoryid"]);
				$database->query($changeNameQuery);
			}
		}
	}
	// Hvis ikke kategori er valgt, gå ut ifra at vi er på kategori nr 1
	$categoryid = "1";
	if(isset($_GET["categoryid"])){
		$categoryid = $_GET["categoryid"];
	}
	
	// Kobl til database med støtte for norsk
	$database = connect();
	
	
	$currentCategoryQuery = sprintf('SELECT categoryid, name, parentid FROM categories WHERE categoryid = "%s"', $categoryid);
	$currentCategoryData = $database->query($currentCategoryQuery);
	$row = mysqli_fetch_array($currentCategoryData);
	if($row){
		$categoryname = $row["name"];
		echo(sprintf("<h2> %s </h2>", $categoryname));
		
		$recursiveAncestorQuery = sprintf('
		WITH RECURSIVE cte AS (
		SELECT       
		categoryid, 
		name,
		parentid,
		1 as level
		
		FROM       
		categories
		WHERE categoryid = %s
		
		UNION ALL
		SELECT 
		c.categoryid, 
		c.name,
		c.parentid,
		d.level+1
		FROM 
		categories c, cte d
		WHERE
		c.categoryid = d.parentid
		)
		SELECT 
		* 
		FROM cte
		ORDER BY level DESC;
		', $row["categoryid"]);
		$ancestorData = $database->query($recursiveAncestorQuery);
		
		$ancestorVals = array();
		while($row = mysqli_fetch_assoc($ancestorData)){
			$ancestorVals[] = $row;
		}
		
		$len = count($ancestorVals);
		echo('<ul class="nobull">');
		treeRecursive($database, $ancestorVals, 0);
		echo('</ul>');
	}
	else{
		echo("<h2> Kategorien finnes ikke </h2>");
	}
?>
<?php 
	include ("footer.php");
?>