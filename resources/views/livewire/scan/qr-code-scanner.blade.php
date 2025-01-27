<div>
    <video id="video" width="600" height="600" autoplay></video>
    <button wire:click="stopScanning" class="btn btn-danger">Stop Scanning</button>

    @if ($qrCodeData)
    <div class="alert alert-success mt-2">
        Scanned Data: {{ $qrCodeData }}
    </div>
    @endif
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jsQR/1.4.0/jsQR.js"></script>
<script>
    const video = document.getElementById('video');
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');

    navigator.mediaDevices.getUserMedia({
            video: true
        })
        .then(stream => {
            video.srcObject = stream;
            video.setAttribute("playsinline", true); // Required to tell iOS Safari we don't want fullscreen
            video.play();
            requestAnimationFrame(tick);
        });

    function tick() {
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            canvas.height = video.videoHeight;
            canvas.width = video.videoWidth;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, canvas.width, canvas.height);

            if (code) {
                // Stop scanning and set the scanned QR code
                Livewire.find(document.getElementById("{{ $this->getId() }}")).set('qrCodeData', code.data);
                video.srcObject.getTracks().forEach(track => track.stop()); // Stop the video stream
                return;
            }
        }
        requestAnimationFrame(tick);
    }

    window.Livewire.on('stopScanning', () => {
        video.srcObject.getTracks().forEach(track => track.stop()); // Stop the video stream
    });
</script>