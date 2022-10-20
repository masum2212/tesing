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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="css/bootstrap5.css" rel="stylesheet">

    <!-- For Datatables -->
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="css/viewImage.css" />
    <style>
        .pointer {
            cursor: pointer;
        }
    </style>
    <title>Image Tracking System</title>
</head>

<body>

    <?php require "layouts/navbar_sidebar.php"; ?>

    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <h3 class="text-center">All Tracked Record</h3>
            <hr>
            <div class="container mb-4">
                <table class="table table-striped table-hover table-bordered text-center" id="reportTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>User_ID</th>
                            <th>Product</th>
                            <th>Line</th>
                            <th>Point</th>
                            <th>Barcode</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ret = mysqli_query($conn, "select * from track order by id desc");
                        $cnt = 1;
                        $row = mysqli_num_rows($ret);
                        if ($row > 0) {
                            while ($row = mysqli_fetch_array($ret)) {

                        ?>
                                <tr>
                                    <td><?php echo $cnt; ?></td>
                                    <td><?php echo $row['user_id']; ?></td>
                                    <td><?php echo $row['product']; ?></td>
                                    <td><?php echo $row['line']; ?></td>
                                    <td><?php echo $row['point']; ?></td>
                                    <td><?php echo $row['barcode']; ?></td>
                                    <td> <img class="imgcl pointer" src="<?php echo $row['img_path']; ?>" alt="" height="80px" width="120px"></td>
                                </tr>
                            <?php
                                $cnt = $cnt + 1;
                            }
                        } else { ?>
                            <tr>
                                <th style="text-align:center; color:red;" colspan="7">No Record Found</th>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <!-- The Modal -->
                <div id="myModal" class="modal mt-4">
                    <span class="close">&times;</span>
                    <img class="modal-content" id="img01">
                    <div id="caption"></div>
                </div>

            </div>
        </div>
    </main>



    <script src="js/bootstrap5.js"></script>

    <!-- For Datatables -->
    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#reportTable').DataTable();
        });
    </script>

    <script>
        $('.imgcl').on('click', function(e) {
            console.log(this.src);
            var modal = document.getElementById("myModal");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");

            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;

            var span = document.getElementsByClassName("close")[0];

            span.onclick = function() {
                modal.style.display = "none";
            }
        });
    </script>

    <?php
    require "backend/footer.php";
    ?>
</body>

</html>