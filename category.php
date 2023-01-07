 <?php
  include 'partials/dbconnect.php';
$sql = "INSERT INTO `categories` ( `category_name`) VALUES ( '$category_name');";
$sql="SELECT*FROM books INNER JOIN categories ON books.category=categories.id"; 
$result = mysqli_query($mysqli, $sql);
if($mysqli){
    echo "connected";
}

?>

<form action="/loginsystem/category.php" method="post">
       
        <div class="form-group">
            <label for="category">category</label>
            <input type="text" class="form-control" id="category" name="category_name">
        </div>
       
         
        <button type="submit" class="btn btn-primary">submit</button>

     </form>
   