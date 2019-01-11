<!DOCTYPE html>

<?php
// check job ID
$valid_jobid = False;
$jobid = "";
if (isset($_GET["id"])) {
  $jobid = $_GET["id"];
  if ( !preg_match('/[^a-z0-9]/', $jobid) ) {
    $valid_jobid = True;
  }
}
?>

<html>
<head>
<title> RHAPSODY results </title>
<meta charset="utf-8">

<?php
if ($valid_jobid) {
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">

  <?php
  echo "var jobid  = \"" . $jobid  ."\";" ;
  ?>

  var job_status = "running...";
  var log_tail   = "";

  function check_status() {
    $.get( "get_status.php?id=" + jobid , function(data, status){
      job_status = data.status;
      log_tail   = data.logTail;
    }, "json");

    $("#status_update").html(job_status);
    $("#log_update").html(log_tail);

    if (job_status == "running...") {
      setTimeout(check_status, 1000);
    }

    if (job_status == "completed") {
      $("#resultsdiv").show();
    }
  }

  $(document).ready(function() {
      check_status();
  })

</script>

<?php
  }
?>

</head>


<body>

<div class="titlebar">
  <h1> RHAPSODY </h1>
  <a href="index.html">Back to home page</a>
</div>

<br><br>

<div id="wrapper">
  <div id="content_box">

    <h2> Job info: </h2>
    <?php
      if (!$valid_jobid) {
        echo "Not a valid job id. Your job might be expired and its contents might have been deleted.";
        die();
      }
    ?>
    <p> Job ID: <b> <?php echo $jobid; ?> </b></p>
    <p> Save the following
    <?php
      echo " <a href=\"results_page.php?id=".$jobid."\">link</a> ";
    ?>
    to access the Results page later. </p>
    <p> Note: Results for this job will be only available for 48 hours.</p>
    <?php
      // $fhandle = fopen("email.txt", "r");
      // $email = fgets($fhandle);
      // $email = preg_replace('/\s+/', '', $email);
      // fclose($fhandle);
      // if ($email != "") {
      //   echo "<p> We will send an email at the address &quot;".$email."&quot; when results are ready to be downloaded. </p>";
      // }
    ?>

    <h2> Job progress: </h2>
    <p> Current job status: <b> <span style="color:red;" id="status_update">...</span></b></p>
    <textarea id="log_update" cols="100" rows="15" readonly class="logtxa">
      ...
    </textarea>

    <div id="resultsdiv" style="display:none">
      <h2> Job results: </h2>
      <p><?php echo '<a href="scratch/job_'.$jobid.'/rhapsody-aux_predictions.txt">View predictions</a>';?> </p>
      <!-- <p><?php echo '<a href="scratch/'.$jobid.'/XXX.zip">Click here</a>'; ?> to download all the results.</p> -->
    </div>

  </div>
</div>

</body>
</html>
