<?PHP
include_once('signed_header.php');
if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}
require_once('./PHP/connection.php');

$data = $_GET["data"];
$type = '';
$href = '';

$query = "SELECT * FROM library WHERE topic='$data' AND user='$user'";
$result = mysqli_query($conn, $query);
?>

<div class="main basic">
    <div class="container container_library">
        <h1 class="form_headline_2" data-i18n="resources_title"></h1>
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
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $rowcount = mysqli_num_rows($result);
                        $link = $row['link'];
                        $type = $row['type'];
                        if ($type == 'pdf') {
                            $href = 'pdfreader.php?read=' . $link;
                        } else if ($type == 'html') {
                            $href = $link;
                        } else if ($type == 'ppt' || $type == 'pptx') {
                            $href = '';
                        }
                        ?>
                        <td id="col_action">
                            <a href="<?PHP echo $href ?>" class="action_logo" target="_blank"><span
                                    class="material-symbols-outlined">pageview</span></a>
                            <a href="<?PHP echo $href ?>" download target="_blank" class="action_logo"><span
                                    class="material-symbols-outlined">download</span></a>
                        </td>
                        <td id="col-1">
                            <?php echo $row['topic']; ?>
                        </td>
                        <td id="col-2">
                            <?php echo $row['resources']; ?>
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
        <div class="back_link"><a class="back_to_menu" href="resources1.php"><span class="material-symbols-outlined"
                    id="arrow_logo">&nbsp;arrow_back</span>Back to topic</a></div>
    </div>
</div>

<?PHP
include_once('footer.php');
?>