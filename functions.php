<?php
session_start();
include_once "classes/dbh.classes.php";
$instance = new Dbh();
$conn = $instance->connect();

$id = $_SESSION['userid'];

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    // Pass the database connection to the functions
    $uploadResult = uploadNewImage($file, $id, $conn);

    if ($uploadResult['success']) {
        updateDatabase($id, $uploadResult['fileNameNew'], $uploadResult['imageCount'], $conn);
        header("Location: profile.php?uploadsuccess");
        exit();
    } else {
        echo $uploadResult['message'];
    }
}


function deleteOldImage($oldImage)
{
    if (!empty($oldImage)) {
        $oldImagePath = 'img/artworks/' . $oldImage;
        if (file_exists($oldImagePath)) {
            unlink($oldImagePath);
        }
    }
}

function uploadNewImage($file, $id, $conn)
{
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($fileActualExt, $allowed) && $fileError === 0 && $fileSize < 5000000) {
        try {
            // Check if a profile image exists
            $sqlCheckImage = "SELECT COUNT(*) as imageCount, NewImgName FROM profileimg WHERE UserID=?";
            $stmt = $conn->prepare($sqlCheckImage);
            $stmt->execute([$id]);
            $rowCheckImage = $stmt->fetch(PDO::FETCH_ASSOC);

            // Delete the old image
            deleteOldImage($rowCheckImage['NewImgName']);

            // Upload the new image
            $fileNameNew = "artworks" . $id . "." . $fileActualExt;
            $fileDestination = 'img/artworks/' . $fileNameNew;


            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                return ['success' => true, 'fileNameNew' => $fileNameNew, 'imageCount' => $rowCheckImage['imageCount']];
            } else {
                return ['success' => false, 'message' => "There was an error uploading your file!"];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => "Error: " . $e->getMessage()];
        }
    } else {
        return ['success' => false, 'message' => "Invalid file format or file size exceeds the limit."];
    }
}

function UpdateDatabase($conn, $id, $imageCount, $fileNameNew)
{
    // Update or insert into the database
    if ($imageCount > 0) {
        $sqlUpdate = "UPDATE profileimg SET NewImgName=?, status=0 WHERE UserID=?";
    } else {
        $sqlUpdate = "INSERT INTO profileimg (UserID, NewImgName, status) VALUES (?, ?, 0)";
    }

    $stmt = $conn->prepare($sqlUpdate);
    $stmt->execute([$fileNameNew, $id]);
}
