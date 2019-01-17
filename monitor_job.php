<?php

include 'src/php/utils.php';

$scratch_dir = "./workspace";



// check job ID and folder
$back_link = "index.html";
$error = "";

if (! isset($_GET["id"]))
  $error = "missing job ID";

$jobid = $_GET["id"];
if ( preg_match('/[^a-z0-9]/', $jobid) )
  $error = "invalid job ID";

$jobdir = "{$scratch_dir}/job_${jobid}";
if (! file_exists($jobdir) )
  $error = "job folder not found (is it expired, maybe?)";



if (! empty($error) ) {
  // exit to error page
  $arr = ["err_msg" => $error, "back_link" => $back_link];
  fillTemplate("error.html", $arr);
}
else {
  # redirect to status page
  if ( file_exists("${jobdir}/input-sm_query.txt") )
    $back_link = "sat_mutagen.html";

  $arr = [
    "jobid"     => $jobid,
    "back_link" => $back_link,
    "jobdir"    => $jobdir];

  fillTemplate("status.html", $arr);
}

?>