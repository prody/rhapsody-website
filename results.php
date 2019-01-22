<?php

include 'src/php/utils.php';

$scratch_dir = "./workspace";

$arr = check_jobid_and_jobdir($scratch_dir);
$jobid  = $arr["jobid"];
$jobdir = $arr["jobdir"];

# create results page

$html_images = "";
$img_template = '<div class="py-3"><a href="{{fname}}">' .
                '<img src="{{fname}}" class="img" ' .
                'style="max-height: 420px; max-width: 100%;" ' .
                'alt="click to view in new tab"></a></div>'."\n";
foreach ( glob("${jobdir}/rhapsody-figure*.png") as $fname ) {
  $html_images .= str_replace("{{fname}}", $fname, $img_template);
}

$arr += ["images" => $html_images];
$results_page = fill_template("results-sm.html", $arr);

echo $results_page

?>