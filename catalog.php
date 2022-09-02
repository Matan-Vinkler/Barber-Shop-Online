<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Barber Online</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.reflowhq.com/v1/toolkit.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;display=swap">
    <link rel="stylesheet" href="assets/stylesheets/style.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md fixed-top navbar-shrink py-3" id="mainNav">
        <div class="container"><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <a href="/"><img src="assets/img/icon.png" style="width: 100px; height: 60px; position: absolute; left: 1%; top: 15px"></a>
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/catalog.php">Catalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="/schedule.php">Schedule</a></li>
                    <li class="nav-item"><a class="nav-link" href="/my_schedule.php">My Schedules</a></li>
                    <li class="nav-item"><a class="nav-link" href="/editprofile.php">Edit Profile</a></li>
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
                    <h2 class="fw-bold">Our Catalog</h2>
                </div>
            </div>
            <div class="row mx-auto" style="/*max-width: 60px;*/ position: absolute; left: 30%;">
            <div>
                <?php
                    if(!isset($_SESSION["uid"])) {
                        header("Location: login.php");
                        die();
                    }

                    $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                    if($conn->connect_error) {
                        echo "Connection Failed: " . $conn->connect_error;
                        die();
                    }

                    if($_SERVER["REQUEST_METHOD"] == "GET") {
                        $sql_query = "SELECT * FROM `haircuts`";
                        $result = $conn->query($sql_query);

                        $tags = "";

                        if($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $id = $row["id"];
                                $title = $row["title"];
                                $description = $row["description"];
                                $price = $row["price"];
                                $image = "assets/img/catalog/" . $id . ".png";

                                if(isset($_SESSION["admin"]) and $_SESSION["admin"] == 1) {
                                    $removeTag = sprintf('<div class="button"><form action="%s" method="post"><input type="hidden" name="haircut" value="%s"><button type="submit">REMOVE</button></form>', htmlspecialchars($_SERVER["PHP_SELF"]), $id);
                                }
                                else {
                                    $removeTag = "";
                                }

                                $tags .= sprintf('<div class="outer"><div class="content animated fadeInLeft"><h4>%s</h4><p id="desc">%s</p>%s$<img src="%s" width="150px" class="animated fadeInRight">%s</div></div></div>', $title, $description, $price, $image, $removeTag);
                            }

                            echo $tags;
                        }
                        else {
                            echo "";
                        }
                    }

                    else if($_SERVER["REQUEST_METHOD"] == "POST") {
                        function test_input($data) {
                            $data = trim($data);
                            $data = stripslashes($data);
                            $data = htmlspecialchars($data);
                            return $data;
                        }

                        $haircut = test_input($_POST["haircut"]);

                        $sql_query = sprintf("DELETE FROM `haircuts` WHERE `id`='%s'", $haircut);
                                
                        if($conn->query($sql_query) === TRUE) {
                            unlink("assets/img/catalog/" . $haircut . ".png");
                            header("Location: catalog.php");
                        }
                        else {
                            echo "Remove Failed: " . $conn->error;
                        }
                    }

                    $conn->close();
                ?>
            </div>
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