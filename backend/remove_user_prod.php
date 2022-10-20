<?php
require "db_conn.php";
session_start();

$id = $_GET['id'];

$admin_id = $_SESSION['login_user'];


if (isset($_SESSION["admin"]) || isset($_SESSION["super_admin"])) {
    if ($_SESSION["login_user"] == $id) {
        $_SESSION['double_create_error'] = 'You Can Not Remove Yourself!';
        header("location: user.php");
    } else {

        $my_query = "SELECT user_id FROM user_prod WHERE user_id='$id' AND is_active='1'";
        $result = mysqli_query($conn, $my_query) or die("Query Failed");

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {

                $sqlquery = "UPDATE user_prod SET is_active=0 WHERE user_id='$id' AND is_active='1'";

                if (mysqli_query($conn, $sqlquery) === TRUE) {
                    //header("location: user.php");
                } else {
                    echo "Error: " . $sqlquery . "<br>" . $conn->error;
                }

                echo $sqlquery2 = "UPDATE user_role SET is_active=0 WHERE user_id='$id' AND is_active='1'";

                if (mysqli_query($conn, $sqlquery2) === TRUE) {
                    //header("location: user.php");
                } else {
                    echo "Error: " . $sqlquery2 . "<br>" . $conn->error;
                }
            }
        }
    }
} else {
    $_SESSION['double_create_error'] = 'You Are Not Admin or Super-Admin!';
    header("location: user.php");
}
