<?php
// ensures anything dumped out will be caught
ob_start();

include 'src/php/utils.php';

$scratch_dir = "./workspace";

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

# create results page
$results_page = fill_template("results.html", $arr);

$url = "${jobdir}/rhapsody-results.html";
$file = fopen($url, "w");
fwrite($file, $results_page);
fclose($file);

// clear out the output buffer
while (ob_get_status())
{
  ob_end_clean();
}

header( "Location: $url" );
?>