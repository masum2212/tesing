<?php
session_start();

if (isset($_SESSION["product"]) && isset($_SESSION["line"]) && isset($_SESSION["point"])) {
    header("location: tracking_panel.php");
}
if (!isset($_SESSION["login_user"])) {
    header("location: index.php");
} else {
    require "backend/db_conn.php";
}
$all_user_prods = $_SESSION['products'];
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
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <h3 class="text-center mb-2">Panel Setup</h3>
                    <hr>
                    <div class="row">
                        <div class="col-3">

                        </div>
                        <div class="col-6">
                            <div class="card p-3">
                                <form action="panel_setup.php" method="post">

                                    <div class="row g-3 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Product</label>
                                        </div>
                                        <div class="col">
                                            <select class="form-select mb-1" aria-label="Default select example" name="product" id="category-dropdown" required>
                                                <option value="">Select One</option>
                                                <?php
                                                foreach ($all_user_prods as $key => $value) {
                                                ?>
                                                    <option value="<?php echo $key; ?>">

                                                        <?php echo $value; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Line</label>
                                        </div>
                                        <div class="col">
                                            <select class="form-select mb-1" aria-label="Default select example" name="line" id="sub-category-dropdown" required>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-items-center">
                                        <div class="col-3">
                                            <label for="" class="col-form-label">Point</label>
                                        </div>
                                        <div class="col">
                                            <select class="form-select mb-1" aria-label="Default select example" name="point" required>
                                                <option value="">Select One</option>
                                                <option value="packaging_point">Packaging Point</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-items-center">
                                        <div class="col-3">

                                        </div>
                                        <div class="col-3">
                                            <input type="submit" class="btn btn-primary" value="Save">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/bootstrap5.js"></script>

    <script type="text/javascript" src="js/jquery-3.5.1.js"></script>

    <script>
        $(document).ready(function() {
            $('#category-dropdown').on('change', function() {
                var short_code = this.value;
                console.log(short_code);
                $.ajax({
                    url: "backend/fetch_line.php",
                    type: "POST",
                    data: {
                        short_code: short_code
                    },
                    cache: false,
                    success: function(result) {
                        $("#sub-category-dropdown").html(result);
                        console.log(result);
                    }
                });
            });
        });
    </script>

    <?php
    require "backend/footer.php";
    ?>

</body>

</html>