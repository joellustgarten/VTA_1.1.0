<?PHP
include '../PHP/connection.php';
session_start();

if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}

$error = "";
$class = "";

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    $code = $_GET['code'];

    switch ($code) {
        case 0:
            $class = "error_message";
            break;
        case 1:
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

function getData($conn, $query)
{
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $resultset[] = $row;
    }
    if (!empty($resultset))
        return $resultset;
}

?>

<!DOCTYPE html>
<html lang="en">

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
        <h1 class="form_headline" data-i18n="headline"></h1>
        <p class="cont_p" data-i18n="cont_p"></p>
        <div class="<?php echo $class; ?>">
            <p>
                <?php echo $error ?>
            </p>
        </div>
        <form class="form" method="post" enctype="multipart/form-data" action="upload_zip_script.php">
            <div class="text_field_container">
                <div class="text"><p>Topic</p></div>
                <div class="styled_select_1">
                    <?PHP
                    $query = "select topic_name from topic";
                    $row = getData($conn, $query);
                    ?>
                    <select class="topic" name="topic" id="topic">
                        <option value="" disabled selected hidden data-i18n="option"></option>
                        <?php foreach ($row as $row) { ?>
                            <option value='<?php echo $row['topic_name'] ?>'>
                                <?php echo $row['topic_name'] ?>
                            </option>
                        <?php } ?>
                        <!--
                    <option value="Diesel" data-i18n="Diesel"></option>
                    <option value="Gasoline" data-i18n="Gasoline"></option>
                    <option value="Electric" data-i18n="Electric"></option>
                    <option value="Adminitrative" data-i18n="Administrative"></option>
                    <option value="Other" data-i18n="Other"></option>
                    -->
                    </select>
                </div>
                <div class="styled_select_2">
                    <?PHP
                    $query = "select theme_name from theme";
                    $row = getData($conn, $query);
                    ?>
                    <select class="theme" name="theme" id="theme">
                        <option value="" disabled selected hidden data-i18n="option"></option>
                        <?php foreach ($row as $row) { ?>
                            <option value='<?php echo $row['theme_name'] ?>'>
                                <?php echo $row['theme_name'] ?>
                            </option>
                        <?php } ?>
                        <!--
                    <option value="V1.0">Default: V 1.0</option>
                    <option value="V2.0">V 2.0</option>
                    <option value="V3.0">V 3.0</option>
                    -->
                    </select>
                </div>
                <!--
                <input class="text_field" type="text" name="topic" placeholder="Resources (theme description)">
                -->
                <input class="text_field" type="text" name="resource" placeholder="Course (material name)">
            </div>
            <div class="action_form">
                <label class="custom_label"><input class="input" type="file" name="zipFile" accept=".zip">Select
                    file</label>
                <div class="styled_select_3">
                    <select class="version" name="version" id="version">
                        <option value="V1.0">Default: V 1.0</option>
                        <option value="V2.0">V 2.0</option>
                        <option value="V3.0">V 3.0</option>
                    </select>
                </div>
                <label class="custom_label"><input class="submit" type="submit" value="Upload ZIP File">Upload</label>
            </div>
        </form>
        <div class="close"><span class="material-symbols-outlined">exit_to_app</span><a
                href="javascript:window.close();">Close</a></div>
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