<?PHP
include_once('signed_header.php');
if (isset($_SESSION)) {
    $user = $_SESSION['username'];
}
require_once('./PHP/connection.php');

$query = "SELECT count(*) as records, topic FROM library WHERE user= '$user' GROUP BY topic";
$result = mysqli_query($conn, $query);
?>

<div class="main basic">
    <div class="container container_library">
        <h1 class="form_headline_2" data-i18n="resources_title"></h1>
        <div class="menu_table">
            <table class="library_table">
                <tr>
                    <th data-i18n="table_head1"></th>
                    <th data-i18n="table_head2"></th>
                    <th data-i18n="table_head3"></th>
                </tr>
                <tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $link = $row['topic'];
                        ?>
                        <td id="col-1"><a id="folder_link" href="resources2.php?data=<?PHP echo $link; ?>"><span
                                    class="material-symbols-outlined table_icon">folder</span></a></td>
                        <td id="col-2">
                            <?php echo $row['topic']; ?>
                        </td>
                        <td id="col-3">
                            <?php echo $row['records']; ?>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
            </table>
        </div>
        <div class="back_link"><a class="back_to_menu" href="main.php"><span class="material-symbols-outlined"
                    id="arrow_logo">&nbsp;arrow_back</span data>Back to main</a></div>
    </div>
</div>


<?PHP
include_once('footer.php');
?>