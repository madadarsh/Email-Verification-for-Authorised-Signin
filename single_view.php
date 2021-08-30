
<?php require 'init.php';
// session_start();
if (!$_SESSION['email'] ){
	$userObj->redirect('login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contain</title>
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
                    <div class="panel-heading">Details panel</div>
                        <table class="table table-bordered">

    <?php
                $id = $_GET['id'];
                $sql = "SELECT * FROM details WHERE id = $id";
                $result = mysqli_query($conn, $sql);
                    
                    
                    
                    
                if (mysqli_num_rows($result) > 0){
                    while($user = mysqli_fetch_assoc($result)){?> 
                    <tr>
                        <th style="width:130px">S.No</th>
                        <td><?php echo $user['id']?></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo $user['fname'].' '.$user['lname']?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo $user['gender']?></td>
                    </tr>
                    <tr>
                        <th>DOB</th>
                        <td><?php echo $user['dob']?></td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td><?php echo $user['number']?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $user['email']?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?php echo $user['status']?></td>
                    </tr>
                <tr id="<?php echo $user['id'] ?>">
                    <td>
                        <a href="single_edit.php?id=<?php echo $user['id']?>" class="btn btn-block btn-xs btn-warning">Edit</a>
                        <!-- <a href="delete.php?id=<?php //echo $user['id']?>" class="btn btn-block btn-xs btn-danger remove">Delete</a> -->
                        <button class="btn btn-block btn-xs btn-danger remove">Delete</button>
                    </td>
                </tr>

             
                        </table>
                        <script type="text/javascript">
                            $(".remove").click(function(){
                            var id = $(this).parents("tr").attr("id");
                                if(confirm('Are you sure to remove this record ?'))
                                {
                                    $.ajax({
                                    url: 'delete.php',
                                    type: 'GET',
                                    data: {id: id},
                                    error: function() {
                                        alert('Something is wrong');
                                    },
                                    success: function(data) {
                                            $("#"+id).remove();
                                            // alert("Record removed successfully");  
                                    window.location.href="main.php";
                                    }
                                    });
                                }
                            });
                    </script>
                </div>          
                <?php }
                        }
                        ?>
            </div>
        </div>
    </div>
</body>
</html>