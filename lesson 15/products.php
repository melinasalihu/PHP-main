<?php

include_once('config.php');

if(isset($_POST['submit']))
{
    $title = $_POST{'title'};
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if(empty($title) || empty($description) || empty($quantity) || empty($price))
    {
        echo "You need to fill all the fields";
    }
    else
    {
        $sql = "SELECT title FROM products WHERE title=:title";

        $tempSQL = $conn->prepare($sql);
        $tempSQL->bindParam(':title',$title);
        $tempSQL->execute();

        if($tempSQL->rowCount() > 0)
        {
            echo "title exist";
            header("refresh:2; url=addProducts.php");
        }
        else
        {
    $sql = "insert into products (title, description,quantity,price) values (:title, :description, :quantity, :price)";
    $insertSql = $conn->prepare($sql);

    $insertSql->bindParam()
        }
    }
}