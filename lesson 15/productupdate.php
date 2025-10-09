<?php

include_once('config.php');

if(isset($_POST['update']))
{
	$id = $_POST['id'];
	$title = $_POST['title'];
	$description = $_POST['description'];
	$quantity = $_POST['quantity'];
	$price = $_POST['price'];

    if(empty($title) || empty($desription) || empty($quantity) || empty($price))
    {
        echo "You need to fill all the fields";
        header( "refresh:2; url=product.php");
    }
    else
    {
	     $sql = "UPDATE product SET description=:description, title=:title, quantity=:quantity, price=:price WHERE id=:id";
	$updateSql = $conn->prepare($sql);
	$updateSql->bindParam(':id', $id);
	$updateSql->bindParam(':title', $title);
	$updateSql->bindParam(':description', $description);
	$UpdateSql->bindParam(':quantity', $quantity);
	$UpdateSql->bindParam(':price', $price);

	$updateSql->execute();

	header("Location:product dashboard.php");
    }
}


?>
