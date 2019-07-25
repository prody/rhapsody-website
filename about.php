<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>
  <?php
    $currentPage = 'About';
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
        <a href="https://www.pnas.org/content/115/16/4164">
          <i>Structural dynamics is a determinant of the functional
          significance of missense variants </i><br>
        </a>
        Luca Ponzoni, Ivet Bahar <br>
        <small>Proceedings of the National Academy of Sciences Apr 2018,
        115 (16) 4164-4169; DOI: 10.1073/pnas.1715896115 </small>
        </p>

        <h5>other:</h5>
        <p>
          Please consider also citing
          <a href="http://genetics.bwh.harvard.edu/pph2/">PolyPhen-2</a> and
          <a href="https://marks.hms.harvard.edu/evmutation/">EVmutation</a>,
          if using their results

      </div>
      <div class="col-md"></div>
    </div>
  </div>


<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
