<?php

include 'src/php/utils.php';

$scratch_dir = "./workspace";

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

if ( file_exists("${jobdir}/input-sm_query.txt") )
  $back_link = "sat_mutagen.html";
else
  $back_link = "index.html";

# redirect to status page
$arr = [
  "jobid"     => $jobid,
  "back_link" => $back_link,
  "jobdir"    => $jobdir];

echo fill_template("status.html", $arr);

?>