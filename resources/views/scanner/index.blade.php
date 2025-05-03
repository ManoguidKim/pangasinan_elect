<x-app-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-4">

        @if(session()->has('message'))
        <div class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">{{ session('message') }}!</span>
            </div>
        </div>
        @endif

        @if(session()->has('error'))
        <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-100 dark:bg-gray-800 dark:text-green-400" role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">{{ session('error') }}!</span>
            </div>
        </div>
        @endif

        <h3 class="text-xl font-semibold text-center mb-4">QR Code Scanner</h3>

        <!-- Video element for QR code scanning -->
        <div id="reader" style="width:300px;"></div>
        <!-- <input type="text" id="id"> -->
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");
        let hasScanned = false; // prevent multiple scans

        function onScanSuccess(decodedText, decodedResult) {
            if (hasScanned) return; // prevent duplicate handling

            hasScanned = true; // lock scanning
            console.log("QR code scanned:", decodedText);

            // Stop the scanner
            html5QrCode.stop().then(() => {
                console.log("Scanner stopped.");
            }).catch(err => {
                console.error("Error stopping scanner:", err);
            });

            // Set the input and show a message (optional)
            document.getElementById("id").value = decodedText;
            showProcessingMessage(); // optional feedback

            // Delay the form submission by 1 second
            setTimeout(() => {
                document.getElementById("btnValidate").click();
            }, 1000);
        }

        function showProcessingMessage() {
            const message = document.createElement("div");
            message.innerText = "Processing QR code...";
            message.className = "text-blue-600 font-semibold mt-4";
            document.querySelector("#reader").appendChild(message);
        }

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras.length > 1) {
                html5QrCode.start(
                    cameras[1].id, {
                        fps: 20,
                        qrbox: 500
                    }, onScanSuccess
                );
            } else if (cameras.length > 0) {
                html5QrCode.start(
                    cameras[1].id, {
                        fps: 20,
                        qrbox: 500
                    }, onScanSuccess
                );
            } else {
                alert("No camera found.");
            }
        }).catch(err => {
            alert("Camera error: " + err);
        });
    </script>

    <form action="{{ route('admin-scanner-result') }}" method="post" hidden>
        @csrf
        <div class="form-group">
            <small class="text-info">Control No.</small>
            <input type="text" name="voterid" id="id" class="form-control text-center">
        </div>
        <input type="submit" id="btnValidate" name="btnValidate" value="Check Validity" class="btn btn-info btn-sm btn-block">
    </form>

</x-app-layout>