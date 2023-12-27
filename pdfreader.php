<?PHP
session_start();
if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}

$link = $_GET["read"];
$mainDir = 'resources/';
$folder = '/pdf/';
$pathParts = pathinfo($link);
$fileName = $pathParts["filename"];
$extName = $pathParts["extension"];
$fileToRead = $mainDir . $user . $folder . $fileName . "." . $extName;


// Store the file name into variable

$file = $fileToRead;

$filename = $fileToRead;

// Header content type

header('Content-type: application/pdf');

header('Content-Disposition: inline; filename="' . $filename . '"');

header('Content-Transfer-Encoding: binary');

header('Accept-Ranges: bytes');

// Read the file

@readfile($file);

?>