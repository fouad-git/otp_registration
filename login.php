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
        <h3 align="center">PHP Registratiion with Email Verification using OTP</h3>
        <br/>

        <?php
            if(isset($_GET["register"]))
            {
                if($_GET["register"] == 'success')
                {
                    echo '<h1 class="text-success">Email Successfully verified, Registration Process Completed...</h1>';
                }
            }
        ?>
    </div>
</body>
</html>