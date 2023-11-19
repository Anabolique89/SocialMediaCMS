<?php
session_start();
include_once "includes/dbh.inc.php";

$id = $_SESSION['userid'];

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
            if ($fileSize < 5000000) {
                $stmt = mysqli_stmt_init($conn);

                // Get the old image name
                $oldImageName = '';
                $sqlOldImage = "SELECT NewImgName FROM profileimg WHERE UserID=?";
                if (mysqli_stmt_prepare($stmt, $sqlOldImage)) {
                    mysqli_stmt_bind_param($stmt, "s", $id);
                    mysqli_stmt_execute($stmt);
                    $resultOldImage = mysqli_stmt_get_result($stmt);
                    $rowOldImage = mysqli_fetch_assoc($resultOldImage);
                    $oldImageName = $rowOldImage['NewImgName'];
                } else {
                    echo "SQL statement failed!";
                }

                // Delete the old image
                if (!empty($oldImageName)) {
                    $oldImagePath = 'artworks/' . $oldImageName;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Upload the new image
                $fileNameNew = "artworks" . $id . "." . $fileActualExt;
                $fileDestination = 'artworks/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);

                // Update database
                $sqlUpdate = "UPDATE profileimg SET NewImgName=?, status=0 WHERE UserID=?";
                if (mysqli_stmt_prepare($stmt, $sqlUpdate)) {
                    mysqli_stmt_bind_param($stmt, "ss", $fileNameNew, $id);
                    mysqli_stmt_execute($stmt);
                } else {
                    echo "SQL statement failed!";
                }

                header("Location: profile.php?uploadsuccess");
                echo "<p>Upload Successful!</p>";
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
}
