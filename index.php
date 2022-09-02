<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Barber Online</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.reflowhq.com/v1/toolkit.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <a href="/"><img src="assets/img/icon.png" style="width: 100px; height: 60px; position: absolute; left: 1%; top: 15px"></a>
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
                    <?php
                        $loginTag = '<li class="nav-item"><a class="nav-link" href="/login.php">Log in</a></li>';
                        $signupTag = '<li class="nav-item"><a class="nav-link" href="/signup.php">Sign Up</a></li>';
                        $logoutTag = '<li class="nav-item"><a class="nav-link" href="/logout.php">Log Out</a></li>';
                        $editProfileTag = '<li class="nav-item"><a class="nav-link" href="/editprofile.php">Edit Profile</a></li>';
                        $catalogTag = '<li class="nav-item"><a class="nav-link" href="/catalog.php">Catalog</a></li>';
                        $scheduleTag = '<li class="nav-item"><a class="nav-link" href="/schedule.php">Schedule</a></li>';
                        $myScheduleTag = '<li class="nav-item"><a class="nav-link" href="/my_schedule.php">My Schedules</a></li>';

                        session_start();

                        if(isset($_SESSION["uid"])) {
                            echo $catalogTag . $scheduleTag . $myScheduleTag . $editProfileTag . $logoutTag;
                        }
                        else {
                            echo $loginTag . $signupTag;
                        }

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
                    <h2 class="fw-bold">Barber Online</h2>
                    <h3 class="fw">Barber Shop Online</h3>
                    <p class="text-muted w-lg-50"><b>
                        <?php
                            $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                            if($conn->connect_error) {
                                echo "Connection Failed: " . $conn->connect_error;
                                die();
                            }
                            
                            $sql_query = sprintf("SELECT * FROM `homepage`");
                            $result = $conn->query($sql_query);
                            
                            if($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo $row["about"];
                            }
                            else {
                                echo "Error:" . $conn->error;
                            }
                            
                            $conn->close();
                        ?>
                    </b></p>
                </div>
            </div>
            <div class="row mx-auto" style="/*max-width: 60px;">
                <img src="assets/img/deals.png" style="width: 600px; height: 300px; display: block; margin-left: auto; margin-right: auto;">
            </div>
        </div>
    </section>
    <footer class="bg-primary-gradient"></footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.reflowhq.com/v1/toolkit.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/bold-and-bright.js"></script>
</body>

</html>