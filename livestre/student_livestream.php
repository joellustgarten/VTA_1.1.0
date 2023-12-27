<?PHP
session_start();
include '../PHP/connection.php';

if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['topic'])) {
        $link = $_POST['topic'];
    }

    if (isset($_POST['participant'])) {
        $participant = $_POST['participant'];
    }

    if (isset($_POST['start_day'])) {
        $date_start = $_POST['start_day'];
    }

    if (isset($_POST['end_day'])) {
        $date_ends = $_POST['end_day'];
    }

if(emptyInput($link, $participant, $date_start, $date_ends)) {
    header('Location:index.php?errors=fields');
    exit();
}


if(inserDBdata($conn, $link,$participant, $date_start, $date_ends)){
    header('Location:index.php?errors=no_error');
} else {
    header('Location:index.php?errors=updateDBerror');
}

}


function emptyInput($link, $participant, $date_start, $date_ends) {
$result = true;
if(empty($link) || empty($participant) || empty($date_start) || empty($date_ends)) {
    $result =  true;
} else {
    $result = false;
}
return $result;
}


function inserDBdata($conn, $link, $participant, $date_start, $date_ends){
    $sql = "INSERT INTO livestream (link, participant, start_day, end_day) VALUES(?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
       header("Location: index.php?errosr=stmtFailed");
       exit();
    }
 
    mysqli_stmt_bind_param($stmt, 'ssss', $link, $participant, $date_start, $date_ends);
    if (mysqli_stmt_execute($stmt)) {
       mysqli_stmt_close($stmt);
       return true;
    } else {
       return false;
    }  
}
?>