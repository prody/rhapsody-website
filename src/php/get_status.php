<?php

$scratch_dir = "../../workspace";
$pidFile     = "PID.tmp";
$doneFile    = "rhapsody-results.zip";

function isProcessRunning($f) {
  if ( !file_exists($f) ) {
    return False;
  }
  $pid = file_get_contents($f);
  return posix_kill($pid, 0);
}

function tailShell($filepath, $lines = 10) {
  ob_start();
  passthru('tail -' . $lines . ' ' . escapeshellarg($filepath));
  return trim(ob_get_clean());
}

function returnStatus($status="") {
  $logFile  = 'rhapsody-log.txt';
  if ( file_exists($logFile) ) {
    $logTail = tailShell($logFile);
  }
  else {
    $logTail = "";
  }
  $arr = array('status' => $status, 'logTail' => $logTail);
  die( json_encode($arr) );
}


// // DEBUG:
// $arr = array('status' => "running...", 'logTail' => "something");
// die( json_encode($arr) );


if ( !isset($_GET["id"]) ) {
  returnStatus( 'job id not set' );
}

$jobid = $_GET["id"];

if ( preg_match('/[^a-z0-9]/', $jobid) ) {
  returnStatus( 'invalid job id' );
}

$jobdir = "${scratch_dir}/job_" . $jobid;

if ( !is_dir($jobdir) ) {
  returnStatus( 'results folder not found' );
}

chdir($jobdir);

if ( file_exists($doneFile) ) {
  exec('rm -f ' . $pidFile);
  returnStatus( 'completed' );
}
elseif ( isProcessRunning($pidFile) ) {
  returnStatus( 'running...' );
}
else {
  returnStatus( 'aborted' );
}

?>
