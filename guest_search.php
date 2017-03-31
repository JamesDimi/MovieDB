<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'  type='text/css'>
</head>
<body>
<form action="guest_search.php" method="GET">
    <select name="order">
        <option name="order" disabled selected>Select Order method</option>
        <option name="order" value="asc">Rating Ascending</option>
        <option name="order" value="desc">Rating Descending</option>
        <input type="submit" value="Submit">
    </select>
</form>
<?php

session_start();

require_once ('MovieDB.php');
$db=new MovieDB();

if(isset($_GET['type'])){
    $_SESSION['type'] = $_GET['type'];
    $db->postGuestRating($_GET['type']);
}
if(isset($_GET['order'])){
    $db->guestOrderByRating($_SESSION['type'],$_GET['order']);
}

?>
</body>
</html>
