<?php 
	class Verify{

		protected $db;
		protected $user;

        public function __construct() {            
         	$this->db = Database::instance();
         	$this->user = new Users;
   		}

		public function generateLink(){
			return str_shuffle(substr(md5(time().mt_rand().time()), 0, 25));
		}
		public function verifyCode($code){
			return $this->user->get('verification', array('code' => $code));
		}
		public function authOnly(){
			$user_email = $_SESSION['email'];
			$stmt = $this->db->prepare("SELECT * FROM `verification` WHERE `user_email` = :user_email ORDER BY `createdAt` DESC");
			$stmt->bindParam(":user_email", $user_email, PDO::PARAM_STR);
			$stmt->execute();
			$user = $stmt->fetch(PDO::FETCH_OBJ);
			$files = array('verification.php','verifyCode.php');

			if(!empty($user)){
				if($user->status === '0' && !in_array(basename($_SERVER['SCRIPT_NAME']), $files)){
					$this->user->redirect('verification');
				}

				if($user->status === '1' && in_array(basename($_SERVER['SCRIPT_NAME']), $files)){
					$this->user->redirect('main.php');
				}
			}else if (!in_array(basename($_SERVER['SCRIPT_NAME']), $files)){
				$this->user->redirect('verification');
			}

		}

		public function sendToMail($email, $message, $subject){
			$mail  = new PHPMailer\PHPMailer\PHPMailer(true);
			$mail->isSMTP();
			$mail->SMTPAuth   = true;
			$mail->SMTPDebug  = 0;
			$mail->Host       = M_HOST;
			$mail->Username   = M_USERNAME;
			$mail->Password   = M_PASSWORD;
			$mail->SMTPSecure = M_SMTPSECURE;
			$mail->Port       = M_PORT;

			if(!empty($email)){
				$mail->From     = "Your Eamil ID";
				$mail->FromName = "Adarsh";
				$mail->addReplyTo('Want to receive reply to mail or ( Your Eamil ID )');
				$mail->addAddress($email);

				$mail->Subject = $subject;
				$mail->Body    = $message;
				$mail->AltBody = $message;

				if(!$mail->send()){
					return false;
				}else{
					return true;
				}
			}
		}
	}
?>
