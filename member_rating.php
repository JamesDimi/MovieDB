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
$username = $_POST['username'];
$movieID = $_POST['id'];
$rating = $_POST['rate'];
$db->addMemberRating($username,$movieID,$rating);

?>

<script>
    alert("Member rating successfull!");
    window.parent.location.href = "./memberindex.php";
    window.close();
</script>