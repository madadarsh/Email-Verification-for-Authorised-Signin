<?php
	require 'init.php';
 	$user_id = $_SESSION['email'];
	// $user    = $userObj->userData($user_id);
	// $verifyObj->authOnly();
	$email = $_GET['email'];
	$sql = "SELECT * FROM details WHERE email = $email";
	$result = mysqli_query($conn, $sql);


 
	if(isset($_POST['email'])){
		$link = Verify::generateLink();
		
    	$message = "{Your account has been created, Vist this link to verify your account : <a href='http://localhost/zentt/verification/{$link}'>Verify Link</a>";
    	$subject = "Account Verification";
    	$verifyObj->sendToMail($email, $message, $subject);
    	$userObj->insert('verification', array('user_email' => $email, 'code' => $link));
		// $userObj->redirect('verification?mail=sent');
    	echo '<script>alert(An verification email has been sent to your email, check your email to verify your account);</script>';   
		$userObj->redirect('registration.php');
	 }

    if(isset($_GET['verify'])){
    	$code = Validate::escape($_GET['verify']);
    	$verify = $verifyObj->verifyCode($code);

    	if($verify){
    		if(date('Y-m-d', strtotime($verify->createdAt)) < date('Y-m-d')){
    			$errors['verify'] = "Your verification link has been expired";
    		}else{
    			$userObj->update('verification', array('status' => '1'), array('user_email' => $email,'code' => $code));
    			$userObj->redirect('main.php');
    		}
    	}else{
    		$errors['verify'] = "Invalid verification link";
    	}
    }
?> 
<!DOCTYPE html>
<html>
<head>
	<title>Verification</title>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
<style>
	*{
	margin: 0px auto;
    font-family: 'Open Sans', sans-serif;
	}

	.body2{
 	
	 background-size: cover;
		overflow: auto;
	}
	
	.sign-up-wrapper{	
		width: 100%;	
		position: relative;
		top: 25%;
	}
	.sign-up-wrapper {
	display: flex;
	justify-content: center;
	align-items: center;
	resize: both;}
	.sign-up-inner{
		background: rgba(163,193,167,0.8);
		width: 50%;
		margin: 0px auto;
		height: auto;
		padding: 30px;	
	}

	.sign-up-div{
			
	}
	.sign-up-div span.error-in{
		background: rgb(107, 64, 82) none repeat scroll 0% 0%;
		padding: 4px;
		color: rgb(255, 255, 255);
		font-size: 14px;
		position: relative;
		left: 0%;
		top: -5%;
	}
	.sign-up-div span.error-in::after{
		content: '';
		position: absolute;
		border-style: solid;
		border-width: 0 10px 10px;
		border-color: rgb(107,64,82) transparent;
		display: block;
		width: 0;
		z-index: 1;
		top: -9px;
		left: 22px;
	}
	.sign-up-div input{
		width: 94%;
		margin: 10px 0px;
		padding: 12px;
		border:none;
		font-size: 20px;

	}
	.name input[type="text"]{
		width:45%;
	}

	.suc{
		padding: 12px;
		width: auto;
		font-weight: bolder;
		color: #fff;
		background-color:rgb(243,128,65);
		border: none;
		font-size: 20px;
		cursor: pointer;
	}
	.suc:hover{
		background-color:rgb(239, 123, 60);
	}
	.suc:active{
		background-color:rgb(239, 123, 60);

	}
</style>
</head>
<body class="body2">
<div class="p2-wrapper">
	<div class="sign-up-wrapper">
		<div class="sign-up-inner">
			<div class="sign-up-div">
				<div class="name">
				<?php 
					if(isset($_GET['verify']) || !empty($_GET['verify'])){
						if(isset($errors['verify'])){
							echo '<h4>'.$errors['verify'].'</h4>';
						}
					}else{
				?>
				<h4>Your account has been created, you need to activate your account by following</h4>
				<fieldset>
				<legend>Get the Email For Enterance And Verification </legend>
				<?php if(isset($_GET['mail'])):?>
					<h4>An verification email has been sent to your email, check your email to verify your account</h4>
				<?php else:?>
					<h3>Email verificaiton</h3>
					<form method="post">
					<input type="email" placeholder="<?php echo $email;?>" value="<?php echo $email;?>" />
	 				<button type="submit" name="email" class="suc">Send me verification email</button>
					</form>
			   <?php endif;?>
				</fieldset>
				</div>
 				<!-- Email error field -->
 				<?php if(isset($errors['email'])):?>
				 <span class="error-in"><b><?php echo $errors['email'];?></b></span>
			    <?php endif;
				}?>
			</div>
			</div>
	</div>
</div><!--WRAPPER ENDS-->
</body>
</html>