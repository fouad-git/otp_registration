<?php
try{

    $connect = new PDO("mysql:host=localhost;PORT=3308;dbname=registrations","root","",  array(PDO::ATTR_PERSISTENT => true));
    $error_user_otp  = '';
    $user_activation_code = '';
    $message = '';
    if(isset($_GET["code"]))
    {
        $user_activation_code = $_GET["code"];
        if(isset($_POST["submit"]))
        {
            if(empty($_POST["user_otp"])
            {
                $error_user_otp = 'Enter OTP Number';
            }else
            {
                $query = "SELECT * FROM register_user WHERE user_activation_code = '".$user_activation_code."' AND user_otp ='".trim($_POST["user_otp"])."'
            ";
            $statement = $connect->prepare($query);
            $statement->execute();
            $total_row = $statement->rowCount();
            if($total_row > 0)
            {
                $query = "UPDATE register_user SET user_email_status = 'verified' WHERE user_activation_code = '".$user_activation_code."'";
                
                $statement = $connect->prepare($query);
                if($statement->execute())
                {
                    header('location:login.php?register=success');
                }
            }
            else{
                $message = '<label class="text-danger">Invalid OTP Number</label>';
            }
            
        }
    }
}
else{
    
}
}catch (Exception $e) {
    echo "Failed: " . $e->getMessage();
    $dbh->rollBack();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="http://code.jquery.com/jquery.js"></script>
    <title>PHP registration with Email verification using OTP</title>
</head>
<body>
    <div class="container">
        <h3 align="center">PHP registration with Email verification using OTP</h3>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">registration</h3>
            </div>
            <div class="panel-body">
            <?php echo $message;?>
                 <?php echo $message; ?>
                <form action="" method="post">
                <div class="form-group">
                    <input type="text" name="user_otp" id="" class="form-control">
                    <?php echo $error_user_otp;?>
                </div>
                <div class="form-group">
                    <input type="submit" name= "submit" value="Submit" class="btn btn-success">
                </div>
                <p></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>