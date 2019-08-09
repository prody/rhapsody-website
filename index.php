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
      pathogenicity prediction of human missense variants based on sequence,
      structure and dynamics of proteins
    </div>
  </div>


  <div class="container-fluid md-3 text-center">
    <div class="row">
      <div class="col-md py-2">
        <h5><i>In silico</i> saturation mutagenesis </h5>
        <small class="form-text text-muted px-5">
          Perform a complete scanning of all possible 19 amino acid
          substitutions at every position on the sequence. See example:
          <a href="./results.php?id=example-sm">human RAS</a>.
        </small>
        <div class="p-3">
          <a href="sat_mutagen.php">
            <img src="./img/thumbnail-sm.png"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
      </div>

      <div class="col-md py-2">
        <h5>Variants on custom PDB structure </h5>
        <small class="form-text text-muted px-5">
          Perform saturation mutagenesis analysis on a specific conformer,
          homology model or homologous structure (in case human structure is
          not available).
        </small>
        <div class="p-3">
          <a href="sat_mutagen.php">
            <img src="./img/thumbnail-customPDB.png"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
      </div>

      <div class="col-md py-2">
        <h5>Batch query of mixed variants </h5>
        <small class="form-text text-muted px-5">
          Obtain predictions for a list of human missense variants from
          various protein sequences. See an example
          <a href="./results.php?id=example-bq">here</a>.
        </small>
        <div class="p-3">
          <a href="batch_query.php">
            <img src="./img/thumbnail-bq.png"
            class="img-responsive border rounded" style="width:80%" alt="">
          </a>
        </div>
      </div>
    </div>

  </div>


<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
