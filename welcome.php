<?php
session_start();
if ($_SESSION["login_user"] == false) {
    header("location: index.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["product"])) {
        $_SESSION["product"] = $_POST["product"];
        $_SESSION["line"] = $_POST["line"];
        $_SESSION["point"] = $_POST["point"];

        header("location: tracking_panel.php");
    } else {
        session_destroy();
        header("location: index.php");
    }
}
require "backend/db_conn.php";
$user_id = $_SESSION["login_user"];
$myquery = "SELECT * FROM `track`";
$conn_que = mysqli_query($conn, $myquery);
$total_rows = mysqli_num_rows($conn_que);

$myquery = "SELECT * FROM `track` WHERE `user_id`='$user_id'";
$conn_que = mysqli_query($conn, $myquery);
$user_total_rows = mysqli_num_rows($conn_que);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="css/bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />

    <title>Image Tracking System</title>
</head>

<body>

    <?php require "layouts/navbar_sidebar.php"; ?>

    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center">Welcome <b>
                            <?php
                            echo $user_id;
                            if (isset($_SESSION["super_admin"])) {
                                echo " (Super Admin)";
                            } elseif (isset($_SESSION["admin"])) {
                                echo " (Admin)";
                            } else {
                                echo " (User)";
                            }
                            ?>
                        </b>
                    </h3>
                    <?php
                    //var_dump($_SESSION);
                    ?>
                    <hr>

                    <div class="card text-center mb-3">
                        <div class="card-header">
                            <b>Product List</b>
                        </div>
                        <div class="card-body animate__animated animate__backInLeft">

                            <?php
                            $all_prod = $_SESSION['products'];
                            foreach ($all_prod as $x => $val) {
                                echo " <b class='p-2 btn btn-default'>" . $val . "</b> ";
                            }
                            ?>

                        </div>
                    </div>

                    <div class="row text-center animate__animated animate__backInRight">
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <b>Total Tracked</b>
                                </div>
                                <div class="card-body">
                                    <h3 class="text-success"><?php echo $total_rows; ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    <b>Tracked By You</b>
                                </div>
                                <div class="card-body">
                                    <h3 class="text-success"><?php echo $user_total_rows; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <?php
    require "backend/footer.php";
    ?>


    <script src="js/bootstrap5.js"></script>
</body>

</html>