<?php
session_start();
include_once "../includes/dbh.inc.php";
$userID = $_SESSION["userid"];
if (isset($_POST['submit'])) {

    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');


    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 500000) {
                //$fileNameNew = uniqid('', true) . "." . $fileActualExt;
                $fileNameNew = "artworks" . $userID . "." . $fileActualExt;
                $fileDestination = 'artworks/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);


                // i have created a new table in the database following the tutorial - the new table will have the status if there is a image uploaded or no
                $sql = "SELECT * FROM profileimg;";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL statement failed!";
                 } else{
                     mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                  $rowCount = mysqli_num_rows($result);
                   $setImageOrder = $rowCount + 1;
                $sql = "UPDATE profileimg SET status=0 WHERE userid='$userID'";
                $result = mysqli_query($conn, $sql);

                //insert image data in database

                header("Location: profile.php?uploadsuccess");
                echo "<p>Upload Successful!</p>";

                //        $sql = "INSERT INTO profileimg (NewImgName, status, UserId) VALUES (?, ?, ?);";
                //        if (!mysqli_stmt_prepare($stmt, $sql)) {
                //           echo "SQL statement failed!";
                //       } else {
                //            mysqli_stmt_bind_param($stmt, "ss", $fileNameNew, $userID);
                //           mysqli_stmt_execute($stmt);

            
        } else {
            echo "Your file is too big! Please upload a smaller file.";
        }
    } else {
        echo "There was an error uploading your file!";
    }
} else {
    echo "You cannot upload files of this type!";
    exit();
}
