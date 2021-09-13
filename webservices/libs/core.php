<?php
date_default_timezone_set('Asia/kuwait');
$secretKey  = base64_encode(base64_encode("healty_box"));
$tokenId    = base64_encode(mt_rand());
$issuedAt   = time();
$notBefore  = $issuedAt  + 10;             //Adding 10 seconds
$expire     = $notBefore + (60*24);            // Adding 60 seconds
$serverName = "localHost";                // Retrieve the server name from config file


?>