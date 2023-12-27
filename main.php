<?PHP
include_once('signed_header.php');
if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}
?>

<div class="main basic">
    <div class="container container_main">
        <div class="main_close"><span>Close </span><a class="material-symbols-outlined" href="main2.php"">Cancel</a></div>
        <h1 class="form_headline_2" data-i18n="main_title"></h1>
        <p class="cont_p" data-i18n="main_text"></p>
        <div class="main_info_1">
            <span class="material-symbols-outlined">pageview</span>
            <h2 data-i18n="main_subtitle1"></h2>
            <p data-i18n="main_p1"></p>
        </div>
        <div class="main_info_2">
            <span class="material-symbols-outlined">download</span>
            <h2 data-i18n="main_subtitle2"></h2>
            <p data-i18n="main_p2"></p>
        </div>
        <div class="expl_img"><img id="main_en_img" src="./images/resources_image.png" width="50%" height="auto" />
        </div>
    </div>
</div>

<?PHP
include_once('footer.php');
?>