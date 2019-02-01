<?php

include 'src/php/utils.php';

$scratch_dir = "./workspace";

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

# redirect to status page
$arr = ["jobid"  => $jobid,
        "jobdir" => $jobdir];

echo fill_template("status.html", $arr);

?>