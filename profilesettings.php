<?php
include_once "header.php";

include "classes/dbh.classes.php";
include "classes/profileinfo.classes.php";
include "classes/profileinfo-view.classes.php";
$profileInfo = new ProfileInfoView();
?>

<section class="profile">
    <div class="profile-bg">
        <div class="wrapper">
            <div class="profile-settings">
                <h3>PROFILE SETTINGS</h3>
                <p>Change your profile picture here!</p>


                <?php
                //trying to change profile picture here! - but first I'm trying to display a picture next to my form - which is not working. 
                include_once 'includes/dbh.inc.php';

                // $sql = "SELECT * FROM user";
                // $result = mysqli_query($conn, $sql);
                // if (mysqli_num_rows($result) > 0) {
                //     while ($row = mysqli_fetch_assoc($result)) {
                $id = $_SESSION['userid'];
                $sqlImg = "SELECT * FROM profileimg WHERE UserID='$id'";
                $resultImg = mysqli_query($conn, $sqlImg);
                while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                    echo '<div class="user-container">';
                    if ($rowImg['status'] == 0) {
                        echo "<img src='artworks/" . $rowImg['NewImgName'] . "'>";
                    } else {

                        //this is the default image I want to display if the user has not uploaded an image already
                        echo "<img src ='artworks/Default.jpg'>";
                    }
                    echo "</div>";
                }


                if (isset($_SESSION['userid'])) {
                    echo '  <form action="upload.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file">
                    <button type="submit" name="submit">UPLOAD</button>
                </form>';
                } else {
                    echo "You are not logged in!";
                }

                ?>



                <!-- everything below works -->
                <p>Change your about section here!</p>
                <form action="includes/profileinfo.inc.php" method="post">
                    <textarea name="about" rows="10" cols="30" placeholder="Profile about section..." value=""><?php $profileInfo->fetchAbout($_SESSION["userid"]); ?></textarea>
                    <br><br>
                    <p>Change your profile page intro here!</p>
                    <br>
                    <input type="text" name="introtitle" placeholder="Profile title..." value="<?php $profileInfo->fetchTitle($_SESSION["userid"]); ?>">
                    <textarea name="introtext" rows="10" cols="30" placeholder="Profile introduction..."><?php $profileInfo->fetchText($_SESSION["userid"]); ?></textarea>
                    <button type="submit" name="submit">SAVE</button>
                </form>
                <br>

                <!-- I also want to be able to change this info for the user - note to myself -->
                <p>Change your bio info here!</p>
                <br>
                <form action="" method="post">
                    <input type="text" name="firstName" placeholder="First Name">
                    <input type="text" name="lastName" placeholder="Last Name">
                    <input type="date" name="dob" placeholder="Date of Birth">
                    <button type="submit" name="submitUserInfo">SAVE</button>

                </form>
            </div>
        </div>
    </div>
</section>

</body>

</html>