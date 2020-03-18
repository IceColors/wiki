<?php
	require_once("functions.php");
	
	if(!checkIfLoggedIn()){
		header("location: index.php");
		exit;
	}
	
	if(!isset($_SESSION)) 
	{ 
		session_start(); 
	} 
	

	$database = connect();
	
	if(isset($_POST["title"])){
		echo("post sendt");
		$textQuery = sprintf('INSERT INTO text (content) VALUES ("%s")', $_POST["innhold"]);
		$database->query($textQuery);
		$textid = $database->insert_id;
		
		if(!empty($_FILES["image"]) and $_FILES["image"]["error"] === 0){
			$image = $_FILES["image"];
			if ($image['error'] !== 0) {
				if ($image['error'] === 1) 
				throw new Exception('Max upload size exceeded');
				
				throw new Exception('Image uploading error: INI Error');
			}
			if (!file_exists($image['tmp_name'])){
				throw new Exception('Image file is missing in the server');
			}
			$maxFileSize = 2 * 10e6; // = 2 000 000 bytes = 2MB
			if ($image['size'] > $maxFileSize){
				throw new Exception('Max size limit exceeded');
			}
			$imageData = getimagesize($image['tmp_name']);
			if (!$imageData){
				throw new Exception('Invalid image');
			}
			$mimeType = $imageData['mime'];
			$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
			if (!in_array($mimeType, $allowedMimeTypes)){
				throw new Exception('Only JPEG, PNG and GIFs are allowed');
			}
			move_uploaded_file($_FILES["image"]["tmp_name"], "media/" . $_POST["imageName"]);
			
			$mediaQuery = sprintf('INSERT INTO media (name, path, description, userid) VALUES ("%s", "%s", "%s", "%s")', $_POST["imageName"], "/media/" . $_POST["imageName"], $_POST["imageDescription"], $_SESSION["userid"]);
			$database->query($mediaQuery);
			$mediaid = $database->insert_id;
			
			$articleQuery = sprintf('INSERT INTO articles (name, categoryid, startdate, enddate) VALUES ("%s", %s, "%s", "%s")', $_POST["title"], $_GET["categoryid"], $_POST["startdato"], $_POST["sluttdato"]);
			$database->query($articleQuery);	
			$articleid = $database->insert_id;
			
			$revisionQuery = sprintf('INSERT INTO revisions (articleid, edittype, userid, textid, mediaid) VALUES (%s, "creation", %s, %s, %s)', $articleid, $_SESSION["userid"], $textid, $mediaid);
			$database->query($revisionQuery);
			/*
			header(sprintf('location: artikkel?id=%s', $articleid));
			exit;*/
		}
		header("location: index.php");
		exit;
	}
	
	
	include("header.php");
	$articleQuery = "";
	if(!isset($_GET["categoryid"])){
		echo("kategori ikke valgt");
		include("footer.php");
		exit;
	}
	
	
?>

<br>
<form action="", method="post", enctype="multipart/form-data">
	<div class="row justify-content-center">
		
		<div class="col-6">
			<div class="form-group">
				<input type="text" class="form-control" id="title" name="title" value="">
			</div>
			<div class="form-group">
				<label for="innhold">Innhold</label>
				<textarea class="form-control" id="innhold" name="innhold" rows="30">
				</textarea>
			</div>
			
		</div>
		
		<div class="col-3">
			<button class="btn btn-primary" type="submit">Opprett artikkel</button>
			<br>
			<br>
			<div class="form-group">
				<label for="Viktighet">Viktighet</label>
				<input type="text" class="form-control" id="Viktighet" name="imp" value="0">
			</div>
			<div class="form-group">
				<label for="Viktighet">Startdato (- for fvt., + for evt.)(eksempel: -07000421)</label>
				<input type="text" class="form-control" id="startdato" name="startdato" value="">
			</div>
			<div class="form-group">
				<label for="sluttdato">Sluttdato (- for fvt., + for evt.)(eksempel: -07000421)</label>
				<input type="text" class="form-control" id="sluttdato" name="sluttdato" value="">
			</div>
			<br>
			<img class="card-img-top" id="preview" src="media/Solid_grey.svg" alt="Card image cap">
			<div class="form-row">
				<div class="form-group col-6">
					<label for="imageName">Navn</label>
					<input type="text" class="form-control" name="imageName" id="imageName">
				</div>
				<div class="form-group col-6">
					<label for="imageDescription">Beskrivelse</label>
					<input type="text" class="form-control" name="imageDescription" id="imageDescription">
				</div>
			</div>
			<div class="custom-file">
				<input type="file" class="custom-file-input" name="image" id="image">
				<label class="custom-file-label" for="image">Velg bilde</label>
			</div>
		</div>
		
	</div>
</form>

<script>
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function(e) {
				$('#preview').attr('src', e.target.result);
			}
			
			reader.readAsDataURL(input.files[0]);
		}
	}
	
	$("#image").change(function(){
		readURL(this);
	});
</script>
<?php
	include("footer.php");
?>				