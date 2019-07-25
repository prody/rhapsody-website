<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = 'Download';
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
        <pre class='py-2'><code>$ pip install prody-rhapsody</code></pre>

        <h5>git repositories</h5>
        <div class='py-2'>
          <p><i class="fab fa-github"></i> &nbsp;
            <a href="https://github.com/prody/rhapsody">
            github.com/prody/rhapsody</a>
          </p>
          <p><i class="fab fa-github"></i> &nbsp;
            <a href="https://github.com/luponzo86/rhapsody-website">
            github.com/luponzo86/rhapsody-website</a>
          </p>
          <p><i class="fab fa-github"></i> &nbsp;
            <a href="https://github.com/luponzo86/rhapsody-tutorials">
            github.com/luponzo86/rhapsody-tutorials</a>
          </p>
        </div>
      </div>
      <div class="col-md"></div>
    </div>
  </div>

<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
