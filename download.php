<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = 'Py_package';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>Download</h2>
    </div>
  </div>

  <div class="container">
    <div class="form-row">
      <div class="col-md"></div>

      <div class="col-md-6">
        <h5>local installation</h5>
        <p>
          <code>$ pip install prody-rhapsody</code>
          <small class="form-text text-muted">DSSP must be already
            installed on your computer, more info
            <a href="https://pypi.org/project/prody-rhapsody/"
              target="_blank">here</a>
          </small>
        </p>

        <h5>git repositories</h5>
        <p>
          <i class="fab fa-github"></i> &nbsp;
          <a href="https://github.com/prody/rhapsody" target="_blank">
            github.com/prody/rhapsody</a>
          <br>
          <i class="fab fa-github"></i> &nbsp;
          <a href="https://github.com/luponzo86/rhapsody-website"
            target="_blank">github.com/luponzo86/rhapsody-website</a>
          <br>
          <i class="fab fa-github"></i> &nbsp;
          <a href="https://github.com/luponzo86/rhapsody-tutorials"
            target="_blank">github.com/luponzo86/rhapsody-tutorials</a>
        </p>
      </div>
      <div class="col-md"></div>
    </div>
  </div>

<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
