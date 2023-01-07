<?php
include ('connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $product=$_POST['product'];
    $quantity=$_POST['quantity'];

    $sql="insert into 'crud' (name_product,price,quantity) values('$name', '$product', '$quantity')";
    $result=mysqli_query($con,$sql);
    if($result){
        echo "Data inserted successfully";
    }else{
        die(mysqli_error($con));
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <!--Bootstrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        body{font: 14px sans-serif;}
        .wrapper{width:360px; padding:20px}
    </style>
    <link href="style.css" rel="stylesheet">
</head>
  <body>
    HAHAHAH
    <div class="container m-4">
    <form method="post">
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" placeholder="Enter Your Name" name="name" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Product</label>
        <input type="text" class="form-control" placeholder="Enter Your Product of Choice" name="product" autocomplete="off">
      </div>
      <div class="form-group">
        <label>Quantity</label>
        <input type="number" class="form-control" placeholder="Enter The Quantities" name="quantity" autocomplete="off">
      </div>
      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>      
  </body>
</html>