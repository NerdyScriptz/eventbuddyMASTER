<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Sharing App</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <header class="d-flex justify-content-between align-items-center py-3">
            <h1 class="text-light">Video Sharing App</h1>
        </header>

        <form action="index.php" method="post" enctype="multipart/form-data" class="upload-form">
            <input type="file" name="video" id="video">
            <input type="submit" value="Upload Video" name="submit">
        </form>

        <div id="video-container" class="row">
            <!-- Videos will be loaded here -->
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $targetDir = "assets/videos/";
        $targetFile = $targetDir . basename($_FILES["video"]["name"]);
        $uploadOk = 1;
        $videoFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is a actual video
        if (isset($_POST["submit"])) {
            $check = mime_content_type($_FILES["video"]["tmp_name"]);
            if (strpos($check, 'video') !== false) {
                $uploadOk = 1;
            } else {
                echo "<div class='alert alert-danger'>File is not a video.</div>";
                $uploadOk = 0;
            }
        }

        // Check file size
        if ($_FILES["video"]["size"] > 50000000) {
            echo "<div class='alert alert-danger'>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($videoFileType != "mp4" && $videoFileType != "avi" && $videoFileType != "mov" && $videoFileType != "wmv") {
            echo "<div class='alert alert-danger'>Sorry, only MP4, AVI, MOV & WMV files are allowed.</div>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
        } else {
            if (move_uploaded_file($_FILES["video"]["tmp_name"], $targetFile)) {
                echo "<div class='alert alert-success'>The file ". htmlspecialchars(basename($_FILES["video"]["name"])) . " has been uploaded.</div>";
            } else {
                echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
            }
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
