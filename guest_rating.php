<?php
/**
 * Created by PhpStorm.
 * User: Παναγιώτης
 * Date: 19/6/2016
 * Time: 1:01 μμ
 */
/* Για να μπορουμε να ελεγχουμε με το ISSET ποια ταινια εχει βαθμολογηθει./*/
require_once ('MovieDB.php');
$db=new MovieDB();
$movieID = $_POST['id'];
$rating = $_POST['rate'];
$db->addGuestRating($movieID,$rating);

?>
<script>
    alert("Rating Successfull!");
    window.parent.location.href = "./index.php";
    window.close();
</script>
