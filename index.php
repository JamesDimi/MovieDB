<?php
require_once ('MovieDB.php');
$db=new MovieDB();
$db->addMovies();
?>
<html>
<head>
    <title>MoviesDB</title>
    <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'  type='text/css'>
    <script type="text/javascript" src="./MovieDBScript.js"></script>
</head>
<style>
    body {
        background-image: url("http://images-cdn.moviepilot.com/images/c_fill,h_2592,w_3888/t_mp_quality/fmnamir53dxhjhsvc3bo/the-top-5-movies-destined-to-flop-in-2016-835409.jpg");
        background-size: cover;
        background-repeat: no-repeat;
        font-family: "Open Sans";
    }
    #panel {
        opacity: 0.75;
    }
    .custom-btn {
        background-color: #BDCFEB;
    }
    iframe, object, embed {
        max-width: 100%;
    }
</style>
<body class="container-fluid">
    <div class="row well" id="panel">
        <span class="col-md-2 col-xs-2" style="font-family: Lobster; font-size: 2.5em;">MovieDB</span>
        <?php

        if((!isset($_POST['username'])) || (!isset($_POST['password']))) {
        ?>
            <form action="index.php" method="POST" class="col-md-9 col-xs-9 text-right" id="Login">
                Username: <input type="text" name="username" id="username" required>
                Password: <input type="password" name="password" id="password" required>
                <button class="btn custom-btn" type="submit">Login</button>
            </form>
        <?php
        }else{
            session_start();
            if ($db->checkUserPass($_POST['username'], $_POST['password']) === true) {
                $_SESSION['username'] = $_POST['username'];
                echo "<script> alert('Login Successfull!'); location.href = './memberindex.php'</script>";
            }
            echo "<script> alert('Login Failed!'); location.href = './index.php'</script>";
        }
        ?>
        <button class="btn custom-btn col-md-1 col-xs-1" id="register" onclick="location.href= './register.php';">Register</button>
    </div>

    <div class="row">
        <select onchange="listMovies(this.value);" class="col-md-4 col-xs-4 col-md-offset-4 col-xs-offset-4" id="search-type">
            <option value="" disabled selected>Select your option</option>
            <option value="all">All</option>
            <option value="action">Action</option>
            <option value="adventure">Adventure</option>
            <option value="animation">Animation</option>
            <option value="biography">Biography</option>
            <option value="comedy">Comedy</option>
            <option value="crime">Crime</option>
            <option value="documentary">Documentary</option>
            <option value="drama">Drama</option>
            <option value="family">Family</option>
            <option value="fantasy">Fantasy</option>
            <option value="film-noir">Film-Noir</option>
            <option value="game-show">Game-Show</option>
            <option value="history">History</option>
            <option value="horror">Horror</option>
            <option value="music">Music</option>
            <option value="musical">Musical</option>
            <option value="mystery">Mystery</option>
            <option value="news">News</option>
            <option value="reality-tv">Reality-TV</option>
            <option value="romance">Romance</option>
            <option value="sci-fi">Sci-Fi</option>
            <option value="sport">Sport</option>
            <option value="talk-show">Talk-Show</option>
            <option value="thriller">Thriller</option>
            <option value="war">War</option>
            <option value="western">Western</option>
        </select>
    </div>
    <br><br>

    <div  class="row" id="movieUI"></div>
    <script>
        function listMovies(str) {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp=new XMLHttpRequest();
            } else {  // code for IE6, IE5
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function() {
                if (xmlhttp.readyState==4 && xmlhttp.status==200) {
                    document.getElementById("movieUI").innerHTML = "";
                    var iframe = document.createElement('iframe');
                    iframe.srcdoc = this.responseText;
                    iframe.src = "data:text/html;charset=utf-8,";
                    iframe.width = "400px";
                    iframe.height = "100%";
                    iframe.frameBorder = 0;
                    iframe.className += "col-md-8 col-xs-8 col-md-offset-2 col-md-offset-2";
                    document.getElementById("movieUI").appendChild(iframe);
                }
            }
            xmlhttp.open("GET","guest_search.php?type="+str,true);
            xmlhttp.send();
        }
    </script>
</body>
</html>