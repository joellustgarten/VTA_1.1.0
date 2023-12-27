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
        case "userDontExist":
            $error = "User / email dont exist";
            $class = "error_message";
            break;
        case "i":
            $error = "Invalid email";
            $class = "error_message";
            break;
        case "pwdMatchError":
            $error = "Passwords don't match";
            $class = "error_message";
            break;
        case "success":
            $error = "Success changing password. Go to <a href='login.php'><u>login</u></a>";
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
    <div class="container container_forgot">
        <h1 class="form_headline" data-i18n="forgot_title"></h1>
        <div class="upper_p">
            <p class="cont_p" data-i18n="forgot_text"></p>
            <a class="email_link" href="mailto: joel.lustgarten@br.bosch.com" data-i18n="email_link"></a>
        </div>
        <div class="<?php echo $class; ?>">
            <p>
                <?php echo $error ?>
            </p>
        </div>
        <form id="formSignup" action="./PHP/sign&log_in.php" method="post">
            <input class="text_field_signup" type="text" name="username" placeholder="User name or email">
            <input class="text_field_signup" type="password" name="resetpassword" placeholder="Password">
            <input class="text_field_signup" type="password" name="resetpwdrepeat" placeholder="Repeat password">
            <button class="submit_button" type="resetsubmit" name="resetsubmit" data-i18n="forgot_button"></button>
        </form>
        <div class="lower_p">
            <p class="cont_p member" data-i18n="member_title"></p>
            <a class="email_link" href="login.php" data-i18n="email_link"></a>
        </div>
    </div>
</div>

<?php
include_once 'footer.php';
?>