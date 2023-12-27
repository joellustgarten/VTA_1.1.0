<?PHP
session_start();
include '../PHP/connection.php';
if (isset($_SESSION)) {
   $user = $_SESSION['username'];
}

$error = '';
$code;
$version = '';
$topic = '';
$resource = '';


// uploading files on submit 
if (isset($_POST['submit'])) {

   if (isset($_POST['version'])) {
      $version = $_POST['version'];
   }

   if (isset($_POST['topic'])) {
      $topic = $_POST['topic'];
   }

   if (isset($_POST['resource'])) {
      $resource = $_POST['resource'];
   }

   $msg = upload_file($conn, $topic, $resource, $version, $user);
   $error = $msg[0];
   $code = $msg[1];
   header('Location:index.php?error=' . $error . '&code=' . $code);
}
function upload_file($conn, $topic, $resource, $version, $user)
{
   $response = array();
   $allowFileType = array('pdf', 'ppt', 'pptx');
   $fileName = $_FILES['file']['name']; // Name of file 
   $basename = basename($fileName); // Name of file
   $fileType = pathinfo($basename, PATHINFO_EXTENSION); // Ext with no point 
   //$uploadPdf = "../resources/" . $user . "/pdf/";
   $uploadPdf = '../resources/' . $user .'/pdf/';
   $uploadPpt = '../resources/' . $user .'/ppt/';
   $tempPath = $_FILES["file"]["tmp_name"];
   $pdfPath = $uploadPdf . $fileName;
   $pptPath = $uploadPpt . $fileName;

   if (!empty($fileName)) {
      if (in_array($fileType, $allowFileType)) {
         if ($fileType == 'pdf') {
            if (!is_dir($uploadPdf)) {
               if(mkdir($uploadPdf, 0777, true)) {
                  
                     if (move_uploaded_file($tempPath, $pdfPath)) {
                        if (inserDBdata($conn, $topic, $resource, $pdfPath, $version, $fileType, $user)) {
                           array_push($response, $fileName . " was uploaded successfully", 1);
                           return $response;
                        } else {
                           array_push($response, " Error updating database", 0);
                           return $response;
                        }
                     } else {
                        array_push($response, "File Not uploaded! try again".$_FILES['file']['error'], 0);
                        return $response;
                     }
               } else {
                  array_push($response, 'Error creating directory' . $uploadPdf, 0);
                  return $response;
               }
            } else {
               array_push($response, $fileName . " already exists", 0);
               return $response;
            }
         } else if ($fileType == 'ppt' || $fileType == 'pptx') {
            if (!file_exists($pptPath)) {
               if (move_uploaded_file($tempPath, $pptPath)) {
                  if (inserDBdata($conn, $topic, $resource, $pptPath, $version, $fileType, $user)) {
                     array_push($response, $fileName . " was uploaded successfully", 1);
                     return $response;
                  } else {
                     array_push($response, " Error updating database", 0);
                     return $response;
                  }
               } else {
                  array_push($response, "File Not uploaded! try again", 0);
                  return $response;
               }
            } else {
               array_push($response, $fileName . " already exists", 0);
               return $response;
            }
         }
      } else {
         array_push($response, $fileType . " file type not allowed", 0);
         return $response;
      }
   } else {
      array_push($response, "Please Select a file", 0);
      return $response;
   }
}


function create_dir($path){
  
}

function inserDBdata($conn, $topic, $resource, $link, $version, $type, $user)
{
   $created = date('d-m-Y');

   $sql = "INSERT INTO library (topic, resources, link, created, version, type, user) VALUES(?,?,?,?,?,?,?);";
   $stmt = mysqli_stmt_init($conn);

   if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: index.php?error=stmtFailed&code=0");
      exit();
   }

   mysqli_stmt_bind_param($stmt, 'sssssss', $topic, $resource, $link, $created, $version, $type, $user);
   if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_close($stmt);
      return true;
   } else {
      return false;
   }
   
}

?>