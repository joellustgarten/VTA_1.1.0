<?PHP

require_once('../PHP/connection.php');

session_start();
if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}

$error = '';
$class= "no_error_message";

if (isset($_GET['link'])) {
    $del_link = $_GET['link'];
    $del_type = $_GET['type'];
    del($conn, $user, $del_link, $del_type);
}

function del($conn, $user, $links, $types){

    if($types == 'pdf' || $types == 'ppt' || $types == 'pptx'){
        deletePDF_PPT_File($conn, $user, $links);  
    } else if ($types == 'html'){
        deleteHTML_directory($conn, $user, $links);
    }
}

function deletePDF_PPT_File($conn, $user, $links){

    if(unlink($links)){
        $query = "DELETE FROM library WHERE user='$user' AND link='$links'";
        $result = mysqli_query($conn, $query);
        if($result){
                echo "<script>alert('$links. deleted' );</script>";
            } else {
                echo "<script>alert('Error deleting. $links. from DB');</script>";
            }
    } else {
        echo "<script>alert('Error deleting .$links. from folder');</script>";
    }
}

function deleteHTML_directory($conn, $user, $links){

    $directory = dirname($links);
   
    if(recursiveDirDelete($directory)){
        $query = "DELETE FROM library WHERE user='$user' AND link='$links'";
        $result = mysqli_query($conn, $query);
        if($result){
                echo "<script>alert('$links deleted' );</script>";
            } else {
                echo "<script>alert('Error deleting $links from DB');</script>";
            }
    } else {
        echo "<script>alert('Error deleting $links from folder');</script>";
    }
   
}

function recursiveDirDelete($directory){
    foreach(glob($directory."/*") as $file){
        if(is_dir($file)){
            recursiveDirDelete($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);

    if(is_dir($directory)){
        return false;
    } else {
        return true;
    }
}

$query = "SELECT * FROM library WHERE user='$user'";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title data-i18n="upload_title"></title>
</head>

<body>
    <div class="container">
        <div class="lang_selector">
            <p data-i18n="language"></p>
            <a href="" onclick="changeLanguage('en')">EN</a>
            <span>|</span>
            <a href="" onclick="changeLanguage('es')">ES</a>
            <span>|</span>
            <a href="" onclick="changeLanguage('pt')">PT</a>
        </div>
        <h1 class="form_headline" data-i18n="delete_title"></h1>
        <p class="cont_p" data-i18n="delete_text"></p>
        <div class="<?php echo $class; ?>">
            <p>
                <?php echo $error ?>
            </p>
        </div>
        <div class="menu_table">
            <table class="library_table">
                <tr>
                    <th data-i18n="header1"></th>
                    <th data-i18n="header2"></th>
                    <th data-i18n="header3"></th>
                    <th data-i18n="header4"></th>
                    <th data-i18n="header5"></th>
                    <th data-i18n="header6"></th>
                </tr>
                <tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rowcount = mysqli_num_rows($result);
                        $link = $row['link'];
                        $type = $row['type'];
                        ?>
                        <td id="col_action">
                            <a href="index.php?link=<?PHP echo $link ?>&type=<?PHP echo $type ?>" class="action_logo" title="Delete file"><span class="material-symbols-outlined">delete</span></a>
                        </td>
                        <td id="col-1">
                            <?php echo $row['resources']; ?>
                        </td>
                        <td id="col-2">
                            <?php echo '...'.substr($link, -40)?>
                        </td>
                        <td id="col-3">
                            <?php echo $row['created']; ?>
                        </td>
                        <td id="col-4">
                            <?php echo $row['version']; ?>
                        </td>
                        <td id="col-5">
                            <?php echo $row['type']; ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
            </table>
        </div>
        <div class="close"><span class="material-symbols-outlined">exit_to_app</span><a href="javascript:window.close();">Close</a></div>
    </div>
    </div>
</body>
</html>


<script>
    // lang change beggins here
    // Function to fetch language data
    async function fetchLanguageData(lang) {
      const response = await fetch(`languages/${lang}.json`);
      return response.json();
    }

    // Function to set the language preference
    function setLanguagePreference(lang) {
      localStorage.setItem('language', lang);
      location.reload();
    }

    // Function to update content based on selected language
    function updateContent(langData) {
      document.querySelectorAll('[data-i18n]').forEach(element => {
        const key = element.getAttribute('data-i18n');
        element.textContent = langData[key];
      });
    }

    // Function to change language
    async function changeLanguage(lang) {
      await setLanguagePreference(lang);

      const langData = await fetchLanguageData(lang);
      updateContent(langData);

    }

    // Call updateContent() on page load
    window.addEventListener('DOMContentLoaded', async () => {
      const userPreferredLanguage = localStorage.getItem('language') || 'en';
      const langData = await fetchLanguageData(userPreferredLanguage);
      updateContent(langData);

    });

  </script>