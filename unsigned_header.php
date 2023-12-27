<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="./CSS/style.css">
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
          <li class="li_links"><a class="link_1" href="https://www.boschtreinamentoautomotivo.com.br/pt-br/"
              data-i18n="site_title"></a>
          </li>
          <li class="li_links" id="lang_title" data-i18n="language"></li>
          <div class="ddown">
            <a class="lang_btn" href="" onclick="changeLanguage('en')">&ensp;EN&ensp;&#10072;&ensp;(english)<span
                class="material-symbols-outlined" aria-hidden="true">
                expand_more
              </span>&ensp;</a>
            <div class="ddown_content">
              <a href="" onclick="changeLanguage('es')">&ensp;ES&ensp;&#10072;&ensp;(espanol)&ensp;&ensp;</a>
              <a href="" onclick="changeLanguage('pt')">&ensp;PT&ensp;&#10072;&ensp;(portugues)&ensp;&ensp;</a>
            </div>
          </div>
        </ul>
      </div>
    </div>
    <div class="page_title" data-i18n="page_title"></div>
  </header>

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