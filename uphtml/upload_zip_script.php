<?PHP
session_start();
include '../PHP/connection.php';
if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}

$error = '';
$code;
$version = '';
$theme='';
$topic = '';
$resource = '';
$fullName = '';
$shortName = '';
$baseDirectory = '';
$directory = '';
$filePath = '';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['version'])) {
        $version = $_POST['version'];
    }

    if(isset($_POST['topic'])){
        $topic = $_POST['topic'];
    }

    if(isset($_POST['theme'])){
        $theme = $_POST['theme'];
    }
  
    if (isset($_POST['resource'])){
        $resource = $_POST['resource'];
    }
    
    $fullName = basename($_FILES["zipFile"]["name"]);
    $shortName = basename($_FILES["zipFile"]["name"],".zip");
    $baseDirectory = "../resources/" . $user . "/html/";
    $directory = "../resources/" . $user . "/html/". $shortName;
    $filePath = $directory."/".$fullName;
    
    if (!file_exists($directory)){ 
        mkdir($directory, 0777, true);
    }

    $message = uploadZip($filePath, $directory, $fullName, $shortName, $conn, $topic, $theme, $resource, $version, $user,);
    $error = $message[0];
    $code = $message[1];
    header('Location:index.php?error='.$error.'&code='.$code);
        
    
} 
function uploadZip($filePath, $directory, $fullName, $shortName,$conn, $topic, $theme, $resource, $version, $user)
{
    $response = array();

    $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    
    if ($fileType == "zip") { // Check if the file is a ZIP file

        if (!file_exists($filePath)) {  // Check if file already exists
            
            if ($_FILES["zipFile"]["size"] < 10485760) { // 10MB Check file size (you can adjust the size limit as needed)
                
                if(moveZip($filePath)){

                    if (extractZip($filePath, $directory)) {

                        array_push($response, "The file " . htmlspecialchars($fullName) . " has been uploaded.", 1);
                        if(!deleteZip($filePath)){
                            echo '<script>alert("Error deleting source file")</script>';
                        } else if (inserDBdata($conn, $topic, $theme, $resource, $version, $user, $shortName)){
                            echo '<script>alert("Error updating DB resource")</script>';
                        };
                        $fullName = '';
                        $shortName = '';
                        $baseDirectory = '';
                        $directory = '';
                        $filePath = '';
                        return $response;

                    } else {

                        array_push($response, "Error extracting file " . htmlspecialchars($fullName), 0);
                        return $response;

                    }

                } else {

                    array_push($response, "Error copying zip file " . htmlspecialchars($fullName), 0);
                    return $response;

                }

            } else {

                array_push($response, "File is too large.", 0);
                return $response;

            }

        } else {

            array_push($response, "File already exists.", 0);
            return $response;

        }

    } else {

        array_push($response, "Only ZIP files are allowed." , 0);
        return $response;

    }

}
   
function moveZip($filePath)
{
    if (move_uploaded_file($_FILES["zipFile"]["tmp_name"], $filePath)) {
        return true;
    } else {
        return false;
    }
}

function extractZip($filePath, $directory)
{
    $zip = new ZipArchive;
    if ($zip->open($filePath) === TRUE) {
        $zip->extractTo($directory); //'/my/destination/dir/'
        $zip->close();
        return true;
    } else {
        return false;
    }
}

function deleteZip($filePath)
{
    if(unlink($filePath)){
        return true;
    } else {
        return false;
    }
}

function inserDBdata($conn, $topic, $theme, $resource, $version, $user, $shortName){
    $created = date('d-m-Y');
    $type = 'html';
    $fileName = 'index.html';
    $htmlLink = './resources/'.$user.'/html/'.$shortName.'/'.$fileName;
 
    $sql = "INSERT INTO library (topic, theme, resources, link, created, version, type, user) VALUES(?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
 
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: index.php?error=stmtFailed&code=0");
        exit();
    }
 
    mysqli_stmt_bind_param($stmt, 'ssssssss', $topic, $theme, $resource, $htmlLink, $created, $version, $type,$user);
    if(mysqli_stmt_execute($stmt)){
       mysqli_stmt_close($stmt);
       return true;
    } else {
        return false;
    }
} 
 

?> 