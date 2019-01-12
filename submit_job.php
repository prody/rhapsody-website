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

function endsWith($haystack, $needle) {
  $length = strlen($needle);
  if ($length == 0) return true;
  return (substr($haystack, -$length) === $needle);
}

function save2file($fname, $value) {
  $file = fopen($fname, "w");
  fwrite($file, $value);
  fclose($file);
}


// // DEBUG: print all POST variables
// echo '<h2>Set variables:</h2>';
// print_r($_POST);
// echo '<h2>Uploaded files:</h2>';
// print_r($_FILES);


// determine submission type
$subm_type = '';
if ( isset($_POST["sm_query"]) ) {
  $subm_type = 'sat_mutagen';
}


// check for errors and print error messages, if any
$errors = [];

if ( $subm_type == 'sat_mutagen' ) {
  $previous_page = 'sat_mutagen.html';
  // check input data
  $query = str_replace(' ', '', $_POST["sm_query"]);
  if (!ctype_alnum($query))
    $errors[] = 'Query must contain letters, numbers and spaces only';
  if ( $_POST["sm_email"]!="" && !filter_var($_POST["sm_email"], FILTER_VALIDATE_EMAIL))
    $errors[] = 'Invalid email address';
  if ( isset($_POST["customPDB_checkbox"]) ) {
    $radio_value = $_POST["customPDB_radios"];
    if ( $radio_value == "PDBID" ) {
      $PDBID = str_replace(' ', '', $_POST["customPDBID"]);
      if ( ! ctype_alnum($PDBID) || strlen($PDBID)!=4 )
        $errors[] = 'PDB code must be a 4-letter alphanumeric code';
    }
    else if ( $radio_value == "PDBfile" ) {
      # check for correct file extensions
      $fname = $_FILES["customPDBFile"]["name"];
      if ( ! (endsWith($fname, ".pdb") || endsWith($fname, ".pdb.gz")) )
        $errors[] = 'Only files with extensions ".pdb" or ".pdb.gz" are accepted';
      if ( $_FILES["customPDBFile"]["size"] > 2000000 )
        $errors[] = 'PDB file is too large (>2MB)';
    }
    else {
      $errors[] = 'Internal error: Invalid custom PDB selection';
    }
  }
}
else {
  $errors[] = 'Internal error: Invalid submission type';
  $previous_page = 'index.html';
}

if (!empty($errors)) {
  echo '<h2>Error:</h2>';
  foreach($errors as $err) {
    echo '<p>'.$err.'</p>';
  }
  echo '<br><p><a href="'.$previous_page.'">Back</a></p>';
  die("</pre></body></html>");
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


// DEBUG: save info
$output = print_r($_POST, true);
file_put_contents('input.log', $output);
$output = print_r($_FILES, true);
file_put_contents('input.log', $output, FILE_APPEND);


// import data
$errors = [];
if ( $subm_type == 'sat_mutagen' ) {
  // write data to file
  save2file("input-sm_query.txt", $_POST["sm_query"]);
  if ( $_POST["sm_email"] != "" ) {
    save2file("input-email.txt", $_POST["sm_email"]);
  }
  if ( isset($_POST["customPDB_checkbox"]) ) {
    $radio_value = $_POST["customPDB_radios"];
    if ( $radio_value == "PDBID") {
      save2file("input-PDBID.txt", $_POST["customPDBID"]);
    }
    else {
      $orig_fname = $_FILES["customPDBFile"]["name"];
      if ( endsWith($orig_fname, ".pdb") )
        $uploaded_file = "input-PDB.pdb";
      else
        $uploaded_file = "input-PDB.pdb.gz";
      if ( ! move_uploaded_file($_FILES["customPDBFile"]["tmp_name"], $uploaded_file) )
        die("Sorry, there was an error uploading your file.</pre></body></html>");
    }
  }
  // select Python script
  $pyscript = $orig_dir . '/src/python/run_sat_mutagen.py';
}
else {
  // batch query
  $pyscript = $orig_dir . '/src/python/XXX.py';
}


// run rhapsody
// NB: command output must be redirected and run in background,
//     otherwise it will prevent to show the page.
//     Also, you should redirect stderr ("2>&1") *after* stdout
exec(
  'nohup python ' . $pyscript . ' > rhapsody-log.txt 2>&1 &' .
  'echo -n $! > PID.tmp'
);


chdir($orig_dir);


// clean workspace from old jobs
exec('nohup ./src/bin/clean_workspace.sh 2>&1 >> '.$scratch_dir.'/old_jobs.log &');


// go to the progress page
$ppage = "monitor_job.php?id=" . $jobid . "&st=" . $subm_type;
echo '<script type="text/javascript"> window.location.href = "'.$ppage.'"</script>';

?>

</pre>
</body>
</html>
