<?php
  $pdo = require_once 'database.php';

    $statement = $pdo->prepare('SELECT * FROM products');
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once 'views/partials/header.php'; ?>
<link href="app.css" rel="stylesheet">
  
     <div class="progress-container">
      <div class="progress-bar" id="myBar"></div>
    </div>  
    

    <script>
// When the user scrolls the page, execute myFunction 
window.onscroll = function() {myFunction()};

function myFunction() {
  var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
  var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
  var scrolled = (winScroll / height) * 100;
  document.getElementById("myBar").style.width = scrolled + "%";
}
</script>

   <style>
    .progress-container {
  width: 100%;
  height: 8px;
  background: #ccc;
  position: fixed;
  top: 0;
  z-index: 1;
  width: 100%;
}

.progress-bar {
  height: 8px;
  background: #04AA6D;
  width: 0%;
}

   .grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto;
  gap: 40px;
  padding: 50px;
}
body{
  background-color: #636e72;
}

.grid-container > div {
  cursor: pointer;
  text-align: center;
  font-size: 15px;
  color: white;
}
.grid-container > div:hover{
  color: black;
}
footer {
  text-align: center;
  color: white;
  width: 100%;
}
.header{
  background: #353b48;
  z-index: 1;
}
.header h1{
  text-shadow: 2px 2px 5px black;
  color: white;
  transform: translate(10px, 10px);
  cursor: pointer;
}
.product-img{
  width: 120px;
}

   </style>
  
    <div class="header">
    <div class="wrapper">
    <h1>Product List</h1>
    </div>
   
</div>

  </head>

  <body>
  <div id = "wholepage">

  <a href="create.php" type="button" class="ADD-button">ADD</a>
<form action="delete.php" method="post">
<div class="grid-container">
    <?php foreach ($products as $i => $product ) { ?>
    <tbody>
    
    <button type="submit" name="check_delete_multiple_btn" class="delete-button">MASS DELETE</button>
   
        <div><br><input style="width:18px" type="checkbox" name="delete-checkbox[]" value="<?php echo $product['id'] ?>">

              <?php if($product['image']): ?>
                  <img src="<?php echo $product['image'] ?>" class="product-img"><br>
                <?php endif; ?>
              <?php
                echo $product['SKU'].'<br>';
                echo $product['Name'].'<br>';
                echo $product['Price']; echo " ($)".'<br>'; 
                if($product['size']){
                  echo "Size: "; echo $product['size']; echo " MB".'<br>';
                }
                if($product['weight']){
                  echo "Weight: "; echo $product['weight']; echo "KG".'<br>';
                }
                if($product['dimension']){
                  echo "Dimension: "; echo $product['dimension'];
                }
                 ?>
                </div>

     <?php } ?>

     </tbody>
     </div>
  
</form>

  <footer>
    <div>
     <p class="text-center">Scandiweb Test assigment</p>
    </div>
    </footer>

  </body>
</html>