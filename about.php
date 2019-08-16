<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>
  <?php
    $currentPage = 'about';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>About</h2>
    </div>
  </div>

  <div class="container">
    <div class="form-row">
      <div class="col-md"></div>

      <div class="col-md-6">
        <h5>please cite:</h5>
        <p>
        <a href="https://www.pnas.org/content/115/16/4164" target="_blank">
          <i>Structural dynamics is a determinant of the functional
          significance of missense variants </i><br>
        </a>
        Luca Ponzoni, Ivet Bahar <br>
        <small>PNAS Apr 2018, 115 (16) 4164-4169;
          DOI: 10.1073/pnas.1715896115 </small>
        </p>

        <p>
        <a href="https://www.biorxiv.org/content/10.1101/737429v1" target="_blank">
          [preprint] <i>Rhapsody: Pathogenicity prediction of human missense variants
            based on protein sequence, structure and dynamics</i><br>
        </a>
        Luca Ponzoni, Zoltan N. Oltvai, Ivet Bahar <br>
        <small>bioRxiv Aug 2019, 737429; DOI: 10.1101/737429 </small>
        </p>

        <h5>other:</h5>
        <p>
          Please consider also citing
          <a href="http://genetics.bwh.harvard.edu/pph2/" target="_blank">
            PolyPhen-2</a> and
          <a href="https://marks.hms.harvard.edu/evmutation/" target="_blank">
            EVmutation</a>,
          if using their results

      </div>
      <div class="col-md"></div>
    </div>
  </div>


<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
