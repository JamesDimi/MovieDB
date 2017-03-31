<?php
require_once('user.php');
require_once ('movies.php');

class MovieDB
{
    const servername = "localhost";
    const username = "new_user";
    const password = "123";

    function __construct()
    {


// Create connection


        $conn = new mysqli(self::servername, self::username, self::password, "myDB");
        $sql = "CREATE TABLE IF NOT EXISTS USERS (
username VARCHAR(30) NOT NULL PRIMARY  KEY,
password VARCHAR(30) NOT NULL,
reg_date TIMESTAMP
)";
        mysqli_query($conn, $sql);

        $sql = "CREATE TABLE IF NOT EXISTS MOVIES (
id INT(6) UNSIGNED  PRIMARY KEY,
title VARCHAR(30) NOT NULL,
release_date VARCHAR(30) NOT NULL,
category VARCHAR(30) NOT NULL,
picture VARCHAR(100) NOT NULL ,
plot VARCHAR(600) NOT NULL,
guest_rating FLOAT(10,2),
counter INT(6) UNSIGNED
)";
        mysqli_query($conn, $sql);

        $sql = "CREATE TABLE IF NOT EXISTS member_rating (
username VARCHAR(30) NOT NULL,
movie_id INT(6) UNSIGNED ,
rating FLOAT(3,2),
PRIMARY KEY (username,movie_id),
FOREIGN KEY (username) 
        REFERENCES USERS(username)
        ON DELETE CASCADE,
  FOREIGN KEY (movie_id)
        REFERENCES MOVIES(id)
        ON DELETE CASCADE

)";
        mysqli_query($conn, $sql);
        $conn->close();

    }

    public function adduser($data)
    {


        /*  if($this->checkusername($data->getUsername())!=null){
              echo 'user exist';
              return;
          }*/
        $_user = $data->getUsername();
        $conn = new mysqli(self::servername, self::username, self::password, "myDB");

        if ($result = $conn->query("SELECT username,password,reg_date  FROM USERS WHERE username= '$_user' ")) {

            /* determine number of rows result set */
            $row_cnt = $result->num_rows;



            /* close result set */
            $result->close();
            if($row_cnt>0){
                return -1;
            }
            $ids=array();
            $i=0;
            $movie_id="SELECT id from MOVIES";
            $result = $conn->query($movie_id);
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $ids[$i]=$row['id'];
                $i++;}

            $sql = $conn->prepare("INSERT INTO USERS (username, password) VALUES ( ?,?)");
            $sql->bind_param("ss", $username, $password);
            $username = $data->getUsername();
            $password = $data->getpassword();
            $sql->execute();
            for ($x = 0; $x < count($ids); $x++) {

                $member_ = "INSERT INTO member_rating(username,movie_id,rating) VALUES ('$username','$ids[$x]',0)";
                $conn->query($member_);
            }
            $conn->close();}
        return 1;
    }


    /*public function checkusername($username){

        return 1;
    }*/
    public function retriveUser($username,$password){
        $conn = new mysqli(self::servername, self::username, self::password, "myDB");
        $sql =$conn->prepare( "SELECT username,password,reg_date  FROM USERS WHERE username= ? AND password=?");
        $sql->bind_param("ss",$_user,$_pass);
        $_user=$username;
        $_pass=$password;
        $sql->execute();


        $row = $sql->fetch();

        if ($row === false) {
            //No results returned, so the ID must have been invalid.
            return null;
        }

        $user = new user();

        $user->setusername($row["username"]);
        $user->setpassword($row["password"]);
        $user->settime($row["reg_date"]);

        $conn->close();
        return $user;
    }
    //adds creates the movie database once and adds the movies once
    public function addMovies()
    {
        $conn = new mysqli(self::servername, self::username, self::password, "myDB");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (0,'Miracles from Heaven', '2016', 'drama','https://yts.ag/assets/images/movies/miracles_from_heaven_2016/medium-cover.jpg','MIRACLES FROM HEAVEN is based on the incredible true story of the Beam family. When Christy (Jennifer Garner) discovers her 10-year-old daughter Anna (Kylie Rogers) has a rare, incurable disease, she becomes a ferocious advocate for her daughters healing as she searches for a solution. After Anna has a freak accident, an extraordinary miracle unfolds in the wake of her dramatic rescue that leaves medical specialists mystified, her family restored and their community inspired. ',0,0);";
        $sql .=  "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (1,'Zootopia','2016', 'comedy','https://yts.ag/assets/images/movies/zootopia_2016/medium-cover.jpg','From the largest elephant to the smallest shrew, the city of Zootopia is a mammal metropolis where various animals live and thrive. When Judy Hopps becomes the first rabbit to join the police force, she quickly learns how tough it is to enforce the law. Determined to prove herself, Judy jumps at the opportunity to solve a mysterious case. Unfortunately, that means working with Nick Wilde, a wily fox who makes her job even harder. ',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (2,'Gods of Egypt', '2016', 'action','https://yts.ag/assets/images/movies/gods_of_egypt_2016/medium-cover.jpg','Set, the merciless god of darkness, has taken over the throne of Egypt and plunged the once peaceful and prosperous empire into chaos and conflict. Few dare to rebel against him. A young thief, whose love was taken captive by the god, seeks to dethrone and defeat Set with the aid of the powerful god Horus. ',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (3,'Kung Fu Panda', '2008', 'animation','https://yts.ag/assets/images/movies/Kung_Fu_Panda_2008/medium-cover.jpg','Its the story about a lazy, irreverent slacker panda, named Po, who is the biggest fan of Kung Fu around...which doesnt exactly come in handy while working every day in his familys noodle shop. Unexpectedly chosen to fulfill an ancient prophecy, Pos dreams become reality when he joins the world of Kung Fu and studies alongside his idols, the legendary Furious Five -- Tigress, Crane, Mantis, Viper and Monkey -- under the leadership of their guru, Master Shifu. But before they know it, the vengeful and treacherous snow leopard Tai Lung is headed their way, and its up to Po to defend everyone from the oncoming threat. Can he turn his dreams of becoming a Kung Fu master into reality? Po puts his heart - and his girth - into the task, and the unlikely hero ultimately finds that his greatest weaknesses turn out to be his greatest strengths. ',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (4,'Spartacus', '1960', 'biography','https://yts.ag/assets/images/movies/spartacus_1960/medium-cover.jpg','n 73 BCE, a Thracian slave leads a revolt at a gladiatorial school run by Lentulus Batiatus. The uprising soon spreads across the Italian Peninsula involving thousand of slaves. The plan is to acquire sufficient funds to acquire ships from Silesian pirates who could then transport them to other lands from Brandisium in the south. ',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (5,'True Crime', '1999', 'crime','https://yts.ag/assets/images/movies/true_crime_1999/medium-cover.jpg','Steve Everett, Oakland Tribune journalist with a passion for women and alcohol, is given the coverage of the upcoming execution of murderer Frank Beachum.',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (6,'Catfish', '2007', 'documentary','https://yts.ag/assets/images/movies/catfish_2010/medium-cover.jpg','In late 2007, filmmakers Ariel Schulman and Henry Joost sensed a story unfolding as they began to film the life of Ariels brother, Nev. They had no idea that their project would lead to the most exhilarating and unsettling months of their lives. A reality thriller that is a shocking product of our times, Catfish is a riveting story of love, deception and grace within a labyrinth of online intrigue. ',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (7,'Quackerz', '2016', 'family','https://yts.ag/assets/images/movies/quackerz_2016/medium-cover.jpg','On the little island lost in far sunny China the regular life of mandarin ducks in an instant turns into chaos: the flock of the military mallards are making a cruise to Hawaii, by mistake lands on the mandarines island',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (8,'Garfield', '2004', 'fantasy','https://yts.ag/assets/images/movies/garfield_2004/medium-cover.jpg','Garfield, the fat, lazy, lasagna lover, has everything a cat could want. But when Jon, in an effort to impress the Liz - the vet and an old high-school crush - adopts a dog named Odie and brings him home, Garfield gets the one thing he doesnt want.',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (9,'Titus', '1999', 'history','https://yts.ag/assets/images/movies/titus_1999/medium-cover.jpg','War begets revenge. Victorious general, Titus Andronicus, returns to Rome with hostages: Tamora queen of the Goths and her sons.',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (10,'Purple Rain', '1984', 'music','https://yts.ag/assets/images/movies/purple_rain_1984/medium-cover.jpg','A young man with a talent for music has begun a career with much promise. He meets an aspiring singer, Apollonia, and finds that talent alone isnt all that he needs. A complicated tale of his repeating his fathers self destructive behavior, losing Apollonia to another singer (Morris Day), and his coming to grips with his own connection to other people ensues. ',0,0);";
        $sql .= "INSERT IGNORE INTO MOVIES (id,title, release_date, category,picture,plot,guest_rating,counter)
VALUES (11,'The Player', '1992', 'mystery','https://yts.ag/assets/images/movies/the_player_1992/medium-cover.jpg','A studio script screener gets on the bad side of a writer by not accepting his script. The writer is sending him threatening postcards.',0,0);";

        $conn->multi_query($sql) ;


        $conn->close();
    }
    //checks if the username and password is correct and return a bool
    public function checkUserPass($username,$password){
        $conn = $conn = new mysqli(self::servername, self::username, self::password, "myDB");
        $sql = "SELECT username,password FROM USERS WHERE username = '$username' AND password = '$password' ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return true;
        }
        else {
            return false;
        }

        $conn->close();
    }
    //adds guest ratings into movies database
    public function addGuestRating($movieID,$rating){
        $conn = $conn = new mysqli(self::servername, self::username, self::password, "myDB");

        $sql = "UPDATE movies SET guest_rating= guest_rating + $rating , counter= counter + 1 WHERE id= $movieID; ";
        $result = $conn->query($sql);

        $conn->close();
    }
    //adds member ratings into member_rating database
    public function addMemberRating($user,$movieID,$rating){
        $conn = $conn = new mysqli(self::servername, self::username, self::password, "myDB");

        $sql = "UPDATE member_rating SET rating= $rating WHERE username= '$user' AND movie_id= $movieID";
        $result = $conn->query($sql);

        $conn->close();
    }
    public function postGuestRating($value){

        $conn = new mysqli(self::servername, self::username, self::password, "myDB");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if($value=="all"){

            $sql = "SELECT id,title,release_date,category,picture,plot,guest_rating,counter FROM MOVIES ORDER BY title ";

        }else{
            $sql = "SELECT id,title,release_date,category,picture,plot,guest_rating,counter FROM MOVIES WHERE category = '$value' ORDER BY title";
        }

        $result = $conn->query($sql);
        $i=0;
        $ids=array();
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $ids[$i]=$row['id'];

            if($row['counter']==0){
                $avg=0;
            }else{
                $avg=$row['guest_rating']/$row['counter'];
                $avg=round($avg,2);
            }
            // Print out the contents of each row into a table
            $id=$row['id'];
            echo "<form class='row well' style='border: 2px black solid' method='post' action='guest_rating.php' name='update'>
                <span class='col-md-4 col-xs-4'><img class='text-center' src=$row[picture]></span>
                <span class='col-md-4 col-xs-4 col-md-offset-2 col-xs-offset-2 text-center' style='vertical-align: middle;'>Title : $row[title]<br>
                Release date : $row[release_date]<br>";

            switch(round($avg)){
                case 1:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></p>";
                    break;
                case 2:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>☆</span><span>☆</span><span>☆</span></p>";
                    break;
                case 3:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>☆</span><span>☆</span></p>";
                    break;
                case 4:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>☆</span></p>";
                    break;
                case 5:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></p>";
                    break;
                default:
                    echo "<p style='font-size: 20px;'><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></p>";
            }

            echo "<p>Rating : $avg</p><br>
                Plot :  $row[plot]<br><br><br><br><br>
                rate between 1-5  <input type='number' step='any' name='rate' min='1' max='5'>
                <input  name='update' value='rate' type='submit'>
                </span>
                <input type='hidden' name='id' value='$id'>
                </form>";
            /* καθε form περναει και το id για να μπορουμε να κανουμε το σωστο movie update*/




        }

        $conn->close();
    }
    public function postMemberRating($user,$category){
        $conn = new mysqli(self::servername, self::username, self::password, "myDB");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if($category=="all"){

            $sql = "SELECT id,title,release_date,category,picture,plot,rating FROM MOVIES,member_rating WHERE MOVIES.id=member_rating.movie_id and member_rating.username= '$user' and movies.id=member_rating.movie_id ORDER BY title ";

        }else{
            $sql = "SELECT DISTINCT id,title,release_date,category,picture,plot,rating FROM MOVIES,member_rating WHERE  category = '$category' AND member_rating.username= '$user' and movies.id=member_rating.movie_id ORDER BY title";
        }

        $result = $conn->query($sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $id=$row['id'];
            // Print out the contents of each row into a table

            echo "<form class='row well' style='border: 2px black solid' method='POST' action='member_rating.php' name='update'>
                    <span class='col-md-4 col-xs-4'><img class='text-center' src=$row[picture]></span>
                    <span class='col-md-4 col-xs-4 col-md-offset-2 col-xs-offset-2 text-center' style='vertical-align: middle;'>Title : $row[title]<br>
                    Release date : $row[release_date]<br>";

            switch(round($row['rating'])){
                case 1:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></p>";
                    break;
                case 2:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>☆</span><span>☆</span><span>☆</span></p>";
                    break;
                case 3:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>☆</span><span>☆</span></p>";
                    break;
                case 4:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>☆</span></p>";
                    break;
                case 5:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></p>";
                    break;
                default:
                    echo "<p style='font-size: 20px;'><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></p>";
            }

            echo    "<p>Rating : $row[rating]</p><br>
                    Plot :  $row[plot]<br><br><br><br><br>
                    rate between 1-5  <input type='number' step='any' name='rate' min='1' max='5'>
                    <input  name='update' value='rate' type='submit'>
                    </span>
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='username' value='$user'>
                </form>";
            /* καθε form περναει και το id για να μπορουμε να κανουμε το σωστο movie update*/
        }
        $conn->close();

    }
    public function memberOrderByRating($user,$category,$order){
        $conn = new mysqli(self::servername, self::username, self::password, "myDB");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if($category=="all"){
            if($order=="asc"){
                $sql = "SELECT id,title,release_date,category,picture,plot,rating FROM MOVIES,member_rating WHERE MOVIES.id=member_rating.movie_id and member_rating.username= '$user' and movies.id=member_rating.movie_id ORDER BY rating ";
            }
            else if($order=="desc"){
                $sql = "SELECT id,title,release_date,category,picture,plot,rating FROM MOVIES,member_rating WHERE MOVIES.id=member_rating.movie_id and member_rating.username= '$user' and movies.id=member_rating.movie_id ORDER BY rating DESC";
            }
        }else{
            if($order=="asc"){
                $sql = "SELECT DISTINCT id,title,release_date,category,picture,plot,rating FROM MOVIES,member_rating WHERE  category = '$category' AND member_rating.username= '$user' and movies.id=member_rating.movie_id ORDER BY rating";
            }
            else if($order=="desc"){
                $sql = "SELECT DISTINCT id,title,release_date,category,picture,plot,rating FROM MOVIES,member_rating WHERE  category = '$category' AND member_rating.username= '$user' and movies.id=member_rating.movie_id ORDER BY rating DESC";
            }
        }

        $result = $conn->query($sql);
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

            $id=$row['id'];
            // Print out the contents of each row into a table

            echo "<form class='row well' style='border: 2px black solid' method='POST' action='member_rating.php' name='update'>
                    <span class='col-md-4 col-xs-4'><img class='text-center' src=$row[picture]></span>
                    <span class='col-md-4 col-xs-4 col-md-offset-2 col-xs-offset-2 text-center' style='vertical-align: middle;'>Title : $row[title]<br>
                    Release date : $row[release_date]<br>";

            switch(round($row['rating'])){
                case 1:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></p>";
                    break;
                case 2:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>☆</span><span>☆</span><span>☆</span></p>";
                    break;
                case 3:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>☆</span><span>☆</span></p>";
                    break;
                case 4:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>☆</span></p>";
                    break;
                case 5:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></p>";
                    break;
                default:
                    echo "<p style='font-size: 20px;'><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></p>";
            }

            echo    "<p>Rating : $row[rating]</p><br>
                    Plot :  $row[plot]<br><br><br><br><br>
                    rate between 1-5  <input type='number' step='any' name='rate' min='1' max='5'>
                    <input  name='update' value='rate' type='submit'>
                    </span>
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='username' value='$user'>
                </form>";
            /* καθε form περναει και το id για να μπορουμε να κανουμε το σωστο movie update*/
        }
        $conn->close();


    }
    public function guestOrderByRating($value,$order){

        $conn = new mysqli(self::servername, self::username, self::password, "myDB");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if($value=="all"){
            if($order=="asc"){
                $sql = "SELECT id,title,release_date,category,picture,plot,guest_rating,counter FROM MOVIES ORDER BY guest_rating/counter";
            }
            else if($order=="desc"){
                $sql = "SELECT id,title,release_date,category,picture,plot,guest_rating,counter FROM MOVIES ORDER BY guest_rating/counter DESC";
            }
        }else{
            if($order=="asc"){
                $sql = "SELECT id,title,release_date,category,picture,plot,guest_rating,counter FROM MOVIES WHERE category = '$value' ORDER BY guest_rating/counter";
            }
            else if($order=="desc"){
                $sql = "SELECT id,title,release_date,category,picture,plot,guest_rating,counter FROM MOVIES WHERE category = '$value' ORDER BY guest_rating/counter DESC";
            }
        }

        $result = $conn->query($sql);
        $i=0;
        $ids=array();
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $ids[$i]=$row['id'];

            if($row['counter']==0){
                $avg=0;
            }else{
                $avg=$row['guest_rating']/$row['counter'];
                $avg=round($avg,2);
            }
            // Print out the contents of each row into a table
            $id=$row['id'];
            echo "<form class='row well' style='border: 2px black solid' method='post' action='guest_rating.php' name='update'>
                <span class='col-md-4 col-xs-4'><img class='text-center' src=$row[picture]></span>
                <span class='col-md-4 col-xs-4 col-md-offset-2 col-xs-offset-2 text-center' style='vertical-align: middle;'>Title : $row[title]<br>
                Release date : $row[release_date]<br>";

            switch(round($avg)){
                case 1:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></p>";
                    break;
                case 2:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>☆</span><span>☆</span><span>☆</span></p>";
                    break;
                case 3:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>☆</span><span>☆</span></p>";
                    break;
                case 4:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>☆</span></p>";
                    break;
                case 5:
                    echo "<p style='font-size: 20px;'><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span></p>";
                    break;
                default:
                    echo "<p style='font-size: 20px;'><span>☆</span><span>☆</span><span>☆</span><span>☆</span><span>☆</span></p>";
            }

            echo "<p>Rating : $avg</p><br>
                Plot :  $row[plot]<br><br><br><br><br>
                rate between 1-5  <input type='number' step='any' name='rate' min='1' max='5'>
                <input  name='update' value='rate' type='submit'>
                </span>
                <input type='hidden' name='id' value='$id'>
                </form>";
            /* καθε form περναει και το id για να μπορουμε να κανουμε το σωστο movie update*/




        }

        $conn->close();

    }
}
?>

