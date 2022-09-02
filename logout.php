<script>
    var p = confirm("Log Out?");

    var http = new XMLHttpRequest();
    http.open("POST", "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>", true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onload = () => {
        if(http.responseText == "1") {
            window.location.href = "/login.php";
        }
        else {
            window.location.href = "/";
        }
    }

    if(p) {
        http.send("c=1")
    }
    else {
        http.send("c=0");
    }

</script>

<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if($_POST["c"] == "1") {
            session_start();
            session_unset();
            session_destroy();

            echo "1";
        }
        else {
            echo "0";
        }
    }
?>