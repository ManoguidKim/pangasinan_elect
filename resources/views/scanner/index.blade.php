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
        <video id="preview" autoplay></video>

        <!-- Result display -->
        <div id="result" class="mt-4 text-lg"></div>
    </div>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            scanPeriod: 5,
            mirror: false
        });

        scanner.addListener('scan', function(content) {
            document.getElementById("id").value = content;
            document.getElementById("btnValidate").click();
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found..');
            }
        }).catch(function(e) {
            alert(e);
        });
    </script>

    <form action="{{ route('admin-scanner-result') }}" method="post" hidden>
        @csrf
        <div class="form-group">
            <small class="text-info">Control No.</small>
            <input type="text" name="voterid" id="id" class="form-control text-center" readonly>
        </div>
        <input type="submit" id="btnValidate" name="btnValidate" value="Check Validity" class="btn btn-info btn-sm btn-block">
    </form>

</x-app-layout>