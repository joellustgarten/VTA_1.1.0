<?PHP
include_once('signed_header.php');
if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}
?>

<div class="main basic">
    <div class="container container_main">
        <h1 class="form_headline_2" data-i18n="main2_title"></h1>
        <iframe src="demo_iframe.php" height="200" width="300" title="Iframe Example"></iframe>
    </div>
</div>

<?PHP
include_once('footer.php');
?>