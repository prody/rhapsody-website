<?php

function fillTemplate($html, $arr, $exit=True) {
  $template = file_get_contents($html);

  foreach ($arr as $key => $value) {
    $placeholder = "{{" . $key . "}}";
    $template = str_replace($placeholder, $value, $template);
  }
  if ($exit)
    die($template);
  else
    return $template;
}

?>