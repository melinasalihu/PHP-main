<?php 
	include_once('config.php');
	


	if (isset($_POST['submit1'])) {
		$id = $_POST['id'];
		$clothes_image = $_POST['clothes_image'];
		$clothes_rating = $_POST['clothes_rating'];
		$clothes_price = $_POST['movie_quality'];
		$clothes_quantity=$_POST['clothes_quantity'];
		

		$sql = "UPDATE clothes SET id=:id,  clothes_image=:clothes_image, clothes_rating=:clothes_rating, clothes_price=:clothes_price,clothes_quantity	=:clothes_quantity WHERE id=:id";

		$prep = $conn->prepare($sql);
		$prep->bindParam(':id',$id);
		$prep->bindParam(':clothes_image',$clothes_image);
		$prep->bindParam(':clothes_rating',$clothes_rating);
		$prep->bindParam(':clothes_price',$clothes_price	);
		$prep->bindParam(':clothes_quantity',$clothes_quantity);
		
		$prep->execute();
		header("Location: list_movies.php");
	}
 ?>