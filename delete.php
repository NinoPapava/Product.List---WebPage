<?php
    $conn = new PDO('mysql:host=localhost;port=3306;dbname=test', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(isset($_POST['delete-checkbox'])){

    if(isset($_POST['check_delete_multiple_btn']))
    {
        $all_id=$_POST['delete-checkbox'];
        $id = implode(',' , $all_id);
       
   
       //echo $id;
       $sql = "DELETE FROM products WHERE id IN($id)";
       $conn->exec($sql);
       header("Location: index.php");
       echo "Record deleted successfully";
    
      }
    
}  
else
{
   header("Location: index.php");
}
    
?>