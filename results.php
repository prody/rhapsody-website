<?php

include 'src/php/utils.php';

$scratch_dir = "./workspace";

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

if ( file_exists("${jobdir}/input-sm_query.txt") )
  $subm_type = 'sm';
elseif ( file_exists("${jobdir}/input-batch_query.txt") )
  $subm_type = 'bq';

# create results page
if ( $subm_type == 'sm' ) {
  $html_images = "";
  $img_template = '<div class="py-3"><a href="{{fname}}">' .
                  '<img src="{{fname}}" class="img" ' .
                  'style="max-height: 420px; max-width: 100%;" ' .
                  'alt="click to view in new tab"></a></div>'."\n";
  foreach ( glob("${jobdir}/rhapsody-figure*.png") as $fname ) {
    $html_images .= str_replace("{{fname}}", $fname, $img_template);
  }
  $arr += ["images" => $html_images];
}

$results_page = fill_template("results-${subm_type}.html", $arr);

echo $results_page

?>