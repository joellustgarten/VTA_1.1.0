<?PHP
include '../PHP/connection.php';
session_start();

$link = "";
$participant = "";
$start_day = "";
$end_day = "";
$trainer = "";

if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}


$query = "SELECT * FROM livestream WHERE user='$user'";
$result = mysqli_query($conn, $query);

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
        <h1 class="form_headline" data-i18n="headline_management"></h1>
        <p class="cont_p" data-i18n="cont_p_management"></p>
        <div class="container_table">
            <div class="menu_table">
                <table class="library_table">
                    <tr>
                        <th data-i18n="table2_head1"></th>
                        <th data-i18n="table2_head2"></th>
                        <th data-i18n="table2_head3"></th>
                        <th data-i18n="table2_head4"></th>
                        <th data-i18n="table2_head5"></th>
                        <th data-i18n="table2_head6"></th>
                    </tr>
                    <tr>
                        <!--
                    <?php
                        /* while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <td id="col_action">
                                <a href="<?PHP echo $href ?>" class="action_logo" target="_blank"><span
                                        class="material-symbols-outlined">pageview</span></a>
                                <a href="<?PHP echo $href ?>" download target="_blank" class="action_logo"><span
                                        class="material-symbols-outlined">download</span></a>
                            </td>
                            <td id="col-1">
                                <?php echo $row['link']; ?>
                            </td>
                            <td id="col-2">
                                <?php echo $row['participant']; ?>
                            </td>
                            <td id="col-3">
                                <?php echo $row['start_day']; ?>
                            </td>
                            <td id="col-4">
                                <?php echo $row['end_day']; ?>
                            </td>
                            <td id="col-5">
                                <?php echo $row['participant']; ?>
                            </td>
                        </tr>
                        <?php
                        }
                        */
                        ?>
                        -->
                </table>
            </div>
        </div>
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