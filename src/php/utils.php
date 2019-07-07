<?php

function redirect($page, $arr=[]) {
  if ( ! is_array($arr) )
    die('redirect(): not an array');
  elseif ( ! empty($arr) )
    $page .= "?" . http_build_query($arr);
  // redirect to page
  $host = $_SERVER['HTTP_HOST'];
  header("Location: http://$host/$page");
  die();
}


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
    $arr = ["err_msg" => $error, "back_link" => "index.php"];
    redirect("error.php", $arr);
  }

  return ["jobid" => $jobid, "jobdir" => $jobdir];
}

function send_email($email, $jobid) {
  $host = $_SERVER['HTTP_HOST'];
  $to = trim($email);
  $subject = "Rhapsody: job $jobid completed!";
  $message = "
<html>
<head>
<title>Rhapsody</title>
</head>
<body>
<p>Click <a href=\"http://$host/results.php?id=${jobid}\">here</a>
to access the results page.</p>
</body>
</html>
";
  $headers[] = 'MIME-Version: 1.0';
  $headers[] = 'Content-type: text/html;charset=UTF-8';
  $headers[] = 'From: Rhapsody Webserver <dcb@pitt.edu>';
  mail($to, $subject, $message, implode("\r\n", $headers));
}


function update_cookie($scratch_dir, $jobid="") {
  $cookie = "rhapsody_jobids";

  $jobid_list = [];
  if ( $jobid != "" )
    $jobid_list[] = $jobid;

  // read cookie
  if ( isset($_COOKIE[$cookie]) ) {
    $content = json_decode($_COOKIE[$cookie]);
    foreach ( $content as $entry ) {
      $arr = (array) $entry;
      if ( array_key_exists("job ID", $arr) ) {
        $jobid_list[] = $arr["job ID"];
      }
    }
  }

  // eliminate duplicates
  $jobid_list = array_unique($jobid_list);

  // check if jobids are still valid
  $content = [];
  foreach ( $jobid_list as $j ) {
    // check for valid jobid
    if ( preg_match('/[^a-z0-9\-]/', $j) )
      continue;
    if ( strpos($j, "example") === 0 )
      continue;
    // check if job folder exists
    $jobdir = "${scratch_dir}/job_${j}";
    if ( file_exists($jobdir) ){
      // collect info about job
      $stat = stat($jobdir);
      $timestamp = $stat['ctime'];
      $date = date("D F j Y g:i a", $timestamp);
      $file_sm = "${jobdir}/input-sm_query.txt";
      $file_bq = "${jobdir}/input-batch_query.txt";
      // store info in array
      $info = [
        "job ID"  => $j,
        "date"    => $date,
        "results" => "results.php?id=$j"
      ];
      if ( file_exists($file_sm) ) {
        $info += [
          "type"    => "sat. mutagenesis",
          "query"   => $file_sm,
        ];
      }
      else if ( file_exists($file_bq) ) {
        $info += [
          "type"    => "batch query",
          "query"   => $file_bq,
        ];
      }
      else {
        continue;
      }

      $content[] = $info;
    }
  }

  // set a cookie that will expire in 48 hours
  $exp_date = time() + 86400*2;
  setcookie($cookie, json_encode($content), $exp_date, "/");

  return $content;
}


function print_jobs_table($scratch_dir){
  $jobs = update_cookie($scratch_dir, "example-sm");

  if (count($jobs) == 0) {
    $html = '
    <div class="col-md"></div>
    <div class="col-md-6">
      <p><h5>no jobs found</h5></p>
        <small class="form-text text-muted">
        please make sure that cookies are enabled.
        </small>
      </div>
    <div class="col-sm"></div>
    </div>';
    return $html;
  }

  $html = '
  <div class="col-sm"></div>
  <div class="col-sm-8 py-2">
  <table class="table table-sm text-center">
  <thead>
    <tr>
      <th>job ID</th>
      <th>submission date</th>
      <th>type</th>
      <th>input query</th>
      <th>results page</th>
    </tr>
  </thead>';

  // rows
  $html .= "<tbody>";
  foreach ($jobs as $job) {
    $html .= "<tr>\n";
    $html .= "<td>". $job["job ID"]."</td>";
    $html .= "<td>". $job["date"]  ."</td>";
    $html .= "<td>". $job["type"]  ."</td>";
    $html .= '<td><a href="'. $job["query"]  .'" target="_blank">link</a></td>';
    $html .= '<td><a href="'. $job["results"].'" target="_blank">link</a></td>';
    $html .= "</tr>\n";
  }
  $html .= '</tbody>
  </table>
  </div>
  <div class="col-sm"></div>';

  return $html;
}


?>