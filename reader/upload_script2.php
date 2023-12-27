<?PHP
session_start();
include '../PHP/connection.php';

if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}
 
$error = '';
$code;
$allowFileType = array('pdf', 'ppt', 'pptx');
$fileName = $_FILES['file']['name']; // Name of file 
$basename = basename($fileName); // Name of file
$fileType = pathinfo($basename, PATHINFO_EXTENSION); // Ext with no point 
$tempPath = $_FILES["file"]["tmp_name"];

 
 // uploading files on submit 
if (isset($_POST['submit'])) {

    $version = mysqli_real_escape_string($conn, $_POST['version']);
    $topic =  mysqli_real_escape_string($conn, $_POST['topic']);
    $theme = mysqli_real_escape_string($conn, $_POST['theme']);
    $resource =  mysqli_real_escape_string($conn, $_POST['resource']);
    $pdfDir = '../resources/' . $user .'/pdf/';
    $pptDir = '../resources/' . $user .'/ppt/';
    $pdfPath = $pdfDir . $fileName;
    $pptPath = $pptDir . $fileName;

    if (emptyInput($version, $topic, $theme, $resource) !== false) { //true, errors inside code
        header('Location:index.php?error=Please fill all fields&code=0');
        exit();
    }   

    if(!in_array($fileType, $allowFileType)){
        header('Location:index.php?error=File type not allowed&code=0');
        exit();
    }

    if($fileType == 'pdf'){
        if(notDir($pdfDir)){
            $mes = fileManage($conn, $fileName, $pdfPath, $tempPath, $topic, $theme, $resource, $version, $fileType, $user);
            $error = $mes[0];
            $code = $mes[1];
            header('Location:index.php?error=' . $error . '&code=' . $code);
            exit();
        } else {
            header('Location:index.php?error=Error creating pdf directory&code=0');
        exit();
        }
    } else if ($fileType == 'ppt' || $fileType == 'pptx'){
        if(notDir($pptDir)){
            $mes = fileManage($conn, $fileName, $pptPath, $tempPath, $topic, $theme, $resource, $version, $fileType, $user);
            $error = $mes[0];
            $code = $mes[1];
            header('Location:index.php?error=' . $error . '&code=' . $code);
            exit();
        } else {
            header('Location:index.php?error=Error creating ppt directory&code=0');
            exit();
        }
    }



}    

function emptyInput($version, $topic, $theme, $resource){
    $result = true;
    if(empty($version) || empty($topic) || empty($resource) || empty($theme)){
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function notDir($dir){
    $result = false;
    if(!is_dir($dir)){
        if(mkdir($dir, 0777, true)){
            $result = true;
        } else {
            $result = false;
        }
    } else if (is_dir($dir)){
        $result = true;
    }
    return $result;
}

function fileManage($conn, $name, $file, $temp, $topic, $theme, $resource, $version, $type, $user){
    $mes = array();
    if(!is_file($file)){
        if(move_uploaded_file($temp, $file)){
            if(inserDBdata($conn, $topic, $theme, $resource, $file, $version, $type, $user)) {
                array_push($mes, $name . " was uploaded successfully", 1);
                return $mes;
            } else  {
                array_push($mes, 'Error creating DB entry for' .$name , 0);
                return $mes;
            }  
        } else {
            array_push($mes, 'Error uploading ' . $name, 0);
            return $mes;
        }
    } else {
        array_push($mes, $name . ' already exists', 0);
            return $mes;
    }
}

function inserDBdata($conn, $topic, $theme, $resource, $link, $version, $type, $user)
{
   $created = date('d-m-Y');

   $sql = "INSERT INTO library (topic, theme, resources, link, created, version, type, user) VALUES(?,?,?,?,?,?,?,?);";
   $stmt = mysqli_stmt_init($conn);

   if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: index.php?error=stmtFailed&code=0");
      exit();
   }

   mysqli_stmt_bind_param($stmt, 'ssssssss', $topic, $theme, $resource, $link, $created, $version, $type, $user);
   if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);
      return true;
   } else {
      return false;
   }
   
}

?>