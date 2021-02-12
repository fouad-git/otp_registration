<?php
require_once  "./vendor/autoload.php";
// try{
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

   require_once "class/db.php";

  
    $message= '';
    $error_user_name= '';
    $error_user_email= '';
    $error_user_password= '';
    $user_name = '';
    $user_email = '';
    
    // // vérification coté back
    
    if(isset($_POST["register"]))
    {
        if(empty($_POST["user_name"]))
        {
            $error_user_name = "<label class='text-danger'>Enter Your Name</lable>";
        }else
        {
            $user_name = trim($_POST["user_name"]);
            $user_name = htmlentities($user_name);
        }

        if(empty($_POST["user_email"]))
        {
            $error_user_email = "<label class='text-danger'>Enter Email Address</lable>";
        }else
        {
            $user_email = trim($_POST["user_email"]);
            if(!filter_var($user_email, FILTER_VALIDATE_EMAIL))
            {
                $error_user_email = '<label class="text-danger">Enter Valid Email Address</label>';
            }
        }

        if(empty($_POST["user_password"]))
        {
            $error_user_password ='<label class="text-danger">Enter password</label>';
        }else{
            $user_password = trim($_POST["user_password"]);
            $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        }

   
        if($error_user_name == '' && $error_user_email == '' && $error_user_password == '')
        {
            $user_activation_code = md5(rand());
            $user_otp = rand(100000, 999999);
            $data = array(
                ':user_name' => $user_name,
                ':user_email' => $user_email,
                ':user_password' => $user_password,
                ':user_activation_code' => $user_activation_code,
                ':user_email_status' => 'not verified',
                ':user_otp' => $user_otp
            );
            $query = "INSERT INTO register_user(user_name, user_email, user_password, user_activation_code, user_email_status, user_otp)
            SELECT * FROM (SELECT :user_name, :user_email, :user_password, :user_activation_code, :user_email_status, :user_otp) AS tmp
            WHERE NOT EXISTS (SELECT user_email FROM register_user WHERE user_email = :user_email) LIMIT 1 ";
            $statement = $connect->prepare($query);
            $statement->execute($data);
            var_dump($data);
   
            
            if($connect->lastInsertId() > 0)
            {
                $message =  "<label class='text-danger'>Email Already Register</lable>";
            }
            else{
                // require 'class/class.phpmailer.php';
                // require 'class/class.smtp.php';
                //  require 'class/class.exception.php';
                // require("phpmailer/phpmailer/src/PHPMailer.php");
                // require("phpmailer/phpmailer/scr/SMTP.php");
                // require("phpmailer/phpmailer/src/Exception.php");

                $mail = new PHPMailer(true);
                $mail->SMTPDebug = 2;
                $mail->CharSet =  "utf-8";
                $mail->IsSMTP();
                $mail->HOST = 'smtp.mailtrap.io';
                $mail->SMTPAuth = false;
                $mail->Username = 'e8ad8af399ee11';
                $mail->Password = 'd51291c8dd4a67';
                //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       =  25; 
                $mail->From = 'fouad.lyousfi@hotmail.com';
                $mail->FromName = 'Fouad';
                $mail->Addaddress($user_email);
                $mail->IsHTML(true);
                $mail->Subject = 'Verification code for verify your email Address';
                $message_body = '<p>For verify your email address, enter this verification code whene prompted: <b>'.$user_otp.'</b>. </p>
                <p>Sincerely, </p>
                <p>Fouad Lyousfi</p>';
                $mail->Body = $message_body;
                
                if($mail->Send())
                {
                    echo '<script>alert("Please check Your email for verification code")</script>';
                    header('location: email_verify.php?code='.$user_activation_code);
                }else{
                    $message = $mail->ErrorInfo;
                }
            }
        }
    }
// }catch(Exception $e) {
//         $connect->rollBack();
//         echo "Failed: " . $e->getMessage();
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="http://code.jquery.com/jquery.js"></script>
    <title>registration with Email verification using OTP</title>
</head>
<body>
    <div class="container">
        <h3 align="center">registration </h3>
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"></h3>
        </div>
        <div class="panel-body">
        <?php echo $message; ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Enter Your Name</label>
                    <input type="text" name="user_name" id="" class="form-control">
                    <?php echo $error_user_name;?>
                </div>
                <div class="form-group">
                    <label for="">Enter Your Email</label>
                    <input type="email" name="user_email" id="" class="form-control">
                    <?php echo $error_user_email;?>
                </div>
                <div class="form-group">
                    <label for="">Enter Your password</label>
                    <input type="password" name="user_password" id="" class="form-control">
                    <?php echo $error_user_password;?>
                </div>
                <div class="form-group">
                <input type="submit" name="register" value="click to register" class="btn btn-success">
                </div>
            </form>
        </div>
        </div>
    </div>
</body>
</html>