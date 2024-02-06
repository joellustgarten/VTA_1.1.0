<?PHP
include_once('unsigned_header.php');
ob_start();
?>

<?PHP

$error = "";
$class = "no_error_message";

if (isset($_GET['error'])) {
    $error = $_GET['error'];

    switch ($error) {
        case "emptyField":
            $error = "Please fill all data";
            $class = "error_message";
            break;
        case "wrongLogin":
            $error = nl2br("Invalid name or email\nTo create an account sign up <a href='signup.php'><u>here</u></a>");
            $class = "error_message";
            break;
        case "wrongPwd":
            $error = "Invalid password";
            $class = "error_message";
            break;
        case "stmtFailed":
            $error = "Could not connect to database";
            $class = "error_message";
            break;
        case "notVerified":
           $error = nl2br("Account not verified\nConfirm account info with OTP code <a href='otpcode.php'><u>here</u></a>");
           $class = "error_message";
            break;
        default:
            $error = "";
            $class = "no_error_message";
    }
} else {
    $error = "";
    $class = "no_error_message";
}


?>
<div class="main signUp">
    <div class="container container_login">
        <h1 class="form_headline" data-i18n="login_headline"></h1>
        <div class="upper_p">
            <p class="cont_p" data-i18n="login_text"></p>
            <a class="email_link" href="mailto: joel.lustgarten@br.bosch.com" data-i18n="email_link"></a>
        </div>
        <div class="<?php echo $class; ?>">
            <p>
                <?php echo $error ?>
            </p>
        </div>
        <form id="formSignin" action="./PHP/sign&log_in.php" method="post">
            <input class="text_field" type="text" name="user_name" placeholder="User name / Email" autocomplete="on">
            <input class="text_field" type="password" name="user_password" placeholder="Password">
            <button class="submit_button" type="login" name="login" data-i18n="login_button"></button>
        </form>
        <div class="lower_p">
            <p class="cont_p member" data-i18n="forgotpass_tittle"></p>
            <a class="email_link" href="forgotpass.php" data-i18n="forgotpass_link"></a>
        </div>
    </div>
</div>

<?php
include_once('footer.php');
?>