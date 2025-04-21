<?php

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generating Qr Code</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="content-wrapper bg-white">
        <div class="content pt-2">
            <div class="container">
                <?php
                $numOfCols = 2;
                $rowCount = 0;
                $bootstrapColWidth = 12 / $numOfCols;
                ?>
                <div class="row">
                    <?php
                    foreach ($voters as $row) {
                        $options = new QROptions([
                            'eccLevel' => QRCode::ECC_H,
                            'imageBase64' => true,
                            'logoSpaceHeight' => 0,
                            'logoSpaceWidth' => 0,
                            'scale' => 2,
                            'version' => 2,
                        ]);
                    ?>
                        <div class="col-md-<?php echo $bootstrapColWidth; ?>">
                            <div class="thumbnail">
                                <div class="small-box order-card">
                                    <div class="card">
                                        <img src="{{ asset('storage/' . $cardLayout) }}" class="card-img" alt="Card image">
                                        <div class="card-img-overlay">
                                            <div class="row">
                                                <!-- QR Code on the left -->
                                                <div class="col-md-6 p-0 d-flex align-items-center justify-content-center">
                                                    <img src="{{ (new QRCode($options))->render($row->voter_id) }}"
                                                        class="img-fluid w-100 h-100 object-fit-contain" alt="QR Code">
                                                </div>

                                                <!-- Voter's info on the right -->
                                                <div class="col-md-6 d-flex flex-column justify-content-center">
                                                    <div class="text-center pe-2">
                                                        <h5 class="mb-1 fw-bold">{{ $row->lname }}</h5>
                                                        <h5 class="mb-1 fw-bold">{{ $row->fname }}</h5>
                                                        <h6 class="mb-0">{{ $row->barangay_name }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php
                        $rowCount++;
                        if ($rowCount % $numOfCols == 0) echo '</div><div class="row mt-3">';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script type="text/javascript">
        window.onload = function() {
            self.print();
        }
    </script> -->
</body>

</html>