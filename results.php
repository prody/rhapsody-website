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
  $html_snippet = "";
  $img_template = '<div class="py-2">' .
                  '<img src="{{fname}}" class="img" ' .
                  'style="max-height: 480px; max-width: 100%;" ' .
                  'alt="click to view in new tab" id="{{imgid}}" ' .
                  'usemap="#map_{{imgid}}"></div>' . "\n";
  foreach ( glob("${jobdir}/rhapsody-figure*.png") as $fname ) {
    $basename = basename($fname, ".png");
    $imgid = str_replace('rhapsody-', '', $basename);
    // create html image
    $html_img = str_replace("{{fname}}", $fname, $img_template);
    $html_img = str_replace("{{imgid}}", $imgid, $html_img);
    // create image map too
    $html_map = file_get_contents("${jobdir}/${basename}.html");
    $html_map = str_replace('{{map_id}}', "map_${imgid}", $html_map);
    $area_js  = 'onmousemove="getPos(event)" onmouseout="stopTracking()"';
    $html_map = str_replace('{{area_attrs}}', $area_js, $html_map);
    $html_map = str_replace('{{map_data}}', 'MAP_DATA', $html_map);
    // attach html lines
    $html_snippet .= $html_img;
    $html_snippet .= $html_map;
  }
  $arr += ["images" => $html_snippet];
}

$results_page = fill_template("results-${subm_type}.html", $arr);

echo $results_page

?>