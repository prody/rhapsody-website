<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = 'Tutorials';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>Tutorials</h2>
    </div>
  </div>

  <div class="container">
    <div class="form-row">
      <div class="col-md"></div>

      <div class="col-md-6">
      <p><h5>View tutorials</h5></p>
        <p><i class="fas fa-external-link-alt"></i> &nbsp;
          <a href="https://nbviewer.jupyter.org/github/luponzo86/rhapsody-tutorials/tree/master/">
          Jupyter NBViewer</a>
        </p>

        <p><h5>Download all tutorials</h5></p>
          <p><i class="fab fa-github"></i> &nbsp;
            <a href="https://github.com/luponzo86/rhapsody-tutorials">
            github.com/luponzo86/rhapsody-tutorials</a>
          </p>
      </div>
      <div class="col-md"></div>
    </div>
  </div>

<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
