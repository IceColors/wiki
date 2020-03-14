<?php
	function checkIfLoggedIn(){
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		if(isset($_SESSION['username'])){
			return(true);
		}
		else{
			return(false);
		}
	}
	
	function logIn(){
		if(!isset($_SESSION)) { 
			session_start(); 
		} 
		$database = connect();
		if($_SERVER["REQUEST_METHOD"] == "POST"){
		
			$sql = sprintf('SELECT username, password, userid FROM users WHERE username = "%s"',
						   trim($_POST["username"]));
			$data = $database->query($sql);
			$rad = mysqli_fetch_array($data);
			
			if($rad){
				if($_POST['password'] == $rad["password"]){
					$_SESSION['username'] = $rad["username"];
					$_SESSION['password'] = $rad["password"];
					$_SESSION['userid'] = $rad["userid"];
				}
				else{
					echo "Feil brukernavn / passord";
				}
			}
			else{
				echo "Feil brukernavn / passord";
			}
		}
	}
	
	function logOut(){
		if(isset($_SESSION)) { 
			$_SESSION = array();
			session_destroy();
			header("location: login.php");
			exit;
		} 
	}
	
	function registrer(){
		if(!isset($_SESSION)) { 
			session_start(); 
		} 
		$database = connect();
		
		
		
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			
		
			$sql = sprintf('SELECT username FROM users WHERE username = "%s"',
						   trim($_POST["username"]));
			$data = $database->query($sql);
			$rad = mysqli_fetch_array($data);
			
			if($rad){
				echo("Brukernavnet eksisterer allerede");
				return false;
			}
			
			$sql = sprintf('INSERT INTO users (username, password, privilige) VALUES ("%s", "%s", "%s")', 
				$_POST["username"], $_POST["password"], "default"); 
			$database->query($sql);
			$_SESSION['username'] = $rad["username"];
			$_SESSION['password'] = $rad["password"];
			return true;
		}
		else {
			return false;
		}
	}
	
	function getRevisionMedia($revision){
		$database = connect();
		$mediaQuery = sprintf('SELECT name, path FROM media WHERE mediaid = %s', $revision["mediaid"]);
		$mediaData = $database->query($mediaQuery);
		$media = mysqli_fetch_assoc($mediaData);
		return($media);
	}
	
	function getRevisionText($revision){
		$database = connect();
		$textQuery = sprintf('SELECT textid, content FROM text WHERE textid = %s', $revision["textid"]);
		$textData = $database->query($textQuery);
		$text = mysqli_fetch_assoc($textData);
		return($text);
	}
	
	function getBestRevision($articleid = NULL){
		$database = connect();
		$database->set_charset("utf8");
		$articleQuery = "";
		if($articleid == NULL){
			$idArray = getNRandomArticleid(1);
			$articleQuery = sprintf('SELECT name, articleid, categoryid FROM articles WHERE articleid = %s', $idArray[0]);
		}
		else{
			$articleQuery = sprintf('SELECT name, articleid, categoryid FROM articles WHERE articleid = %s', $articleid);
		}
		
		$articleData = $database->query($articleQuery);
		$article = mysqli_fetch_assoc($articleData);
		
		$revisionQuery = sprintf('SELECT textid, date, userid, mediaid FROM revisions WHERE articleid = %s 
		ORDER BY date DESC', $article["articleid"]);
		$revisionData = $database->query($revisionQuery);
		$revision = mysqli_fetch_assoc($revisionData);
		return($revision);
	}
	
	function getNRandomArticleid($n){
		$database = connect();
		$database->set_charset("utf8");
		$articleQuery = sprintf('SELECT name, articleid, categoryid FROM articles  
			ORDER BY RAND ( )  
			LIMIT %s', $n);
		$articleData = $database->query($articleQuery);
	
		$idArray = array();
		while($article = mysqli_fetch_assoc($articleData)){
			$idArray[] = $article["articleid"];
		}
		return($idArray);
	}
	
	function connect(){
		return(mysqli_connect("localhost","root","","wiki"));
	}
?>

