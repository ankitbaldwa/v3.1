<?php 
function tcpdf()
{
    require_once('tcpdf/config/tcpdf_config.php');
    require_once('tcpdf/tcpdf.php');
}
function mpdf(){
    // Require composer autoload
    require_once __DIR__ . '/../third_party/vendor/autoload.php';
}
?>