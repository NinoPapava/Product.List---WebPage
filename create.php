<?php
  $pdo = require_once 'database.php';

$errors = [];

$SKU = '';
$Name = '';
$Price = '';
$size = '';
$weight = '';
$dimension = '';

function generateKey() {
  $keyLength = 8;
  $str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $randStr = substr(str_shuffle($str), 0, $keyLength);
  return $randStr;
  
}
function randomString($n)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $str = '';
  for($i = 0; $i < $n; $i++){
    $index = rand(0, strlen($characters)-1);
    $str .= $characters[$index];
  }
  return $str;
}

if($SKU == ''){
  $SKU = generateKey();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $Name=$_POST['name'];
  $Price=$_POST['price'];
  $size=$_POST['size']; 
  $weight=$_POST['weight']; 
  $dimension=$_POST['dimension'];

  $image = $_FILES['image'] ?? null;
  $imagePath = '';

  if(!is_dir('images')){
    mkdir('images');
  }

  if($image){
    $imagePath = 'images/' . randomString(5) .'/'.$image['name'];
    mkdir(dirname($imagePath));
    move_uploaded_file($image['tmp_name'], $imagePath);
  }
  
  if(!$Name) {
    $errors[] = 'Product name is required';
  }
  if(!$Price) {
    $errors[] = 'Product price is required';
  }
  
  if(empty($errors)){
    $statement = $pdo->prepare("INSERT INTO products (image, sku, name, price, size, weight, dimension)
            VALUES(:image, :SKU, :Name, :Price, :size, :weight, :dimension)");
  
  // $statement->bindValue(':SKU', $SKUpath);
  $statement->bindValue(':SKU', $SKU);
  $statement->bindValue(':Name', $Name);
  $statement->bindValue(':image', $imagePath);
  $statement->bindValue(':Price', $Price);
  $statement->bindValue(':size', $size);
  $statement->bindValue(':weight', $weight);
  $statement->bindValue(':dimension', $dimension);

  
  $statement->execute();
  header('Location: index.php');
  }

}



?>
<?php require_once 'views/partials/header.php'; ?>
<link href="createApp.css" rel="stylesheet">
   
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script type="text/javascript"> 
      $(document).ready(function(){
        $("select").change(function(){
          $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
              $(".box").not("." + optionValue).hide();
              $("." + optionValue).show();
            }
            else
            {
              $(".box").hide();
            }
          });
        }).change();
      });
    </script>

</head>
<body>

  <style type="text/css">
  body{    background-color: #636e72;
    color: white;
  }
  
    .one{
     font-size: 15px; color: white;
    }
    .header{
      background: #353b48;
    }
    .header h1{
      color: white;
      text-shadow: 2px 2px 5px black;
      transform: translate(150px, 20px);
    }
    .two{
     font-size: 15px; 
      color: white;
    }
    .three{
     font-size: 15px; color: white;
    }
    .all-label{
      transform: translate(300px, 30px);
    }
    
  </style>
   <?php if(!empty($errors)): ?>
          <div class="alert alert-danger">
              <?php foreach ($errors as $error): ?>
                 <div><?php echo $error  ?></div>

                <?php endforeach; ?>

              </div>
      <?php endif; ?>

      <div class="header" style="width: 100%;">
      <div class="wrapper">
      <h1>ADD Product</h1>
   
      </div>
  </div>
  <div id = "wholepage" style="width: 470px">
<form method="post" enctype="multipart/form-data">

  <a href="cansel.php" type="reset" name="cansel" class="cansel-button">Cansel</a>

  <br><br><div class="all-label">

  <div class="form-group">
    <label>Product Image</label><br>
    <input type="file" name="image" > 
  </div><br>

  <div class="form-group" id="sku">
    <label>SKU</label><br>
    <input type="text" class="form-control" name="sku" value="<?php echo $SKU  ?>" readonly> 
  </div><br>

  <div class="form-group" id="name">
    <label>Name</label>
    <input type="text" class="form-control" name="name" value="<?php echo $Name  ?>">
  </div><br>

  <div class="form-group" id="price">
    <label>Price ($)</label>
    <input type="number" step=".01" class="form-control" name="price" value="<?php echo $Price  ?>">
  </div><br><br>

  <select class="select" style="width: 200px" >
    <option selected>Type_Switcher...</option>
    <option value="one" >DVD-Disk</option>
    <option value="two">Book</option>
    <option value="three">Furniture</option>
  </select><br><br>

  <div class="one box">
    <label>Size (MB):</label>
    <input type="text" id="dvd-option" name="size" value="<?php echo $size  ?>">
  </div>

  <div class="two box">
    <label>Weight (KG):</label>
    <input type="text" id="book-option" name="weight" value="<?php echo $weight  ?>">
  </div>

  <div class="three box">
   <label>Dimension (Height/width/length):</label>
    <input type="text" id="furniture-option" name="dimension" value="<?php echo $dimension  ?>">
  </div>
  </div>
              

  <button type="submit" name="save" class="save-button">Save</button>

  </div>
  <br><br><br>
  </form>

  <footer style="width: 100%;">
    <div>
     <p class="text-center">Scandiweb Test assigment</p>
    </div>
    </footer>

  </body>
</html>