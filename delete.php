<?php
require 'init.php';
        
        $id = $_GET['id'];
        $sql = "DELETE FROM details WHERE id = '$id'";
        if(mysqli_query($conn, $sql)){
            header('Location: main.php');
        }
        else{
            echo "Error " .$sql. " <br>" . mysqli_error($conn);    
        }
?>
