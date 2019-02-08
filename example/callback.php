<?php

define ('CTBASIC_INCLUDE', 1);
include 'settings.php';
include '../lib/CtBasicApi.php';
$ctApi = new CtBasicApi(CTBASIC_MERCHANTID, CTBASIC_APIKEY);
$res = $ctApi->validateHash();

if (!empty(CTBASIC_LOGFILE)) {
    $msg = "Callback: ".date("Y-m-d H:i:s")."\n";
    $msg =
    $msg .= print_r($_POST, true);
    if ($res) {
        $msg .= "Hash verified";
    }
    else {
        $msg .= "Hash not verified";
    }

    $msg .= "\n\n";

    error_log($msg, 3, CTBASIC_LOGFILE);
}