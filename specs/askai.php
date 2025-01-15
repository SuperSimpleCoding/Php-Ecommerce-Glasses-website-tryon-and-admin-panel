<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Face Shape Detection and Glasses Recommendation</title>
    <script defer src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            font-weight: 500;
            color: #444;
        }
        canvas {
            display: none;
            margin: auto;
            border: 2px solid #333;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        #glassesRecommendation {
            text-align: center;
            margin-top: 20px;
            font-size: 1.2em;
            color: #333;
            padding: 10px;
            display: none;
        }
        /* Modal styles */
        #modal {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8); /* Dark overlay */
            color: white;
            text-align: center;
            transition: opacity 0.5s ease;
        }
        #modal-content {
            background-color: #222;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        #modal h2 {
            font-weight: 700;
            margin-bottom: 10px;
        }
        #modal p {
            font-size: 1.1em;
            color: #ddd;
        }
    </style>
</head>
<body>

    <center><h3>Face Shape Detection and Glasses Recommendation</h3></center>
    <canvas id="canvasOutput" width="640" height="480"></canvas>
    <div id="glassesRecommendation">Analyzing...</div>

    <!-- Modal for showing analysis status -->
    <div id="modal">
        <div id="modal-content">
            <h2>Analyzing...</h2>
            <p>Please wait while we analyze your face shape.</p>
        </div>
    </div>

    <script>
        let video = document.createElement('video');  // Create a hidden video element
        video.playsInline = true;  // For mobile compatibility
        let canvas = document.getElementById('canvasOutput');
        let context = canvas.getContext('2d');
        let faceMesh;
        let videoStream;
        let analysisInProgress = true;
        const modal = document.getElementById('modal');
        const glassesRecommendation = document.getElementById('glassesRecommendation');

        // Load FaceMesh model from MediaPipe
        async function loadFaceMesh() {
            faceMesh = new FaceMesh({locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/${file}`});
            faceMesh.setOptions({
                maxNumFaces: 1,
                refineLandmarks: true,  // Get accurate face landmarks
                minDetectionConfidence: 0.5,
                minTrackingConfidence: 0.5
            });
            faceMesh.onResults(onFaceMeshResults);  // Handle results when face is detected
            startVideo();  // Start video after model is loaded
        }

        // Start the webcam video stream
        function startVideo() {
            navigator.mediaDevices.getUserMedia({ video: true }).then(stream => {
                videoStream = stream;
                video.srcObject = stream;
                video.play();
                detectLandmarks();  // Detect landmarks in real-time
            }).catch(err => {
                console.error("Webcam access denied:", err);
                alert("Webcam access is needed to detect face shape. Please allow access to your webcam.");
                glassesRecommendation.innerText = "Webcam access is required to detect face shape.";
            });
        }

        // Perform real-time face landmark detection
        async function detectLandmarks() {
            video.addEventListener('loadeddata', async () => {
                const detect = async () => {
                    await faceMesh.send({image: video});
                    setTimeout(detect, 100);  // Reduce the frame rate to approximately 10 frames per second
                };
                detect();
            });
        }

        // Callback to process the FaceMesh results
        function onFaceMeshResults(results) {
            if (!analysisInProgress) {
                context.clearRect(0, 0, canvas.width, canvas.height);  // Clear previous frame
                if (results.multiFaceLandmarks && results.multiFaceLandmarks.length > 0) {
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);  // Draw the video frame
                    for (const landmarks of results.multiFaceLandmarks) {
                        drawFaceMesh(landmarks);
                        const faceShape = getFaceShape(landmarks);  // Determine face shape
                        suggestGlasses(faceShape);  // Suggest glasses based on face shape
                    }
                }
            }
        }

        // Draw face mesh landmarks on the canvas
        function drawFaceMesh(landmarks) {
            context.strokeStyle = "#00FF00";
            context.lineWidth = 2;

            for (let i = 0; i < landmarks.length; i++) {
                const x = landmarks[i].x * canvas.width;
                const y = landmarks[i].y * canvas.height;
                context.beginPath();
                context.arc(x, y, 1, 0, 2 * Math.PI);
                context.stroke();
            }
        }

        // Analyze the face landmarks to dynamically determine face shape
        function getFaceShape(landmarks) {
            const leftJaw = landmarks[234];  // Left jaw landmark
            const rightJaw = landmarks[454];  // Right jaw landmark
            const chin = landmarks[152];  // Chin landmark
            const forehead = landmarks[10];  // Forehead landmark
            const leftCheek = landmarks[93];  // Left cheek landmark
            const rightCheek = landmarks[323];  // Right cheek landmark

            const jawWidth = Math.abs(rightJaw.x - leftJaw.x);
            const faceHeight = Math.abs(chin.y - forehead.y);
            const cheekWidth = Math.abs(rightCheek.x - leftCheek.x); // New measurement for dynamic changes

            const ratio = jawWidth / faceHeight;
            const cheekToJawRatio = cheekWidth / jawWidth;

            if (cheekToJawRatio > 1.1) {
                return 'Puffed';
            } else if (ratio < 0.75) {
                return 'Oval';
            } else if (ratio >= 0.75 && ratio <= 0.9) {
                return 'Round';
            } else if (ratio > 0.9) {
                return 'Square';
            } else {
                return 'Unknown';
            }
        }

        // Suggest glasses based on face shape with engaging text
        function suggestGlasses(faceShape) {
            let recommendationText;
            let factText;

            if (faceShape === 'Oval') {
                recommendationText = "You have an oval face shape! Lucky you—oval faces suit almost all types of glasses.";
                factText = "Fun fact: About 20% of people have an oval face shape.";
            } else if (faceShape === 'Round') {
                recommendationText = "You have a round face shape! Rectangular or square glasses will look great on you.";
                factText = "Did you know? Roughly 25% of the population has a round face shape.";
            } else if (faceShape === 'Square') {
                recommendationText = "You have a square face shape! Round or oval glasses will complement your strong jawline.";
                factText = "Interesting: About 15% of people have a square face shape.";
            } else if (faceShape === 'Puffed') {
                recommendationText = "Looks like you've puffed your cheeks! Relax and try again for an accurate result.";
                factText = "";
            } else {
                recommendationText = "We couldn't determine your face shape. Please try again!";
                factText = "";
            }

            glassesRecommendation.innerHTML = `<strong>${recommendationText}</strong><br>${factText}`;
            glassesRecommendation.style.display = 'block';
        }

        // Hide modal and start analysis after 5 seconds
        window.onload = () => {
            loadFaceMesh();
            setTimeout(() => {
                analysisInProgress = false;
                modal.style.opacity = '0';  // Fade out modal
                setTimeout(() => {
                    modal.style.display = "none";  // Hide modal after fade out
                    canvas.style.display = "block";  // Show canvas after the 5 seconds
                }, 500);
            }, 5000);  // 5-second delay before starting analysis
        };
    </script>

</body>
</html>
