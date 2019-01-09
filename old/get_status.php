<?php

chdir("jobs_directory");

$invalid_job = True;
$jobid="";
if (isset($_GET["id"])) {
    $jobid = $_GET["id"];
    $jobdir = "job_" . $jobid;
    if ( preg_match('/[a-z]+[0-9]+/', $jobid ) ) {
        if (is_dir($jobdir) ) {
            chdir($jobdir);
            $invalid_job = False;
        }
    }
}

if ($invalid_job) {
    die( 'invalid job id' );
}


$status_str = "";
if (file_exists("status.tmp")) {
    $handle = fopen("status.tmp", "r");
    if($handle){
        $status_str = fgets($handle);
    }else{
        die( 'internal error' );
    }
    fclose($handle);
}else{
    die( 'not started' );
}

die( $status_str );

?>
