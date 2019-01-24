<?php

function fill_template($html, $arr) {
  $template = file_get_contents($html);

  foreach ($arr as $key => $value) {
    $placeholder = "{{" . $key . "}}";
    $template = str_replace($placeholder, $value, $template);
  }

  return $template;
}


function check_jobid_and_jobdir($scratch_dir) {
  // check job ID
  $error = "";

  if (! isset($_GET["id"]))
    $error = "missing job ID";

  $jobid = $_GET["id"];
  if ( preg_match('/[^a-z0-9\-]/', $jobid) )
    $error = "invalid job ID";

  // check job folder
  $jobdir = "${scratch_dir}/job_${jobid}";
  if (! file_exists($jobdir) )
    $error = "job folder not found (is it expired, maybe?)";

  if (! empty($error) ) {
    // exit to error page
    $arr = ["err_msg" => $error, "back_link" => "index.html"];
    die(fill_template("error.html", $arr));
  }

  return ["jobid" => $jobid, "jobdir" => $jobdir];
}

function send_email($email, $jobid) {
  $to = trim($email);
  $subject = "Rhapsody: job $jobid completed!";
  $message = "
<html>
<head>
<title>Rhapsody</title>
</head>
<body>
<p>Click <a href=\"results.php?id=${jobid}\">here</a>
to access your job's results</p>
</body>
</html>
";
  $headers  = "MIME-Version: 1.0 \r\n";
  $headers .= "Content-type:text/html;charset=UTF-8 \r\n";
  $headers .= 'From: <rhapsody@csb.pitt.edu>' . "\r\n";

  mail($to,$subject,$message,$headers);
}

?>