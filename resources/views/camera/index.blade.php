<x-app-layout>

    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-4">
        <div class="camera bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
            <h3 class="text-xl font-semibold text-center mb-4">Webcam Capture</h3>

            <!-- Video element for webcam stream -->
            <video id="video" width="600" height="540" class="rounded-md shadow-sm" autoplay></video>

            <!-- Buttons to start camera and capture image -->
            <div class="flex space-x-4 mt-4 justify-center">
                <button id="start-camera" class="bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Start Camera
                </button>
                <button id="capture" class="bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Capture Photo
                </button>
            </div>
        </div>

        <!-- Captured image preview -->
        <div class="captured-image mt-6 bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
            <h4 class="text-lg font-medium text-center mb-4">Captured Image Preview</h4>

            <canvas id="canvas" width="600" height="540" class="hidden"></canvas>
            <!-- Preview Image (will display the captured photo) -->
            <img id="photo" src="" alt="Captured Image" class="rounded-md shadow-lg hidden">
        </div>

        <!-- Form to save captured image -->
        <form action="{{ route('system-validator-save-capture-image', $voterId) }}" method="POST" class="mt-6 bg-white shadow-md rounded-lg p-6 w-full max-w-lg">
            @csrf
            <h3 class="text-lg font-semibold mb-4">Save Captured Image</h3>

            <div class="mb-4">
                <label for="image_data" class="block text-sm font-medium text-gray-700">Captured Image Data</label>
                <input type="text" name="image_data" id="image_data" class="block w-full px-4 py-2 text-sm border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter image data here" required readonly>
            </div>

            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 w-full">
                Save Photo
            </button>
        </form>

    </div>

</x-app-layout>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    document.getElementById('start-camera').addEventListener('click', function() {
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(function(stream) {
                var video = document.getElementById('video');
                video.srcObject = stream;
                video.play();
            })
            .catch(function(err) {
                console.log("Error: " + err);
            });
    });

    document.getElementById('capture').addEventListener('click', function() {
        var video = document.getElementById('video');
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        const photo = document.getElementById('photo');

        // Draw the video frame to the canvas
        context.drawImage(video, 0, 0, 600, 540);

        // Convert canvas image to base64
        var dataUrl = canvas.toDataURL('image/png');

        // Set the captured photo to img tag for display
        document.getElementById('photo').src = dataUrl;
        document.getElementById('photo').style.display = 'block';

        // Send the image to Livewire
        document.getElementById('image_data').value = dataUrl;

        // Optionally, hide the video feed
        video.style.display = 'none';
    });
</script>