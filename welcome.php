<?php
session_start();
include 'controller.php';

$obj = new controller();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $obj->insert_in_db($_POST,"books");
}

if(isset($_GET["d_id"])){
  echo $_GET["d_id"];
    $obj->delete_in_db("books",$_GET["d_id"]);
  }


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Welcome - <?php $_SESSION['username']?></title>
  </head>
  <body>
    <?php require 'partials/_nav.php' ?>
    
    <div class="container my-3">
    <div class="alert alert-success" role="alert">
      <h4 class="alert-heading">Welcome - <?php echo $_SESSION['username']?></h4>
      <p>Hey how are you doing? Welcome to myApp You are logged in as <?php echo $_SESSION['username']?>. Aww yeah, you successfully read this important alert message. </p>
      <hr>
      <!-- <p class="mb-0">Whenever you need to, be sure to logout <a href="/loginsystem/logout.php"> using this link.</a></p> -->
    </div>

    
    <form action="" method="post" name="form1" id="myForm" enctype="multipart/form-data">
      
       
  <div class="form-group">
    <label for="exampleInput">TITLE</label>
    <input  type="text" name="title" class="form-control" id="exampleInputEmail1" >
   
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">AUTHOR</label>
    <input type="text" name="author" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">LANGUAGE</label>
    <input type="text" name="language" class="form-control" id="exampleInputPassword1">
  </div>
  <div class="form-group">
    <label for="exampleInput">CATEGORY</label>
    <input type="text" value="1" name="category" class="form-control" >
  </div>
  <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
  <input type="submit" class="btn btn-primary"  value="submit" > <a href="display.php">SHOW RECORDS</a>
</form>
   


    

  </div>

  <?php
echo $obj->table_data('books',0);
  ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>