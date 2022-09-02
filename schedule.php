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
                    <li class="nav-item"><a class="nav-link active" href="/schedule.php">Schedule</a></li>
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
                    <h2 class="fw-bold">Schedule</h2>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 col-xl-4">
                    <div class="card">
                        <div class="card-body text-center d-flex flex-column align-items-center">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="mb-3">
                                    <select class="form-control" name="type">
                                        <option value="" disabled selected hidden>Select Type</option>
                                        <option value="single">Single</option>
                                        <option value="couple">Couple</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <select class="form-control" name="haircut">
                                        <option value="" disabled selected hidden>Select Haircut</option>
                                        <?php
                                            if(!isset($_SESSION["uid"])) {
                                                header("Location: login.php");
                                                die();
                                            }

                                            if($_SERVER["REQUEST_METHOD"] == "GET") {
                                                $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                                                if($conn->connect_error) {
                                                    echo "Connection Failed: " . $conn->connect_error;
                                                    die();
                                                }
            
                                                $sql_query = "SELECT * FROM `haircuts`";
                                                $results = $conn->query($sql_query);
                                                $tags = "";

                                                if($results->num_rows > 0) {
                                                    while($row = $results->fetch_assoc()) {
                                                        $name = $row["title"];
                                                        $id = $row["id"];
                                                        $tags .= sprintf('<option value="%s">%s</option>', $id, $name);
                                                    }

                                                    echo $tags;
                                                }
            
                                                $conn->close();
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <select class="form-control" name="time">
                                        <option value="" disabled selected hidden>Select Date</option>
                                        <?php
                                            if($_SERVER["REQUEST_METHOD"] == "GET") {
                                                $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                                                if($conn->connect_error) {
                                                    echo "Connection Failed: " . $conn->connect_error;
                                                    die();
                                                }
            
                                                $sql_query = "SELECT * FROM `dates`";
                                                $results = $conn->query($sql_query);
                                                $tags = "";

                                                if($results->num_rows > 0) {
                                                    while($row = $results->fetch_assoc()) {
                                                        $date = $row["date"];
                                                        $tags .= sprintf('<option value="%s">%s</option>', $date, $date);
                                                    }

                                                    echo $tags;
                                                }
            
                                                $conn->close();
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3"><button class="btn btn-primary shadow d-block w-100" type="submit">Schedule</button></div>
                            </form>

                            <?php
                                function test_input($data) {
                                    $data = trim($data);
                                    $data = stripslashes($data);
                                    $data = htmlspecialchars($data);
                                    return $data;
                                }

                                if($_SERVER["REQUEST_METHOD"] == "POST") {
                                    $type = test_input($_POST["type"]);
                                    $haircut = test_input($_POST["haircut"]);
                                    $time = test_input($_POST["time"]);
                                    $hid = uniqid();

                                    $uid = $_SESSION["uid"];

                                    $conn = new mysqli("localhost:3306", "root", "", "mydatabase");
                                    if($conn->connect_error) {
                                        echo "Connection Failed: " . $conn->connect_error;
                                        die();
                                    }

                                    $sql_query = sprintf("SELECT * FROM `dates` WHERE `date`='%s'", $time);
                                    $results = $conn->query($sql_query);
                                    if($results->num_rows <= 0) {
                                        echo "Can't schedule this time...";
                                        die();
                                    }

                                    $sql_query = sprintf("INSERT INTO `schedule`(`id`, `uid`, `type`, `haircut`, `time`) VALUES ('%s','%s','%s','%s','%s')", $hid, $uid, $type, $haircut, $time);
                                    if($conn->query($sql_query) === TRUE) {
                                        $sql_query = sprintf("DELETE FROM `dates` WHERE `date`='%s'", $time);
                                        $conn->query($sql_query);

                                        $service_plan_id = "1a752a0ea21542a291506470c3021cf5";
                                        $bearer_token = "59798d65ef6b4717b1144b056754d0cc";

                                        $send_from = "+447520651465";
                                        $message = sprintf("Scheduled %s-%s", $haircut, $type);

                                        $sql_query = sprintf("SELECT * FROM `users` WHERE `uid`='%s'", $uid);
                                        $result = $conn->query($sql_query);
                                        if($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();

                                            $recipient_phone_numbers = $row["phone"];

                                            if(stristr($recipient_phone_numbers, ',')){
                                                $recipient_phone_numbers = explode(',', $recipient_phone_numbers);
                                              }else{
                                                $recipient_phone_numbers = [$recipient_phone_numbers];
                                              }                                              

                                            $content = [
                                                'to' => array_values($recipient_phone_numbers),
                                                'from' => $send_from,
                                                'body' => $message
                                              ];
                                              
                                            $data = json_encode($content);
                                              
                                            $ch = curl_init("https://us.sms.api.sinch.com/xms/v1/{$service_plan_id}/batches");
                                            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BEARER);
                                            curl_setopt($ch, CURLOPT_XOAUTH2_BEARER, $bearer_token);
                                            curl_setopt($ch, CURLOPT_POST, true);
                                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                              
                                            $result = curl_exec($ch);
                                              
                                            if(curl_errno($ch)) {
                                                echo 'Curl error: ' . curl_error($ch);
                                            } else {
                                                header("Location: my_schedule.php");
                                            }

                                            curl_close($ch);
                                        }
                                    }
                                    else {
                                        if(substr($conn->error, 0, 15) == "Duplicate entry") {
                                            echo "Can't schedule this time...";
                                        }
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