<?php 
	include ("header.php");
	
	require_once("functions.php");
	
	if(checkIfLoggedIn() == true){
		header('Location: index.php');
		exit;
	}
	else{
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			logIn();
			header('Location: index.php');
			exit;
		}
		else{
			echo('<h2>Innlogging</h2>
				<form action=');
				echo(htmlspecialchars($_SERVER["PHP_SELF"]));
				echo(' method="post">
				<label>Brukernavn:</label>
				<input type="text" name="username">
				<label>Passord:</label>
				<input type="password" name="password">
				<input type="submit" value="Logg inn">
				</form>  ');
		}
	}
?>

Har du ikke bruker? <a href="registrer.php"> Registrer deg her </a>

<?php 
	include ("footer.php");
?>

