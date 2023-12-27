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
            $error = "Please fill all fields";
            $class = "error_message";
            break;
        case "codeVerificationError":
            $error = "Could not verify code";
            $class = "error_message";
            break;
        case "invalidEmail":
            $error = "Invalid Email";
            $class = "error_message";
            break;
        case "codeEmailError":
            $error = "Could not verify email";
            $class = "error_message";
            break;
        case "invalidCode":
            $error = "invalid OTP code";
            $class = "error_message";
            break;
        case "codeVerified":
            $error = "Code verified, go to <a href='login_en.php'><u>Login</u></a>";
            $class = "ok_message";
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
    <div class="container container_otp">
        <h1 class="form_headline" data-i18n="otp_title"></h1>
        <div class="upper_p">
            <p class="cont_p" data-i18n="otp_text"></p>
            <a class="email_link" href="mailto:joel.lustgarten@br.bosch.com" data-i18n="email_link"></a>
        </div>
        <div class="<?php echo $class; ?>">
            <p>
                <?php echo $error ?>
            </p>
        </div>
        <form id="formOtp" action="./PHP/sign&log_in.php" method="post">
            <input class="text_field_signup" type="text" name="otpmail" placeholder="Valid Email">
            <input class="text_field_otp" type="number" name="otp" placeholder="Enter verification code" required>
            <button class="submit_button" type="check" name="check" data-i18n="otp_button"></button>
        </form>
        <div class="lower_p">
            <p class="cont_p member" data-i18n="verified_title"></p>
            <a class="email_link" href="login.php" data-i18n="email_link"></a>
        </div>
    </div>
</div>

<?PHP
include_once('footer.php');
?>