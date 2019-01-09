<!DOCTYPE html>

<style>
/* Set height of body and the document to 100% */
body, html {
    height: 100%;
    margin: 0;
    font-family: Arial;
}

.titlebar{
    background-color:white;
    color:blue;
    padding: 0px 0px;
}
</style>


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
?>

<html>
<head>

<title> RAPSODY-results </title>
<meta charset="utf-8">


<?php 
if (!$invalid_job) {
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<!--
  <script type="text/javascript" src="JSmol.min.js"></script>
  <script src="http://code.highcharts.com/highcharts.js"></script>
  <script src="http://code.highcharts.com/modules/data.js"></script>
  <script src="http://code.highcharts.com/modules/exporting.js"></script>
  <script src="http://code.highcharts.com/highcharts-more.js"></script>
-->

<script type="text/javascript">

<?php
 echo "var jobid=\"".$jobid."\";" ; 
 echo "var jobdir=\"".$jobdir."\";" ; 
?>

var job_status = "";
var main_log = "";
var main_err = "";

// job steps
var JST_ANALYSIS = 2
var JST_COMPLETED = 100;
var JST_ABORTED = -1;


function check_status(){
    
    $.get( "get_status.php?id="+ jobid , function(data,status){
        job_status = data;
    });

    var job_step=0;
    if (job_status == "running\n") job_step = JST_ANALYSIS;
    if (job_status == "completed\n") job_step = JST_COMPLETED;
    if (job_status == "aborted\n") job_step = JST_ABORTED;
    if (job_status == "invalid job id") job_step = JST_ABORTED;
    if (job_status == "internal error") job_step = JST_ABORTED;
    if (job_status == "not started") job_step = JST_ABORTED;

    $("#statusp").html(job_status);

//    $.get( jobdir + "/main.log", function(data,status){
//        main_log = data;
//    })
//    .fail(function(){
//        main_log = "could not retrieve log.";
//    });
//    $.get( jobdir + "/main.err", function(data,status){
//        main_err = data;
//    })
//    .fail(function(){
//        main_err = "could not retrieve error log.";
//    });        
//    
//    
//    if(main_log.length == 0) main_log = "-- empty log --";
//    if(main_err.length == 0) main_err = "-- empty log --";
//
//    $("#logdiv").html( main_log );
//    $("#logdiv").scrollTop( $("#logdiv")[0].scrollHeight );
//
//    $("#errdiv").html( main_err );
//    $("#errdiv").scrollTop( $("#errdiv")[0].scrollHeight );

    if (job_step != JST_COMPLETED && job_step != JST_ABORTED){
        setTimeout(check_status,1000);
    }

    // when completed, sets up the visualization using jsmol
    if (job_step == JST_COMPLETED) {
        $("#resultsdiv").show();
    };

}

$(document).ready(function() {
    $('.masterTooltip').hover(function(){
        // Hover over code
        var title = $(this).attr('title');
        $(this).data('tipText', title).removeAttr('title');
        $('<p class="tooltip"></p>')
        .text(title)
        .appendTo('body')
        .fadeIn('fast');
        }, function() {
        // Hover out code
        $(this).attr('title', $(this).data('tipText'));
        $('.tooltip').remove();
        }).mousemove(function(e) {
        var mousex = e.pageX + 20; //Get X coordinates
        var mousey = e.pageY + 10; //Get Y coordinates
        $('.tooltip')
        .css({ top: mousey, left: mousex })
    });


    var job_status = "";
    check_status();
})


function toggle_log(){
    var e = document.getElementById("logdiv");
    var a = document.getElementById("logswitch");

    if (e.style.display == 'block'){
        e.style.display = 'none';
        a.innerText= "+ Show log";
	a.textContent = "+ Show log";
    }else{
        e.style.display = 'block';
        a.innerText = "- Hide log";
	a.textContent = "- Hide log";
    }
}

function toggle_err(){
    var e = document.getElementById("errdiv");
    var a = document.getElementById("errswitch");
    if (e.style.display == 'block'){
        e.style.display = 'none';
        a.innerText = "+ Show error log";
	a.textContent = "+ Show error log";
    }else{
        e.style.display = 'block';
        a.innerText = "- Hide error log";
	a.textContent = "- Hide error log";
    }
}

</script>

<?php
  } // invalid job
?> 




</head>
<body>

<div class="titlebar">
     <h1> RAPSODY </h1>
     <a href="index.html">Back to home page</a> 
</div>

<br><br>

<div id="wrapper">
<div id="content_box">

<h2> Job info: </h2>

<?php if ($invalid_job) {
    echo "Not a valid job id. Your job might be expired and its contents might have been deleted.";
    die();
}
?>

<p> Job ID: <b>
<?php
 echo $jobid;
?>
</b></p>

Save the following  
<?php
    echo " <a href=\"results_page.php?id=".$jobid."\">link</a> ";
?>
to access the Results page later. <br>
Note: Results for this job will be available for 48 hours (until 
<?php 
    $fhandle = fopen("date.txt", "r");
    $enddate = fgets($fhandle);
    $enddate = trim($enddate);
    fclose($fhandle);
    echo $enddate;
?>). <br>
<?php
  $fhandle = fopen("email.txt", "r");
  $email = fgets($fhandle);
  $email = preg_replace('/\s+/', '', $email);
  fclose($fhandle);
  if ($email != "") { 
    echo "<p> We will send an email at the address &quot;".$email."&quot; when results are ready to be downloaded. </p>";
  }
?>
</p>

<br>

<div id="progressdiv">
    <h2> Job progress: </h2>
    <p> Current job status: <b> <span style="color:red;" id="statusp">Waiting for data</span></b></p> 
</div>

<br>

<div id="resultsdiv" style="display:none">
    <h2> Job results: </h2>
    <p><?php echo '<a href="jobs_directory/'.$jobdir.'/predictions/Windows/predictions.txt">Click here</a>'; ?> to view predictions.</p>
    <p><?php echo '<a href="jobs_directory/'.$jobdir.'/'.$jobdir.'.zip">Click here</a>'; ?> to download all the results.</p>
</div>


<!--

<h2> Job logs: </h2>
<p><a id="logswitch" href="javascript:;" onclick="javascript:toggle_log()">- Show log</a></p>
<textarea id="logdiv" style="display:none;" cols="80" rows="20" readonly class="logtxa">
</textarea>
<p><a id="errswitch" href="javascript:;" onclick="javascript:toggle_err()">- Show error log</a></p>
<textarea id="errdiv" style="display:none;" cols="80" rows="20" readonly class="logtxa">
</textarea>

-->


</div>
</div>

</body>
</html>
