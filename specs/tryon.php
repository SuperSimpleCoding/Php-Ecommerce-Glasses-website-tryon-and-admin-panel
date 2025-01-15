<?php
// Database connection
$db = mysqli_connect("localhost", "root", "", "ecom_store");

// Path to the original directory where images are currently stored
$sourceDirectory = '../admin_area/product_images/'; // Adjusted as requested
$destinationDirectory = 'downloaded_images/';

// Create destination folder if it doesn't exist
if (!is_dir($destinationDirectory)) {
    mkdir($destinationDirectory, 0777, true);
}

// Retrieve images from the database
$query = "SELECT product_img6 FROM products WHERE product_img6 IS NOT NULL";
$result = mysqli_query($db, $query);

// Array to store valid image paths
$validImages = [];

while ($row = mysqli_fetch_assoc($result)) {
    $imageName = $row['product_img6'];
    $sourcePath = $sourceDirectory . $imageName;
    $destinationPath = $destinationDirectory . $imageName;

    // Check if source image exists, then copy to destination
    if (file_exists($sourcePath)) {
        copy($sourcePath, $destinationPath);
        $validImages[] = $imageName;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Virtual Glasses Try-On</title>
    <style>
        body {
            text-align: center;
            position: relative;
        }
        #video, #overlay {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2em;
            cursor: pointer;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 50%;
        }
        #leftButton { left: 10%; }
        #rightButton { right: 10%; }
    </style>
</head>
<body>
    <h1>Try On Glasses</h1>
    <video id="video" width="640" height="480" autoplay></video>
    <canvas id="overlay" width="640" height="480"></canvas>
    <button id="leftButton" class="nav-button">&#9664;</button>
    <button id="rightButton" class="nav-button">&#9654;</button>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/clmtrackr/1.1.2/clmtrackr.min.js"></script>

    <script>
        var video = document.getElementById('video');
        var canvas = document.getElementById('overlay');
        var context = canvas.getContext('2d');
        var glasses = new Image();

        // Array of valid glasses images
        var glassesImages = <?php echo json_encode($validImages); ?>;
        var currentIndex = 0;

        // Load the first image if available
        if (glassesImages.length > 0) {
            glasses.src = 'downloaded_images/' + glassesImages[currentIndex];
        }

        // Access user's webcam
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                video.srcObject = stream;
            })
            .catch(function (err) {
                console.error("Error accessing webcam: " + err);
            });

        // Set up clmtrackr
        var tracker = new clm.tracker();
        tracker.init();
        tracker.start(video);

        function drawGlasses(positions) {
            context.clearRect(0, 0, canvas.width, canvas.height);

            if (positions.length > 0) {
                var leftEye = positions[27];
                var rightEye = positions[32];

                var eyeDistance = Math.sqrt(
                    Math.pow(rightEye[0] - leftEye[0], 2) +
                    Math.pow(rightEye[1] - leftEye[1], 2)
                );

                var glassesWidth = eyeDistance * 2;
                var glassesHeight = glassesWidth / 2.5;
                var glassesX = leftEye[0] - glassesWidth * 0.3;
                var glassesY = leftEye[1] - glassesHeight * 0.6;

                context.drawImage(glasses, glassesX, glassesY, glassesWidth, glassesHeight);
            }
        }

        // Animation loop
        function animate() {
            var positions = tracker.getCurrentPosition();
            if (positions) {
                drawGlasses(positions);
            }
            requestAnimationFrame(animate);
        }

        // Left button click event
        document.getElementById('leftButton').addEventListener('click', function () {
            currentIndex = (currentIndex - 1 + glassesImages.length) % glassesImages.length;
            glasses.src = 'downloaded_images/' + glassesImages[currentIndex];
        });

        // Right button click event
        document.getElementById('rightButton').addEventListener('click', function () {
            currentIndex = (currentIndex + 1) % glassesImages.length;
            glasses.src = 'downloaded_images/' + glassesImages[currentIndex];
        });

        animate();
    </script>
</body>
</html>
