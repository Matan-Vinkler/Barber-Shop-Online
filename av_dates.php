<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Barber Online</title>
    <link rel="stylesheet" href="assets/stylesheets/cartStyle.css">
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
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/catalog.php">Catalog</a></li>
                    <li class="nav-item"><a class="nav-link" href="/schedule.php">Schedule</a></li>
                    <li class="nav-item"><a class="nav-link" href="/my_schedule.php">My Schedules</a></li>
                    <li class="nav-item"><a class="nav-link" href="/editprofile.php">Edit Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="/logout.php">Log Out</a></li>
                    <li class="nav-item"><a class="nav-link" href="/add_schedule.php">Add Date</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/av_dates.php">Available Dates</a></li>
                    <li class="nav-item"><a class="nav-link" href="/edit_home.php">Edit Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/add_hair.php">Add Haircut</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="py-5 mt-5">
        <div class="container py-5">
        <div class="row mx-auto" style="/*max-width: 700px;*/">
            <div class="col">
                <div class="cart_section">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-10 offset-lg-1">
                                <div class="cart_container">
                                    <div class="cart_title">Available Dates</div>
                                    <?php
                                        session_start();
                                        if($_SERVER["REQUEST_METHOD"] == "POST" and isset($_SESSION["admin"]) and $_SESSION["admin"] == 1) {
                                            $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                                            if($conn->connect_error) {
                                                echo "Connection Failed: " . $conn->connect_error;
                                                die();
                                            }

                                            $date = $_POST["date"];
                                            $sql_query = sprintf("DELETE FROM `dates` WHERE `date`='%s'", $date);
                                
                                            if($conn->query($sql_query) === TRUE) {
                                                header("Location: av_dates.php");
                                            }
                                            else {
                                                echo "Remove Failed: " . $conn->error;
                                            }

                                            $conn->close();
                                        }
                                    ?>
                                    <div class="cart_items">
                                        <ul class="cart_list">
                                            <li class="cart_item clearfix">
                                                <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                                    <div class="cart_item_name cart_info_col">
                                                        <div class="cart_item_title">Date</div>
                                                        <?php
                                                            if(!isset($_SESSION["uid"])) {
                                                                header("Location: login.php");
                                                                die();
                                                            }

                                                            if(isset($_SESSION["admin"]) and $_SESSION["admin"] != 1) {
                                                                header("Location: index.php");
                                                                die();
                                                            }

                                                            if($_SERVER["REQUEST_METHOD"] != "GET") {
                                                                die();
                                                            }
                                                            
                                                            $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                                                            if($conn->connect_error) {
                                                                echo "Connection Failed: " . $conn->connect_error;
                                                                die();
                                                            }
                                                            
                                                            $sql_query = "SELECT * FROM `dates`";
                                                            $result = $conn->query($sql_query);
                                                            
                                                            $tags = "";
                                                            
                                                            if($result->num_rows > 0) {
                                                                while($row = $result->fetch_assoc()) {
                                                                    $date = $row["date"];
                                                            
                                                                    $tags .= sprintf('<div class="cart_item_text">%s</div>', $date);
                                                                }
                                                            
                                                                echo $tags;
                                                            }
                                                            else {
                                                                echo "";
                                                            }
                                                            
                                                            $conn->close();    
                                                        ?>
                                                    </div>
                                                    <div class="cart_item_price cart_info_col">
                                                        <div class="cart_item_title">Remove</div>
                                                        <?php
                                                            if($_SERVER["REQUEST_METHOD"] != "GET") {
                                                                die();
                                                            }
                                                            
                                                            $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                                                            if($conn->connect_error) {
                                                                echo "Connection Failed: " . $conn->connect_error;
                                                                die();
                                                            }
                                                            
                                                            $sql_query = "SELECT * FROM `dates`";
                                                            $result = $conn->query($sql_query);
                                                            
                                                            $tags = "";
                                                            
                                                            if($result->num_rows > 0) {
                                                                while($row = $result->fetch_assoc()) {
                                                                    $date = $row["date"];
                                                                    $tags .= sprintf('<div class="cart_item_text"><form action="%s" method="post"><input type="hidden" name="date" value="%s"><button type="submit"><img src="assets/img/minus.png" style="width: 20px; height: 20px;"/></button></form></div>`', htmlspecialchars($_SERVER["PHP_SELF"]), $date);
                                                                }
                                                            
                                                                echo $tags;
                                                            }
                                                            else {
                                                                echo "";
                                                            }
                                                            
                                                            $conn->close();
                                                        ?>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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