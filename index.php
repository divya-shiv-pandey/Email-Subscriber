<!DOCTYPE html>
<html>
<style>
    /*set border to the form*/

    form {
        border: 3px solid #f1f1f1;
    }

    /*assign full width inputs*/

    input[type=text],
    input[type=password] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /*set a style for the buttons*/

    button {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
    }

    /* set a hover effect for the button*/

    button:hover {
        opacity: 0.8;
    }

    /*set extra style for the cancel button*/

    .cancelbtn {
        width: auto;
        padding: 10px 18px;
        background-color: #f44336;
    }

    /*centre the display image inside the container*/

    .imgcontainer {
        text-align: center;
        margin: 24px 0 12px 0;
    }

    /*set image properties*/

    img.avatar {
        width: 40%;
        border-radius: 50%;
    }

    /*set padding to the container*/

    .container {
        padding: 16px;
    }

    /*set the forgot password text*/

    span.psw {
        float: right;
        padding-top: 16px;
    }

    /*set styles for span and cancel button on small screens*/

    @media screen and (max-width: 300px) {
        span.psw {
            display: block;
            float: none;
        }

        .cancelbtn {
            width: 100%;
        }
    }
</style>

<head>
    <title>XKCD Subscribe</title>
</head>

<body>
    <div id="header">
        <h3 style="text-align:center;">XKCD Comics Subscriber</h3>
    </div>

    <div id="wrap">
        <?php

        include_once dirname(__FILE__).'/config.php';
        $color = 'color:green;';

        $name = $email  = "";
        if (isset($_POST['name']) && !empty($_POST['name']) and isset($_POST['email']) && !empty($_POST['email'])) {
            $name = $conn->real_escape_string($_POST['name']);
            $email = $conn->real_escape_string($_POST['email']);
            $hash = md5(rand(0, 1000));
            $count = 1;

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msg = 'The email you have entered is invalid, please try again.';
                $color = 'color:red;';
            } else {

                //check if email already exits in db
                if ($result = $conn->query("SELECT * FROM users WHERE email = '$email' and active is NOT NULL")) {
                    $count = $result->num_rows;
                }
                if ($count == 0) {
                    //send email if new email

                    if ($conn->query("SELECT * FROM users WHERE email = '$email' and active is NULL")->num_rows == 1) {
                        $conn->query("UPDATE users set name = '$name', hash = '$hash' where email = '$email'");
                        $msg = 'Verifification email has been resent, Name updated successfully!';
                        $color = 'color:green;';
                    } else {
                        mysqli_query($conn, "INSERT IGNORE INTO users (name, email, hash) VALUES('" . $name . "', '" . $email . "', '" . $hash . "') ");
                        $msg = 'Verifification email sent to '."$email".' successfully! Activate your account to enroll for comics.';
                        $color = 'color:green;';
                    }


                    $mail->addAddress($email, $name);
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                        $verify = 'https';
                    } else {
                        $verify = 'http';
                    }
                    $verify .= '://';
                    $mail->isHTML(true);
                    $mail->Subject = 'Account Verification ';
                    $mail->Body    = 'Hello, ' . $name . '<br>';
                    $mail->Body    .= 'Please verify your email to subscribe to XKCD Comics very 5 minutes for free.<br> ';
                    $mail->Body    .= $verify . $_SERVER['HTTP_HOST'] . '/verify.php?id=' . $hash . "\r\n";
                    if (!$mail->send()) {
                        $msg = 'Verifification email failed, try again later!';
                        $color = 'color:red;';
                    }
                } else {
                    $msg = 'Already subscribed with this email!';
                    $color = 'color:red;';
                }
            }
        }

        ?>
        <div class="form-group">
        </div>


        <!--Step 1 : Adding HTML-->
        <form action="" method="post">
            <div class="imgcontainer">
                <img src="https://xkcd.com/s/0b7742.png" alt="Avatar">
            </div>

            <div class="container">
                <label><b>Name</b></label>
                <input type="text" placeholder="Enter Name" name="name" required>

                <label><b>Email</b></label>
                <input type="text" placeholder="Enter Email Address" name="email" required>

                <?php
                if (isset($msg)) {  // Check if $msg is not empty
                    echo '<div style=' . $color . '>' . $msg . '</div>'; // Display our message and wrap it with a div with the class "statusmsg".
                }
                ?>

                <button type="submit">Subscribe</button>
            </div>

        </form>

</body>

</html>