<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //grabbing the data

    $username = htmlspecialchars($_POST["username"], ENT_QUOTES, 'UTF-8');
    $pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, 'UTF-8');
    $pwdRepeat = htmlspecialchars($_POST["pwdRepeat"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $profile = htmlspecialchars($_POST["UserProfile"], ENT_QUOTES, 'UTF-8');

    //instantiate signup controller class - create an object based off  a class 

    include "../classes/dbh.classes.php";
    include "../classes/signup.classes.php";
    include "../classes/signup.contr.classes.php";

    $signup = new SignupContr($username, $pwd, $pwdRepeat, $email, $profile);


    //running error handlers & user signup
    $signup->signupUser();


    $userID = $signup->fetchUserId($username);

    //Instantiate ProfileInfoContr class
    include "../classes/profileinfo.classes.php";
    include "../classes/profileinfo-contr.classes.php";
    $profileInfo = new ProfileInfoContr($username, $userID);
    $profileInfo->defaultProfileInfo();

    $_SESSION["userid"] =  $userID;
    $_SESSION["username"] = $username;



    //create profile from our user


    //going back to front page 
    header("location: ../profile.php?error=none");
}
