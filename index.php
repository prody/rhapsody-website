<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = '';
    include './html/navbar.php';
  ?>


  <div class="jumbotron">
    <div class="container text-center">
      <h1>Rhapsody</h1>
      Pathogenicity prediction of human missense variants based on sequence,
      structure and dynamics of proteins
    </div>
  </div>


  <div class="container-fluid md-3 text-center">
    <div class="row">
      <div class="col-md py-4">
        <h5><i>In silico</i> saturation mutagenesis </h5>
        <div class="py-2">
          <a href="sat_mutagen.php">
            <img src="./img/thumbnail-sm.png"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
        <a href="./results.php?id=example-sm">see example</a>
      </div>
      <div class="col-md py-4">
        <h5>Batch query of mixed variants </h5>
        <div class="py-2">
          <a href="batch_query.php">
            <img src="./img/thumbnail-bq.png"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
        <a href="./results.php?id=example-bq">see example</a>
      </div>
      <div class="col-md py-4">
        <h5>Variants on custom PDB structure </h5>
        <div class="py-2">
          <a href="sat_mutagen.php">
            <img src="./img/thumbnail-customPDB.jpg"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
        <a href="#">see example</a>
      </div>
    </div>
  </div>


<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
