
<?php 
	include ("header.php");
	
	require_once("functions.php");
	
	if(checkIfLoggedIn() == true){
		header('Location: index.php');
		exit;
	}
	else{
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			registrer();
			header('Location: login.php');
			exit;
		}
		else{
			echo('<h2>Registrer</h2>
				<form action=');
				echo(htmlspecialchars($_SERVER["PHP_SELF"]));
				echo(' method="post">
                <label>Brukernavn:</label>
                <input type="text" name="username">
                <label>Passord:</label>
                <input type="password" name="password">
                <input type="submit" value="Registrer">
				</form>  ');
		}
	}
?>

Har du allerede en bruker? <a href="login.php"> Logg inn </a>

<?php 
	include ("footer.php");
?>

