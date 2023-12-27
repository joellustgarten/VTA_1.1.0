<?php
require_once 'connection.php';
ob_start();

// If user click on sign up button in sign in page
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $userpwd = mysqli_real_escape_string($conn, $_POST['password']);
    $pwdrepeat = mysqli_real_escape_string($conn, $_POST['pwdrepeat']);
    $code = rand(999999, 111111);
    $status = 'notverified';

    if (emptyInput(0, $name, $email, $userpwd, $pwdrepeat,0 ,1) !== false) { //true, errors inside code
        header("Location: ../signup.php?error=emptyField");
        exit();
    }

    if (invalidValue($name, 1) !== false) { //true, errors inside code
        header("Location: ../signup.php?error=invalidName");
        exit();
    }

    if (invalidValue($email, 2) !== false) { //true, errors inside code
        header("Location: ../signup.php?error=invalidEmail");
        exit();
    }

    if (pwdMatch($userpwd, $pwdrepeat) !== false) { //true, errors inside code
        header("Location: ../signup.php?error=pwdMatchError");
        exit();
    }

    if (userExists($conn, $name, $email, 1) !== false) { //true, errors inside code
        header("Location: ../signup.php?error=userNameExists");
        exit();
    }

    createUser($conn, $name, $email, $userpwd, $code, $status);

// If user click on sign in button in login page
} else if (isset($_POST['login'])) {

    $name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $password = mysqli_real_escape_string($conn, $_POST['user_password']);

    if (emptyInput(0, $name, 0, $password, 0, 0, 4) !== false) { //true, errors inside code
        header("Location: ../login.php?error=emptyField");
        exit();
    } 

    loginUser($conn, $name, $password);
    
//if user click verification code submit button
} else if (isset($_POST['check'])) {
    $email = mysqli_real_escape_string($conn, $_POST['otpmail']);
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);

    if (emptyInput(0, 0, $email, 0, 0, $otp_code, 2) !== false) {
        header("Location: ../otpcode.php?error=emptyField");
        exit();
    }

    if (invalidValue($email, 2) !== false) { //true, errors inside code
        header("Location: ../otpcode.php?error=invalidEmail");
        exit();
    }

    checkOtp($conn, $email, $otp_code);

} else if (isset($_POST["resetsubmit"])) {
    $user = mysqli_real_escape_string($conn, $_POST["username"]);
    $resetpassword = mysqli_real_escape_string($conn, $_POST["resetpassword"]);
    $resetPWDrepeat = mysqli_real_escape_string($conn, $_POST["resetpwdrepeat"]);

    if (emptyInput(0,$user, 0, $resetpassword, $resetPWDrepeat, 0,3) !== false) {
        header("Location: ../forgotpass.php?error=emptyField");
        exit();
    }

    if (pwdMatch($resetpassword, $resetPWDrepeat) !== false) { //true, errors inside code
        header("Location: ../forgotpass.php?error=pwdMatchError");
        exit();
    }

    resetPassword($conn, $user, $resetpassword);

} else {
    header("Location: ../404.html");
    exit();
}

/* Functions */
function emptyInput($conn =0, $name =0, $email=0,  $password1 =0, $password2 =0, $code =0, $number)
{
    $result = true; // Check if leave without initialize
    switch ($number) {
        case 1:
            if (empty($name) || empty($email) || empty($password1) || empty($password2)) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        case 2:
            if (empty($email) || empty($code)) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        case 3:
            if (empty($name) || empty($password1) || empty($password2)) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        case 4:
            if (empty($name) || empty($password1)) {
                $result = true;
            } else {
                $result = false;
            }
            return $result;
        default:
            break;
    }
}

function invalidValue($value, $option)
{
    $result = true; // Check if leave without initialize
    if($option === 1){
        if (!preg_match('/^[a-zA-Z0-9_\s]*$/', $value)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    } else if ($option === 2){
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}

function pwdMatch($userpwd, $pwdrepeat)
{
    $result = true; // Check if leave without initialize
    if ($userpwd !== $pwdrepeat) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function userExists($conn, $name = 0, $email = 0, $type)
{
    $sql = "SELECT * FROM login WHERE name = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        if($type === 1){
            header("Location: ../signup.php?error=stmtFailed");
            exit();
        } else if ($type === 2){
            header("Location: ../login.php?error=stmtFailed");
            exit();
        } else if ($type === 3){
            header("Location: ../forgotpass.php?error=stmtFailed");
            exit();
        }
    }

    mysqli_stmt_bind_param($stmt, "ss", $name, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
    }
    mysqli_stmt_close($stmt);
    return $result;
}

function createUser($conn, $name, $email, $userpwd, $code, $status)
{
    $sql = "INSERT INTO login (name, email, password, code, status) VALUES(?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../signup.php?error=stmtFailed");
        exit();
    }

    //hashing psw if required
    $hashedPwd = password_hash($userpwd, PASSWORD_DEFAULT);

    // change $userpwd for $hashedPwd if hatching passwords
    mysqli_stmt_bind_param($stmt, 'sssis', $name, $email, $hashedPwd, $code, $status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: ../signup.php?error=success");
    exit();

}

function loginUser($conn, $name, $password) {

    $dbpassword = '';
    $dbemail = '';
    $dbstatus = '';

    $userExists = userExists($conn, $name, $name, 2);

    if ($userExists === false) {
        header("Location: ../login.php?error=wrongLogin");
        exit();
    } else {
        $dbpassword = $userExists['password'];
        $dbemail = $userExists['email'];
        $dbstatus = $userExists['status'];
    }
      
    $checkPwd = password_verify($password, $dbpassword); //use it when hashing paswords
    if ($checkPwd === false) {
        header("Location: ../login.php?error=wrongPwd");
        exit();
    } else if ($checkPwd === true) {
        if ($dbstatus == 'notverified') {
            header("Location: ../login.php?error=notVerified");
            exit(); 
        } else if ($dbstatus == "verified") {
            session_start();
            $_SESSION['username'] = $dbemail;
            header("Location: ../main.php");
            exit();
        }  
    }
}

function checkOtp($conn, $email, $otp_code)
{
    $check_code = "SELECT * FROM login WHERE email = '$email';";
    $code_res = mysqli_query($conn, $check_code);

    if (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $fetch_email = $fetch_data['email'];

        if ($fetch_email == $email){
            if($fetch_code == $otp_code) {
                $code = 0;
                $status = 'verified';
                $sql = "UPDATE login SET code=?, status=? WHERE email=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iss", $code, $status, $fetch_email);
                $stmt->execute();

                if ($stmt) {
                    header('Location: ../otpcode.php?error=codeVerified');
                    exit();
                } else {
                    header('Location: ../otpcode.php?error=codeVerificationError');
                    exit();
                }
            } else if($fetch_code != $otp_code){
                header('Location: ../otpcode.php?error=invalidCode');
                exit();
            }
        } else {
            header('Location: ../otpcode.php?error=codeEmailError');
            exit();
        }

    } else {
        header('Location: ../otpcode.php?error=invalidEmail');
        exit();
    }
}

function resetPassword($conn, $user, $password){
    $code = rand(999999, 111111);
    $status = 'notverified';
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    $check_user = userExists($conn, $user, $user, 3);

    if ($check_user === false) {
        header("Location: ../forgotpass.php?error=userDontExist");
        exit();
    } else if($check_user) {
        $fetch_name = $check_user['name'];
        $fetch_email = $check_user['email'];
        if($user === $fetch_name){
            $sql = "UPDATE login SET password=?, code=?, status=? WHERE name=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $hashedPwd, $code, $status, $user);
            $stmt->execute();

            if ($stmt) {
                header('Location: ../forgotpass.php?error=success');
                exit();
            } else {
                header('Location: ../forgotpass.php?error=codeVerificationError');
                exit();
            }
        } else if($user === $fetch_email){
            $sql = "UPDATE login SET password=?, code=?, status=? WHERE email=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siss", $password, $code, $status, $user);
            $stmt->execute();

            if ($stmt) {
                header('Location: ../forgotpass.php?error=success');
                exit();
            } else {
                header('Location: ../forgotpass.php?error=codeVerificationError');
                exit();
            }
        }
    }
}

