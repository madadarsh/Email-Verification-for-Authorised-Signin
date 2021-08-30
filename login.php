<?php require 'init.php';
// session_start();
?>
<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> Login Page </title>  
<style>   
Body {  
  font-family: Calibri, Helvetica, sans-serif;  
  background-color: #ffffff;  
}  
button {
    background-color: #000000;
    width: 100%;
    color: white;
    padding: 15px;
    margin: 10px 0px;
    border: none;
    cursor: pointer;
}  
 form {   
        border: 3px solid #f1f1f1;   
      
    justify-content: center;
    align-items: center;
    text-align: inherit;
    margin: 20px 240px;
    padding: 40px;
    background: #4d6f70;

    }   
 input[type=email], input[type=password] {   
        width: 100%;   
        margin: 8px 0;  
        padding: 12px 20px;   
        display: inline-block;   
        border: 2px solid green;   
        box-sizing: border-box;   
    }  
 button:hover {   
        opacity: 0.7;   
    }   
  .cancelbtn {   
        width: auto;   
        padding: 10px 18px;  
        margin: 10px 5px;  
    }   
    .container {
  padding: 16px;
  background-color: white;
}
</style>   
</head>    
<body>    
    <center> <h1>Login Form </h1> </center>   
    <form method="POST">  
        <div class="container">   
            <label>Email : </label>   
            <input type="email" placeholder="Enter Email" name="email" required>  
            <button type="submit" name="login">Login</button>   
            
            <div class="container signin">
    <p>Dont'n have an account? <a href="registration.php"> Sign Up. </a>   
  </div>
        </div>   
    </form> 
    
    <?php 
        if(isset($_POST['login']) ){
    	$username = $_POST['email'];
    
    	$sql = "SELECT * FROM details WHERE email = '$username' ";
    	$result = mysqli_query($conn, $sql);
    	
    	if (mysqli_num_rows($result) > 0){
    	    while($user = mysqli_fetch_assoc($result)){
    	   if( $username == $user['email'] ){
    	       $_SESSION['email'] = $username;
               header('Location: main.php');
    	        } else{
    	            echo '<script>alert("Enter your valid Email Address");</script>';
    	        }  
    	    }
    	}
        }
    ?>
</body>     
</html>  