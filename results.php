<?php

include 'src/php/utils.php';

$scratch_dir = "./workspace";

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

if ( file_exists("${jobdir}/input-sm_query.txt") ) {
  $subm_type = 'sm';
  // get sequence Uniprot accession number
  $f = fopen("${jobdir}/rhapsody-Uniprot2PDB.txt", 'r');
  $first_line = fgets($f);
  fclose($f);
  $Uniprot_acc = explode(" ", trim($first_line))[0];
}
elseif ( file_exists("${jobdir}/input-batch_query.txt") )
  $subm_type = 'bq';

# create results page
if ( $subm_type == 'sm' ) {
  $html_snippet = "";
  $js_snippet   = "";
  $img_template = '<img src="{{fname}}" class="img" ' .
                  'style="max-height: 480px; max-width: 100%;" ' .
                  'alt="click to view in new tab" id="{{imgid}}" ' .
                  'usemap="#map_{{imgid}}">' . "\n";
  foreach ( glob("${jobdir}/rhapsody-figure*.png") as $fname ) {
    $basename = basename($fname, ".png");
    $imgid = str_replace('rhapsody-', '', $basename);
    // create html image
    $html_img = str_replace("{{fname}}", $fname, $img_template);
    $html_img = str_replace("{{imgid}}", $imgid, $html_img);
    // create image map too
    $html_map = file_get_contents("${jobdir}/${basename}.html");
    $html_map = str_replace('{{map_id}}', "map_${imgid}", $html_map);
    // $map_attrs = 'data-toggle="tooltip" data-trigger="hover" data-placement="top"';
    $map_attrs = '';
    $html_map = str_replace('{{map_attrs}}', $map_attrs, $html_map);
    $area_attrs = 'onmousemove="updateTooltip(event)" onmouseout="hideTooltip(event)"';
    $html_map = str_replace('{{area_attrs}}', $area_attrs, $html_map);
    // attach html lines
    $html_snippet .= $html_img;
    $html_snippet .= $html_map;
    // write javascript variables
    $js_vars = file_get_contents("${jobdir}/${basename}.js");
    $js_vars = str_replace('{{map_id}}', "map_${imgid}", $js_vars);
    $js_vars = str_replace('{{map_data}}', 'MAP_DATA', $js_vars);
    $js_snippet .= $js_vars;
  }
  $arr += ["Uniprot_acc"   => $Uniprot_acc,
           "images"        => $html_snippet,
           "lookup_tables" => $js_snippet];
}

$results_page = fill_template("results-${subm_type}.html", $arr);

echo $results_page

?>