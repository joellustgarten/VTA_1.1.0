<?PHP
session_start();
$user = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/style.css">
    <title data-i18n="html_title"></title>
</head>

<body>
    <header class="Header">
        <div class="frieze"></div>
        <div class="container_header">
            <div class="logo"><a class="corporate_link" href="https://www.bosch.com/"><img src="./images/logoNavBar.png"
                        width="135px" height="auto"></a></div>
            <div class="navigation">
                <ul class="header_links">
                    <li class="li_links" id="user" data-i18n="log_info"></li>
                    <span class="logged_user">
                        &ensp;
                        <?php echo $user ?>
                    </span>
                    <li class="li_links" id="logout"><a href="./PHP/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
        <div class="">
            <nav class="menu_nav">
                <ul class="menu-bar">
                    <li>
                        <button class="nav-link dropdown-btn" data-dropdown="dropdown1" aria-haspopup="true"
                            aria-expanded="false" aria-label="browse" data-i18n="nav_button">
                        </button>
                        <div id="dropdown1" class="dropdown">
                            <ul role="menu">
                                <li role="menuitem">
                                    <a class="dropdown-link" href="#" onclick="openAnalogClock()">
                                        <img src="./images/clock.svg" class="icon" width="35px" height="35px" />
                                        <div>
                                            <span class="dropdown-link-title" data-i18n="clock_title"></span>
                                            <p data-i18n="clock_message"></p>
                                        </div>
                                    </a>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="#" onclick="openChronometer()">
                                        <img src="./images/timer.svg" class="icon" width="35px" height="35px" />
                                        <div>
                                            <span class="dropdown-link-title" data-i18n="timer_title"></span>
                                            <p data-i18n="timer_message"></p>
                                        </div>
                                    </a>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="#" onclick="openToDoList()">
                                        <img src="./images/todo.svg" class="icon" width="35px" height="35px" />
                                        <div>
                                            <span class="dropdown-link-title" data-i18n="todo_title"></span>
                                            <p data-i18n="todo_message"></p>
                                        </div>
                                    </a>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="#" onclick="openNotes()">
                                        <img src="./images/notes.svg" class="icon" width="35px" height="35px" />
                                        <div>
                                            <span class="dropdown-link-title" data-i18n="notes_title"></span>
                                            <p data-i18n="notes_message"></p>
                                        </div>
                                    </a>
                                </li>
                            </ul>

                            <ul role="menu">
                                <li class="dropdown-title">
                                    <span class="dropdown-link-title" data-i18n="nav_by_app"></span>
                                </li>
                                <li role="menuitem">
                                    <img src="./images/unit.svg" width="24px" height="24px" />
                                    <a class="dropdown-link2" href="#" onclick="openUnitConverter()"
                                        data-i18n="unit_title"></a>
                                </li>
                                <li role="menuitem">
                                    <img src="./images/dict.svg" width="24px" height="24px" />
                                    <a class="dropdown-link2" href="#" onclick="openTechnicalDict()"
                                        data-i18n="dict_title"></a>
                                </li>
                                <li role="menuitem">
                                    <img src="./images/whiteb.svg" width="24px" height="24px" />
                                    <a class="dropdown-link2" href="#" onclick="openWhiteboard()"
                                        data-i18n="whiteboard_title"></a>
                                </li>
                                <li role="menuitem">
                                    <img src="./images/pdf.svg" width="24px" height="24px" />
                                    <a class="dropdown-link2" href="#" onclick="openUploadPdf()"
                                        data-i18n="upload_title"></a>
                                </li>
                                <li role="menuitem">
                                    <img src="./images/html.svg" width="24px" height="24px" />
                                    <a class="dropdown-link2" href="#" onclick="openUploadHtml()"
                                        data-i18n="upload_html_title"></a>
                                </li>
                                <li role="menuitem">
                                    <img src="./images/edit.svg" width="24px" height="24px" />
                                    <a class="dropdown-link2" href="#" onclick="openEditResources()"
                                        data-i18n="edit_title"></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <button class="nav-link dropdown-btn" data-dropdown="dropdown2" aria-haspopup="true"
                            aria-expanded="false" aria-label="settings" data-i18n="setting_button">
                        </button>
                        <div id="dropdown2" class="dropdown">
                            <ul role="menu">
                                <li>
                                    <span class="dropdown-link-title2" data-i18n="language_title"></span>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="" onclick="changeLanguage('en')">English (en)</a>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="" onclick="changeLanguage('es')">Español (es)</a>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="" onclick="changeLanguage('pt')">Portugues (pt)</a>
                                </li>
                            </ul>
                            <ul role="menu">
                                <li>
                                    <span class="dropdown-link-title2" data-i18n="themes_title"></span>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="" data-i18n="dark_title"></a>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="#light-theme" data-i18n="light_title"></a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <button class="nav-link dropdown-btn" data-dropdown="dropdown3" aria-haspopup="true"
                            aria-expanded="false" aria-label="livestream" data-i18n="livestream_button">
                        </button>    
                        <div id="dropdown3" class="dropdown">
                            <ul role="menu">
                                <li>
                                    <span class="dropdown-link-title2" data-i18n="livestream_title"></span>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="" onclick="openLivestream()" data-i18n="livestream-registration"></a>
                                </li>
                                <li role="menuitem">
                                    <a class="dropdown-link" href="" onclick="#" data-i18n="livestream-management">Management</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li><a class="nav-link" href="resources1.php" data-i18n="resorces_title"></a></li>
                   <!-- <li><a class="nav-link" href="" onclick="openLivestream()">Livestream</a></li>-->

                    <li><a class="nav-link" href="" data-i18n="About_title"></a></li>
                </ul>
                <div class="page_title" data-i18n="menu_title"></div>
            </nav>
        </div>
        <script src="./JS/header_script.js"></script>
        <script>
            function openAnalogClock() {
                window.open("./ac/index.html", "popup=yes", "width=800, height=600, top=0, left=0");
            }
            function openChronometer() {
                window.open("./ch/index.html", "popup=yes", "width=700, height=300, top=0, left=0");
            }
            function openToDoList() {
                window.open("./td/index.html", "popup=yes", "width=800, height=600, top=0, left=0");
            }
            function openNotes() {
                window.open("./na/index.html", "popup=yes", "width=800, height=600, top=0, left=0");
            }
            function openWhiteboard() {
                window.open("./wb/index.html", "popup=yes", "width=1000, height=700, top=0, left=0");
            }
            function openTechnicalDict() {
                window.open("./dic/technicalDictionary.php", "popup=yes", "width=1100, height=700, top=0, left=0");
            }
            function openUnitConverter() {
                window.open("./uc/unitConverter.html", "popup=yes", "width=800, height=500, top=0, left=0");
            }
            function openUploadPdf() {
                window.open("./reader/index.php", "popup=yes", "width=800, height=700, top=0, left=0");
            }
            function openUploadHtml() {
                window.open("./uphtml/index.php", "popup=yes", "width=800, height=600, top=0, left=0");
            }
            function openEditResources() {
                window.open("./edres/index.php", "popup=yes", "width=1200, height=700, top=0, left=0");
            }
            function openLivestream() {
                window.open("./livestre/index.php", "popup=yes", "width=800, height=700, top=0, left=0");
            }


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


                //toggleArabicStylesheet(lang);// Toggle Arabic stylesheet
            }

            // Call updateContent() on page load
            window.addEventListener('DOMContentLoaded', async () => {
                const userPreferredLanguage = localStorage.getItem('language') || 'en';
                const langData = await fetchLanguageData(userPreferredLanguage);
                updateContent(langData);
                //toggleArabicStylesheet(userPreferredLanguage);
            });

        </script>
    </header>