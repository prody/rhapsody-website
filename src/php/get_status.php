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
  return posix_kill($pid, 0);
}

function tailShell($filepath, $lines = 13) {
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