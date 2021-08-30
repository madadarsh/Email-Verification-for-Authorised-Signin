<?php require 'init.php';?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: #ffffff;
}

* {
  box-sizing: border-box;
}

.container {
  padding: 16px;
  background-color: white;
}


form {
    justify-content: center;
    align-items: center;
    text-align: inherit;
    margin: 20px 240px;
    padding: 40px;
    background: #4d6f70;
}


input[type=text], input[type=ratio], input[type=email], input[type=number] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}
input[type=text]:focus, input[type=date]:focus, input[type=ratio]:focus, input[type=email]:focus, input[type=number]:focus {
  background-color: #ddd;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

.registerbtn {
  background-color: #000000;
  color: white;
  padding: 16px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

.registerbtn:hover {
  opacity: 1;
}
a {
  color: dodgerblue;
}
.signin {
  background-color: #f1f1f1;
  text-align: center;
}
</style>
</head>
<body>

<form method="POST" enctype="multipart/form-data">
  <div class="container">
    <h1>Register</h1>
    <hr>
    <label for="fname"><b>First name</b></label>
    <input type="text" placeholder="First name" name="fname" id="fname" required>
    <br>
    <label for="lname"><b>Last name</b></label>
    <input type="text" placeholder="Last name" name="lname" id="lname" required>
    <br>
    <fieldset>
					<legend>Gender</legend>
					<input id="male" type="hidden" name="gender" value="" >
					<input id="male" type="radio" name="gender" value="male" required>
					<label for="male">
						Male
					</label>
					<input id="female" type="radio" name="gender" value="female">
					<label for="female">
						Female
					</label> 
				</fieldset>
        <br>
				<label for="birthday">DOB:</label>
       <input type="date" id="birthday" name="dob" required>
        <br>
        <br>
        <label for="Address">Address:</label>
        <textarea name="address" rows="3" cols="50"></textarea>
        <br>
        <br>
        <label for="mobile">Mobile:</label>
        <input type="number" id="number" name="number" required>
        <br>
    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" id="email" required>
    <hr>
    <br>
    <fieldset>
            <legend>Hobbies</legend>
            <input type="checkbox" name="hobby[]" value="sports" id="sport">
            <label for="sport">Sports</label>
            <input type="checkbox" name="hobby[]" value="music" id="music">
            <label for="music">Music</label>
            <input type="checkbox" name="hobby[]" value="reading" id="read">
            <label for="read">Reading</label>
        </fieldset>
        <br>

        <label for="profile"><b>Profile Image</b></label>

        <input type="file" name="uploadfile" value=""/>
        <br>
        <br>
        <br>
        <select name="status" id="marital_status" required>
          <option value="">-Select Marital Status-</option>
          <option value="Single">Single</option>
          <option value="Married">Married</option>
          <option value="Divorced">Divorced</option>
        </select>
        <br>
    <button type="submit" name="submit" class="registerbtn">Register</button>
  </div>
  <div class="container signin">
    <p>Already have an account? <a href="login.php">Sign in</a>.</p>
  </div>
</form>


<?php
if (isset($_POST['submit'])){

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $originalDate = $_POST['dob'];
    $dob = date("Y-m-d", strtotime($originalDate));
    $address = $_POST['address'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $hobby = implode(",",$_POST['hobby']);
    $status = $_POST['status'];
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];    
    $imageFileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));

      if($imageFileType == "jpg" || $imageFileType == "jpeg") {
          $folder = "images/".$filename;
          $sqle = "INSERT INTO details (fname, lname, gender, dob, address, number, email, hobby, status, imgs) VALUES ('$fname', '$lname', '$gender', '$dob', '$address', $number, '$email', '$hobby', '$status', '$filename')";
          mysqli_query($conn, $sqle);
          $sql = "SELECT * FROM details WHERE email = '$email' ";
          $result = mysqli_query($conn, $sql);
            
          if (mysqli_num_rows($result) > 0){
              while($user = mysqli_fetch_assoc($result)){
                if( $email == $user['email'] ){
                $_SESSION['email'] = $email;
                  if(mysqli_query($conn, $sql)){
                    header('Location: verification.php?email='.$user['email']);
                  }
                else{
                    echo "Error " .$sql. " <br>" . mysqli_error($conn);
                }
              }
            }
          }
      }
  else{
    echo '<script>alert("File Uploding Format is wrong")</script>';
  }
}
?>
</body>
</html>
