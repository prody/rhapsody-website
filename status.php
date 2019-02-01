<!DOCTYPE html>
<html lang="en">

<?php
$jobid = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
?>

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = '';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>Job #<?php echo $jobid;?></h2>
    </div>
  </div>


  <div class="container bg-3 py-6">
    <div class="row">
      <div class="col-md">
        <h4>
          Status: <b><span style="color:red;" id="status_update"></span></b>
        </h4>
        <p>
          <div id="statusdiv">
            Bookmark this page to check your job status later
          </div>
          <div id="resultsdiv" style="display:none">
            You will be automatically redirected to the
            <a href="results.php?id=<?php echo $jobid;?>">results</a>
            page in <span id="counter">4 seconds</span>...
          </div>
        </p>
        <p>
          <textarea class="form-control" id="log_update" cols="100" rows="10" readonly
                    style="font-family:monospace; font-size:12px; white-space:pre-wrap">
            ...
          </textarea>
        </p>
      </div>
    </div>
  </div>



  <?php readfile("./html/footer.html"); ?>
  <?php readfile("./html/js_src.html"); ?>


  <!-- JS code for printing log live -->
  <script type="text/javascript">
    var jobid      = "<?php echo $jobid;?>";
    var job_status = "-";
    var log_tail   = "";

    function check_status() {
      console.log("job status: " + job_status);

      $.get( "src/php/get_status.php?id=" + jobid , function(data, status){
        job_status = data.status;
        log_tail   = data.logTail;
      }, "json");

      $("#status_update").html(job_status);
      $("#log_update").html(log_tail);

      if (job_status == "-") {
        setTimeout(check_status, 100);
      }
      else if (job_status == "running...") {
        setTimeout(check_status, 1000);
      }
      else if (job_status == "completed") {
        $("#statusdiv").hide();
        $("#resultsdiv").show();
        countdown();
      }
    }

    function countdown() {
      var counter = document.getElementById('counter');
      var i = parseInt(counter.innerHTML.substring(0, 1)) - 1;
      if (i <= 0) {
        location.href = 'results.php?id=<?php echo $jobid;?>';
      }
      else {
        if (i>1) {counter.innerHTML = i + " seconds";}
        else     {counter.innerHTML = i + " second";}
        setTimeout(countdown, 1000);
      }
    }

    $(document).ready(function() {
      check_status();
    })
  </script>

</body>

</html>