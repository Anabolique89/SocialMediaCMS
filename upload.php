<?php
session_start();
include_once "classes/dbh.classes.php";
$instance = new Dbh();
$conn = $instance->connect();

$id = $_SESSION['userid'];

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    // $fileActualExt = strtolower($fileExt);
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileExt, $allowed) && $fileError === 0 && $fileSize < 5000000) {
        try {
            // Check if a profile image exists
            $sqlCheckImage = "SELECT COUNT(*) as imageCount, NewImgName FROM profileimg WHERE UserID=?";
            $stmt = $conn->prepare($sqlCheckImage);
            $stmt->execute([$id]);
            $rowCheckImage = $stmt->fetch(PDO::FETCH_ASSOC);

            $oldImageName = $rowCheckImage['NewImgName'];

            // Delete the old image
            if (!empty($oldImageName)) {
                $oldImagePath = 'artworks/' . $oldImageName;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload the new image
            $fileNameNew = "artworks" . $id . "." . $fileExt;
            $fileDestination = 'artworks/' . $fileNameNew;

            // Check if the file already exists
            if (file_exists($fileDestination)) {
                // Delete the existing file
                unlink($fileDestination);
            }

            // Attempt to move the new file
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Update or insert into the database
                if ($rowCheckImage['imageCount'] > 0) {
                    $sqlUpdate = "UPDATE profileimg SET NewImgName=?, status=0 WHERE UserID=?";
                } else {
                    $sqlUpdate = "INSERT INTO profileimg (UserID, NewImgName, status) VALUES (?, ?, 0)";
                }

                $stmt = $conn->prepare($sqlUpdate);
                if (!$stmt) {
                    echo "\nPDO::errorInfo():\n";
                    print_r($conn->errorInfo());
                    die();
                }



                $result = $stmt->execute([$fileNameNew, $id]);
                if (!$result) {
                    echo "\nPDO::errorInfo():\n";
                    print_r($stmt->errorInfo());
                    die();
                }


                header("Location: profile.php?uploadsuccess");
                exit();
            } else {
                echo "There was an error uploading your file!";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid file format or file size exceeds the limit.";
    }
}
