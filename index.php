<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Document</title>
    <style>
        body {
            font: 1em sans-serif;
        }
        li {
            list-style: none;
            color: red;
            margin: 0.5em;
        }
        .img {
            width: 50%;
            height: 5;
        }
    </style>
</head>

<body class="bg-dark text-white text-center">
    <h1>Image Gallery</h1>  
    <form enctype="multipart/form-data" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
        <input type="file" name="image" id="image" class="form-control ">
        <input type="submit" value="Upload Image" name="submit" class="btn btn-primary mt-3">
    </form>
    <?php
    $target_dir = "uploads/";
    if (isset($_FILES['image'])) {
        $images = filter_var($_FILES['image']['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $target_file = $target_dir . basename($images);
        $uploadOk = true;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $error["first"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = false;
        }
        if (isset($_POST["submit"])) {
            if (empty($images)) {
                $error["second"] = "Please select an image.";
                $uploadOk = false;
            } else {
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = true;
                } else {
                    $error["third"] = "File is not an image.";
                    $uploadOk = false;
                }
            }
        }
        if (file_exists($target_file)) {
            $error["fourth"] = "Sorry, file already exists.";
            $uploadOk = false;
        }

        if ($uploadOk == false) {
            echo "<ul>";
            foreach ($error as $key => $value) {
                echo "<li>$value</li>";
            }
            echo "</ul>";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $uploadOk = true;
            }
        }
    }
    $data = [];
    $files = scandir($target_dir);
    foreach ($files as $file) {
        if ($file !== "." && $file !== "..") {
            $data[] = ["image" => $target_dir . $file];
        }
    }
    echo "<div class='container-fluid mt-3'>";
    if (count($data) > 0) {
        echo "<div id='carouselExampleControls' class='carousel slide' data-bs-ride='carousel'>
        <div class='carousel-inner'>";
        foreach ($data as $key => $value) {
            if ($key == 0) {
                echo "<div class='carousel-item active'>
                <img src='" . $value['image'] . "' class='d-block mx-auto img-fluid img' alt='...'>
                </div>";
            } else {
                echo "<div class='carousel-item'>
                <img src='" . $value['image'] . "' class='d-block mx-auto img-fluid img' alt='...'>
                </div>";
            }
        }
        echo "</div>
        <button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleControls' data-bs-slide='prev'>
            <span class='carousel-control-prev-icon' aria-hidden='true'></span>
            <span class='visually-hidden'>Previous</span>
        </button>
        <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleControls' data-bs-slide='next'>
            <span class='carousel-control-next-icon' aria-hidden='true'></span>
            <span class='visually-hidden'>Next</span>
        </button>
        </div>";
    }
    echo "</div>";
    ?>
</body>

</html>