<?php
session_start();
if (!isset($_SESSION["login_user"])) {
    header("location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_destroy();
    header("location: index.php");
}

$prod = $_SESSION['product'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="css/bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css" />

    <style>
        #my_camera {
            border: 1px solid black;
        }
    </style>
    <title>Image Tracking System</title>
</head>

<body>

    <?php require "layouts/navbar_sidebar.php"; ?>

    <main class="mt-5 pt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center mb-2">Tracking Panel</h3>
                    <hr>

                    <h6>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">Track</li>
                                <li class="breadcrumb-item"><?php echo $_SESSION['products'][$prod]; ?></li>
                                <li class="breadcrumb-item"><?php echo $_SESSION['line']; ?></li>
                                <li class="breadcrumb-item active"><?php echo $_SESSION['point']; ?></li>
                            </ol>
                            <hr>
                        </nav>
                    </h6>
                    <div class="row">
                        <div class="col-6">
                            <div class="">
                                <div class="row">
                                    <div class="col-2">
                                        <label for="" class="col-form-label"></label>
                                    </div>
                                    <div class="col-7">
                                        <input type=button value="Start" id="submitBtnId" class="btn btn-sm btn-primary mb-1" onClick="init()">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <label for="" class="col-form-label">Barcode</label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control" id='barcode' placeholder="enter barcode">
                                    </div>
                                </div>

                                <div class="row align-items-center mt-3">
                                    <div class="col-2">
                                    </div>
                                    <div class="col-3">
                                        <div id="my_camera"></div>
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="col-3">
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-6">
                            <?php
                            if (isset($_SESSION["last_img"])) {
                            ?>
                                <h4 id="last_barcode_h_id"><b>Last Barcode: </b><?php echo $_SESSION["barcode"] ?></h4>
                                <p id='last_res_img'><img id='res_img' src="<?php echo $_SESSION["last_img"] ?>" alt="" width="510" height="380"></p>
                            <?php
                            } else {
                            ?>
                                <h4 id="last_barcode_h_id"></h4>
                                <p id='last_res_img'></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div id='log_bar'></div>
                        <div id='log_bar2'></div>
                        <div id="label-container"></div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <script src="js/bootstrap5.js"></script>
    <script type="text/javascript" src="js/webcam.min.js"></script>

    <script language="JavaScript">
        var shoot_me = 0;
        var last_barcode_cap = document.getElementById("barcode").value;
        var last_img = '';

        var input = document.getElementById("barcode");
        var barcode = input.value;
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                document.getElementById("submitBtnId").click();
            }
        });

        function configure() {
            Webcam.set({
                width: 440,
                height: 300,
                dest_width: 1280,
                dest_height: 720,
                image_format: 'jpeg',
                jpeg_quality: 95
            });
            Webcam.attach('#my_camera');
        }

        configure();

        function saveSnap() {
            let barcode = document.getElementById("barcode").value;

            Webcam.snap(function(data_uri) {
                var url = 'upload.php?barcode=' + last_barcode_cap;
                Webcam.reset();
                console.log(last_barcode_cap);
                Webcam.upload(data_uri, url, function(code, text) {
                    console.log('Save successfully');
                    console.log(text);
                    document.getElementById("log_bar2").innerHTML = "Captured..";
                    document.getElementById("last_barcode_h_id").innerHTML = "<b>Last Barcode:</b> " + last_barcode_cap;
                    document.getElementById("last_res_img").innerHTML = '<img src="' + data_uri + '" alt="" width="510" height="380">';
                });
            });
        }
    </script>
    <script src="detect/tf.min.js"></script>
    <script src="detect/teachablemachine-image.min.js"></script>
    <script type="text/javascript">
        const URL = "./detect/model/";

        var stop_flag = 1;

        let model, webcam, labelContainer, maxPredictions;

        async function init() {
            document.getElementById("log_bar").innerHTML = "Please Wait.......";
            const modelURL = URL + "model.json";
            const metadataURL = URL + "metadata.json";
            model = await tmImage.load(modelURL, metadataURL);
            maxPredictions = model.getTotalClasses();

            const flip = true;
            webcamtf = new tmImage.Webcam(400, 400, flip);
            await webcamtf.setup();
            await webcamtf.play();
            window.requestAnimationFrame(loop);

            labelContainer = document.getElementById("label-container");
            // for (let i = 0; i < maxPredictions; i++) {
            //     labelContainer.appendChild(document.createElement("div"));
            // }

        }

        async function loop() {
            webcamtf.update();
            await predict();
            if (stop_flag) {
                window.requestAnimationFrame(loop);
            }

        }

        async function predict() {
            let temp = 0.0;
            var product = <?php echo "'" . $prod . "'"; ?>;
            if (product == 'ac_ind') {
                product = 'ac_indoor';
            }
            if (product == 'ac_out') {
                product = 'ac_outdoor';
            }
            const prediction = await model.predict(webcamtf.canvas);
            for (let i = 0; i < maxPredictions; i++) {

                temp = parseFloat(prediction[i].probability.toFixed(2));

                if (prediction[i].className == product && temp >= 0.98) {
                    console.log(product + " class get!");

                    const classPrediction = prediction[i].className + ": " + prediction[i].probability.toFixed(2);
                    labelContainer.innerHTML = classPrediction;
                    //stop_flag = 0;
                    let barcode = document.getElementById("barcode").value;
                    if (barcode.length >= 5) {
                        last_barcode_cap = barcode;
                        document.getElementById("barcode").value = '';
                        document.getElementById("log_bar2").innerHTML = "Found and Capturing....";

                        saveSnap();
                        configure();

                    } else {
                        document.getElementById("log_bar2").innerHTML = "Shortage Barcode....";
                    }

                } else {
                    const classPrediction = "....";
                    //labelContainer.innerHTML = classPrediction;
                    document.getElementById("log_bar").innerHTML = product + " - Searching.......";
                }
            }
        }
    </script>

    <?php
    require "backend/footer.php";
    ?>

</body>

</html>