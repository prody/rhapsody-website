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
        <p><h5>please cite</h5><?p>
        <p>
        <a href="https://www.pnas.org/content/115/16/4164">
          <i>Structural dynamics is a determinant of the functional
          significance of missense variants </i><br>
          Luca Ponzoni, Ivet Bahar <br>
          <small>Proceedings of the National Academy of Sciences Apr 2018,
            115 (16) 4164-4169; DOI: 10.1073/pnas.1715896115 </small>
        </a>
        </p>
      </div>
      <div class="col-md"></div>
    </div>
  </div>


<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
