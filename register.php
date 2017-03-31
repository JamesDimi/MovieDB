<?php
require_once ('MovieDB.php');
$db=new MovieDB();
?>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'  type='text/css'>
</head>
<style>
    body {
        background-image: url('http://theagendadaily.com/wp-content/uploads/2016/04/movies-TAD.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        font-family: "Open Sans";
    }
    #register {
        border-radius: 15px 50px;
        background: rgba(255,255,255,.8);
        padding: 20px;
        margin: 0px;
        position: absolute;
        top: 50%;
        left: 50%;
        margin-right: -50%;
        transform: translate(-50%, -50%);
    }
    .custom-btn {
        background-color: #BDCFEB;
    }
</style>
<body class="container-fluid">
<?php

if((!isset($_POST['username'])) || (!isset($_POST['password']))) {
?>
    <form action="register.php" method="POST" class="text-center" id="register">
        <fieldset>
            <legend>Register</legend>
            <label for='username'>Username :</label>
            <input type='text' name='username' id='username' size="20" required/>
            <br><br>
            <label for='password'>Password :</label>
            <input type='password' name='password' id='password' size="20" required/>
            <br><br>
            <button class="btn custom-btn" type="submit">Register</button>
        </fieldset>
    </form>
<?php

}else {
    session_start();
    $user = new user();
    $user->setusername($_POST['username']);
    $user->setpassword($_POST['password']);

    if ($db->adduser($user) == -1) {
        echo "<script type='text/javascript'> alert('Username already exists!'); location.href = './register.php';</script>";
    }
    $_SESSION['username'] = $_POST['username'];
    echo "<script type='text/javascript'>alert('Register successful'); location.href = './memberindex.php';</script>";
}
?>
</body>
</html>
