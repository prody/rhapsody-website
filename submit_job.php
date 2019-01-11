<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title> submitting job... </title>
</head>

<body>


<!-- preformatted text -->
<pre>

<?php

// // print set variables
// echo '<h2>Set variables:</h2>';
// foreach ($_POST as $key => $value) {
//   echo '<p>'.$key.': "'.$value.'"</p>';
// }

// determine submission type
$subm_type = '';
if ( isset($_POST["sm_query"]) ) {
  $subm_type = 'sat_mutagen';
}


// check for errors and print error messages, if any
$errors = [];

if ( $subm_type == 'sat_mutagen' ) {
  $s = str_replace(' ', '', $_POST["sm_query"]);
  if (!ctype_alnum($s)) {
    $errors[] = 'Query must contain letters, numbers and spaces only';
  }
  if ( $_POST["sm_email"]!="" && !filter_var($_POST["sm_email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email address';
  }
  $subm_page = 'sat_mutagen.html';
}
else {
  $errors[] = 'Internal error: Invalid submission type';
  $subm_page = 'index.html';
}

if (!empty($errors)) {
  echo '<h2>Error:</h2>';
  foreach($errors as $err) {
    echo '<p>'.$err.'</p>';
  }
  echo '<br><p><a href="'.$subm_page.'">Back</a></p>';
  die();
}


// create a unique job ID and directory

$scratch_dir = "workspace";
$orig_dir    = getcwd();
$jobid  = "";
$jobdir = "";

while ($jobid=="" || file_exists($jobdir)) {
  $salt = time();
  $jobid = substr(md5($salt), 0, 10);
  $jobdir = $scratch_dir . "/job_" . $jobid;
}

mkdir($jobdir);
chdir($jobdir);


// save inputs
foreach ($_POST as $key => $value) {
  $fname = "input-" . $key . ".txt";
  $file = fopen($fname, "w");
  fwrite($file, $value);
  fclose($file);
}


// run rhapsody
// NB: command output must be redirected and run in background,
//     otherwise it will prevent to show the page.
//     Also, you should redirect stderr ("2>&1") *after* stdout
if ( $subm_type == 'sat_mutagen' ) {
  $pyscript = $orig_dir . '/scripts/run_sat_mutagen.py';
}
else {
  $pyscript = $orig_dir . '/scripts/XXX.py';
}
exec(
  'nohup python ' . $pyscript . ' > rhapsody-log.txt 2>&1 & ' .
  'echo -n $! > PID.tmp'
);


chdir($orig_dir);


// go to the progress page
$ppage = "monitor_job.php?id=" . $jobid;
echo "<script type=\"text/javascript\"> window.location.href = \"".$ppage."\"</script>";


// $input_type = "";
// if ( $_POST["input_type"] == "pp2_file"   ) $input_type = "pp2_file";
// if ( $_POST["input_type"] == "batch_file" ) $input_type = "batch_file";
// if ( $_POST["input_type"] == "single_SNP" ) $input_type = "single_SNP";
//
// if ($input_type == "") {
//   die("Error parsing data, input_type not valid.</pre></body></html>");
// }
//
//
// # create a unique job ID and mkdir
//
// $now = time();
// $salt = 133422;
// $str = $now;
//
// if ( isset( $_FILES["pp2_file"]["name"] ) ){
//   $str = $now;
// }
// elseif ( isset( $_FILES["batch_file"]["name"] ) ){
//   $str = basename($_FILES["batch_file"]["name"]);
// }
// elseif ( $_POST["input_type"] == "single_SNP" ) {
//   $str = $_POST["SNP_query"];
// }
//
// $jobid = md5( $str . $_POST["email"] . $salt. $now);
// $target_dir = "job_" . $jobid;
// mkdir($jobs_dir ."/". $target_dir);
//
//
// # process form inputs and prepare for job submission
//
// chdir($jobs_dir ."/". $target_dir);
//
// $uploaded_file = "";
//
// if ($input_type == "pp2_file") {
//   # Check file size
//   if ($_FILES["pp2_file"]["size"] > 25000000)
//     die("Error: file is too large (>25MB).</pre></body></html>");
//
//   # if everything is ok, try to upload file
//   $uploaded_file = "pph2-full.txt";
//   if ( !move_uploaded_file($_FILES["pp2_file"]["tmp_name"], $uploaded_file) )
//     die("Sorry, there was an error uploading your file.</pre></body></html>");
//
// }
// else if ($input_type == "batch_file") {
//   # Check file size
//   if ($_FILES["batch_file"]["size"] > 2000000)
//     die("Error: file is too large (>2MB).</pre></body></html>");
//
//   # if everything is ok, try to upload file
//   $uploaded_file = "SNPs_list.txt";
//   if ( !move_uploaded_file($_FILES["batch_file"]["tmp_name"], $uploaded_file) )
//     die("Sorry, there was an error uploading your file.</pre></body></html>");
// }
// else if ($input_type == "single_SNP") {
//   $uploaded_file = "SNPs_list.txt";
//
//   $SNP_query = preg_replace("/[^A-Za-z0-9_\- ]/", '', $_POST["SNP_query"]);
//   $handle = fopen($uploaded_file, "w");
//   fwrite($handle, $SNP_query ."\n");
//   fclose($handle);
// }
//
//
// # save email for the job
// $emailfile = fopen("email.txt", "w");
// fwrite($emailfile, $_POST["email"] ."\n");
// fclose($emailfile);
//
// # save time of execution
// $datefile = fopen("date.txt", "w");
// fwrite($datefile, date('d M Y H:i', $now) ."\n");
// fclose($datefile);
//
//
// #################
// # start the job #
// #################
//
// exec("echo running > status.tmp");
//
// $res_page = "results_page.php?id=" . $jobid;
//
// # NB: command output must be redirected and run in background,
// # otherwise it will prevent to show the results page
// $command = '../../run_job.sh ' . $uploaded_file . ' > run_job.err 2>&1 &';
// # $command = "nohup ../../nohup.sh 2>&1 > nohup_text.log &";
// exec($command);
//
//
// chdir("../../");
//
//
// # go to the results page
// echo "<p> Your job ID is: <b>".$jobid."</b></p>\n";
// echo "<p> If you are not automatically redirected to the results page click here: <a href=\"".$res_page."\">" . $res_page. "</a></p>";
//
// echo "<script type=\"text/javascript\">
//   window.location.href = \"".$res_page."\"
// </script>";

?>
</pre>

</body>
