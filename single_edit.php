
<?php require 'init.php';
// session_start();
if (!$_SESSION['email'] ){
	$userObj->redirect('login.php');
}

$id = $_GET['id'];
$sql = "SELECT * FROM details WHERE id = $id";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Details page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
    <?php require_once 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">Control panel</div>
                        <ul class="list-group">
                            <li class="list-group-item"><a href="add_new.php">Add new Details</a></li>
                            <li class="list-group-item"><a href="main.php">View all Details</a></li>
                        </ul>
                </div>
            </div>
            <div class="col-lg-9 col-md-9">
            <div class="panel panel-default">
                    <div class="panel-heading">Add New Details</div>
                        <form action="" method="post">
                        <?php
                  
                            
                            if (mysqli_num_rows($result) > 0){
                                while($user = mysqli_fetch_assoc($result)){?>
                            <div class="form-group"><h4>
                                First Name:
                            </h4>
                                <input type="text" class="form-control input-sm" name="fname" placeholder="First Name" value="<?php echo $user['fname']?>">
                            </div>
                            <div class="form-group"><h4>
                                Last Name:
                            </h4>
                                <input type="text" class="form-control input-sm" name="lname" placeholder="Last Name" value="<?php echo $user['lname']?>">
                            </div>
                            <div class="form-group">
                                 <fieldset>
                                <legend>Gender Is: <?php echo $user['gender']?></legend>
                                <input id="male" type="radio" name="gender" value="<?php echo $user['gender']?>">
                                <label for="male">
                                    Male
                                </label>
                                <input id="female" type="radio" name="gender" value="female">
                                <label for="female">
                                    Female
                                </label> 
                            </fieldset>
                            </div>
                            <div class="form-group">
                                <h4>
                                    DOB: 
                                </h4>
                                <input type="text" class="form-control input-sm" value="<?php echo $user['dob']?>" name="dob" placeholder="dob">
                            </div>
                            <div class="form-group">
                                <h4>Email: 
                                </h4>
                                <input type="email" class="form-control input-sm" name="email" placeholder="email" value="<?php echo $user['email']?>">
                            </div>
                            <div class="form-group">
                                <h4>
                                    Mobile: 
                                </h4>
                                <input type="number" class="form-control input-sm" name="number" placeholder="Number" value="<?php echo $user['number']?>" max="9999999999" >
                            </div>
                            <div class="form-group">
                                <h4>
                                    Status: 
                                </h4>
                                <select name="status" id="marital_status">
                                <option value="<?php echo $user['status']?>"><?php echo $user['status']?></option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-sm btn-success" value="Update Details" name="update_det">
                            </div>
                            <?php }
                                }
                            else{
                                    echo '<script>alert("Enter your valid user name");</script>';
                                }
                        ?>
                        </form>
                </div>
            </div>
        </div>
    </div>
    <?php
if (isset($_POST['update_det'])){

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $status = $_POST['status'];

$sql = "UPDATE details SET fname = '$fname', lname = '$lname', gender = '$gender', dob = '$dob', number = '$number', email = '$email', status = '$status' WHERE id = '$id' ";

    if(mysqli_query($conn, $sql)){
        header('Location: main.php');
    }
else{
    echo "Error " .$sql. " <br>" . mysqli_error($conn);
}

}
?>
</body>
</html>