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
                    <li class="nav-item"><a class="nav-link active" href="/editprofile.php">Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout.php">Log Out</a></li>
                    <?php
                        session_start();
                        if(isset($_SESSION["admin"]) and $_SESSION["admin"] == 1) {
                            $addScheduleTag = '<li class="nav-item"><a class="nav-link" href="/add_schedule.php">Add Date</a></li>';
                            $avDatesTag = '<li class="nav-item"><a class="nav-link" href="/av_dates.php">Available Dates</a></li>';
                            $editHomeTag = '<li class="nav-item"><a class="nav-link" href="/edit_home.php">Edit Home</a></li>';
                            $addHaircutTag = '<li class="nav-item"><a class="nav-link" href="/add_hair.php">Add Haircut</a></li>';

                            echo $addScheduleTag . $avDatesTag . $editHomeTag . $addHaircutTag;
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <section class="py-5 mt-5">
        <div class="container py-5">
            <div class="row mb-4 mb-lg-5">
                <div class="col-md-8 col-xl-6 text-center mx-auto">
                    <h2 class="fw-bold">Edit Profile</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center">
                            <div class="bs-icon-xl bs-icon-circle bs-icon-primary shadow bs-icon my-4"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"></path>
                                </svg></div>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3"><input class="form-control" type="text" name="fullname" placeholder="Full Name"></div>
                                <div class="mb-3"><input class="form-control" type="text" name="username" placeholder="Username"></div>
                                <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email"></div>
                                <div class="mb-3"><input class="form-control" type="text" name="phone" placeholder="Phone"></div>
                                <div class="mb-3"><button class="btn btn-primary shadow d-block w-100" type="submit">Apply Changes</button></div>
                            </form>

                            <?php
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

                                if($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $fullname = test_input($_POST["fullname"]);
                                    $username = test_input($_POST["username"]);
                                    $email = test_input($_POST["email"]);
                                    $phone = test_input($_POST["phone"]);

                                    $uid = $_SESSION["uid"];

                                    if(!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($fullname) || empty($username) || empty($phone)) {
                                        echo "Invalid Data";
                                        die();
                                    }

                                    $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                                    if($conn->connect_error) {
                                        echo "Connection Failed: " . $conn->connect_error;
                                        die();
                                    }

                                    $sql_query = sprintf("UPDATE `users` SET `username`='%s', `fullname`='%s', `email`='%s', `phone`='%s' WHERE `uid`='%s'", $username, $fullname, $email, $phone, $uid);
                                    if($conn->query($sql_query) === TRUE) {
                                        header("Location: index.php");
                                    }
                                    else {
                                        echo "Edit Profile Failed: " . $conn->error;
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