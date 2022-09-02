<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Barber Online</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <a href="/"><img src="assets/img/icon.png" style="width: 100px; height: 60px; position: absolute; left: 1%; top: 15px"></a>
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/catalog.php">Catalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="/schedule.php">Schedule</a></li>
                    <li class="nav-item"><a class="nav-link" href="/my_schedule.php">My Schedules</a></li>
                    <li class="nav-item"><a class="nav-link" href="/editprofile.php">Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout.php">Log Out</a></li>
                    <li class="nav-item"><a class="nav-link" href="/add_schedule.php">Add Date</a></li>
                    <li class="nav-item"><a class="nav-link" href="/av_dates.php">Available Dates</a></li>
                    <li class="nav-item"><a class="nav-link" href="/edit_home.php">Edit Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/add_hair.php">Add Haircut</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="py-5 mt-5">
        <div class="container py-5">
            <div class="row mb-4 mb-lg-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold">Add Haircut</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                <div class="mb-3"><input class="form-control" type="text" name="title" placeholder="Name"></div>
                                <div class="mb-3"><textarea class="form-control" name="description" rows="5" cols="33" placeholder="Description"></textarea></div>
                                <div class="mb-3"><input class="form-control" type="number" name="price" placeholder="Price ($)"></div>
                                <div class="mb-3"><input class="form-control" type="file" name="image_file" accept="image/png"></div>
                                <div class="mb-3"><button class="btn btn-primary shadow d-block w-100" type="submit">Add</button></div>
                            </form>
                            <?php    
                                session_start();

                                function test_input($data) {
                                    $data = trim($data);
                                    $data = stripslashes($data);
                                    $data = htmlspecialchars($data);
                                    return $data;
                                }

                                if(!isset($_SESSION["uid"])) {
                                    header("Location: login.php");
                                    die();
                                }

                                if(isset($_SESSION["admin"]) and $_SESSION["admin"] != 1) {
                                    header("Location: index.php");
                                    die();
                                }

                                if($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $title = test_input($_POST["title"]);
                                    $description = test_input($_POST["description"]);
                                    $price = test_input($_POST["price"]);
                                    $imageFile = $_FILES["image_file"];

                                    $id = uniqid();

                                    if($imageFile["size"] == 0 or empty($title) or empty($description) or empty($price)) {
                                        echo "Fields cannot be empty";
                                        die();
                                    }

                                    $imageFileType = strtolower(pathinfo($imageFile["name"],PATHINFO_EXTENSION));
                                    if($imageFileType != "png") {
                                        echo "Sorry, only PNG files are allowed.";
                                        die();
                                    }

                                    $imagePath = "assets/img/catalog/" . $id . ".png";

                                    if (!move_uploaded_file($imageFile["tmp_name"], $imagePath)) {
                                        echo "Sorry, there was an error uploading your file.";
                                        die();
                                    }

                                    $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                                    if($conn->connect_error) {
                                        echo "Connection Failed: " . $conn->connect_error;
                                        die();
                                    }

                                    $sql_query = sprintf("INSERT INTO `haircuts`(`id`, `title`, `description`, `price`) VALUES ('%s','%s','%s','%s')", $id, $title, $description, $price);
                                    if($conn->query($sql_query) === TRUE) {
                                        header("Location: catalog.php");
                                    }
                                    else {
                                        echo "Error: " . $conn->error;
                                    }

                                    $conn->close();
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-primary-gradient"></footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-bright.js"></script>
</body>

</html>