<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="index.php">Rhapsody</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse"
  data-target="#myNavBar" aria-controls="myNavBar" aria-expanded="false"
  aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="myNavBar">
    <ul class="navbar-nav mr-auto">
<?php

  $urls = [
    'Saturation mutagenesis' => 'sat_mutagen.php',
    'Batch query'   => 'batch_query.php',
    'Retrieve jobs' => 'retrieve_jobs.php',
    'Docs'      => 'https://rhapsody.readthedocs.io/en/latest/',
    'Tutorials' => 'https://nbviewer.jupyter.org/github/luponzo86/rhapsody-tutorials/tree/master/',
    'Download'  => 'download.php',
    'About'     => 'about.php',
  ];

  foreach ($urls as $name => $url) {
    // break between left and right tabs
    if ($name === 'Docs') {
      echo '</ul><ul class="navbar-nav navbar-right">' . "\r\n" ;
    }
    // single tab
    if ($currentPage === $name) {
      echo '<li class="nav-item active">' .
           '<a class="nav-link" href="' . $url . '">' . $name .
           '<span class="sr-only">(current)</span></a></li>' . "\r\n";
    }
    else {
      echo '<li class="nav-item">' .
           '<a class="nav-link" href="' . $url . '">' . $name .
           '</a></li>' . "\r\n";
    }
  }

?>
    </ul>
  </div>
</nav>

