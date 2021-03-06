<?php

$scratch_dir = "../../workspace";
$pidFile     = "PID.tmp";
$doneFile    = "rhapsody-results.zip";

include './utils.php';

function isProcessRunning($f) {
  if ( !file_exists($f) ) {
    return False;
  }
  $pid = file_get_contents($f);
  return posix_kill((int)$pid, 0);
}

function tailShell($filepath, $lines = 10) {
  ob_start();
  passthru('tail -' . $lines . ' ' . escapeshellarg($filepath));
  return trim(ob_get_clean());
}

function returnStatus($status="") {
  $logFile = 'rhapsody-log.txt';
  $statusFile = 'rhapsody-status.txt';
  if ( file_exists($logFile) ) {
    $logTail = tailShell($logFile, 5);
    if ( file_exists($statusFile) ) {
      $logTail .= "\r\n\r\n" . tailShell($statusFile, 1);
    }
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

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

chdir($jobdir);

if ( isProcessRunning($pidFile) ) {
  returnStatus( 'running...' );
}
else {
  exec("rm -f $pidFile");
  if ( file_exists($doneFile) ) {
    returnStatus( 'completed' );
  }
  else {
    returnStatus( 'aborted' );
  }
}

?>