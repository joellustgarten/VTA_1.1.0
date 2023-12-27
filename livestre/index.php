<?PHP
include '../PHP/connection.php';
session_start();


if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}

$error_mes = "";
$class = "";

if (isset($_GET['errors'])) {
    $errors = $_GET['errors'];
    
    switch ($errors) {
        case 'fields':
            $error_mes = 'Please fill all fields';
            $class = "error_message";
            break;
        case 'stmtFailed':
            $error_mes = 'Database connection error';
            $class = "error_message";
            break;
        case 'updateDBerror':
            $error_mes = 'Error registering participant';
            $class = "error_message";
            break;
        case 'no_error':
            $error_mes = 'Successful participant registration';
            $class = "ok_message";
            break;
        default:
            $error_mes = "";
            $class = "no_error_message";
    }
} else {
    $error_mes = "";
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
                <?php echo $error_mes ?>
            </p>
        </div>
        <form class="form" method="post" enctype="multipart/form-data" action="student_livestream.php">
            <div class="text_field_container">
                <p class="course_title" data-i18n="course_name">course tittle</p>
                <div class="styled_select_1">
                    <?PHP
                    $query = "select * from library";
                    $row = getData($conn, $query);
                    ?>
                    <select class="topic" name="topic" id="topic">
                        <option value="" disabled selected hidden data-i18n="option"></option>
                        <?php foreach ($row as $row) { ?>
                            <option value='<?php echo $row['link'] ?>'>
                                <?php echo $row['topic'] . ":  " . $row['resources'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <input class="text_field" type="text" name="participant"
                    placeholder="Participant name / Nombre de participante">
            </div>
            <div class="training_dates">
                <p class="p_dates" data-i18n="p_date"></p>
                <div class="calender">
                    <label Class="date">Inicio / Starts
                        <input type="date" name="start_day" />
                    </label>
                    <label class="date">Fin / Ends
                        <input type="date" name="end_day" />
                    </label>
                </div>
            </div>
            <div class="action_form">
                <label class="custom_label" >Register<input class="submit" type="submit"></label>
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