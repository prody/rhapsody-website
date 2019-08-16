<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = 'retrieve_jobs';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>Your jobs</h2>
    </div>
  </div>

  <div class="container">
    <div class="form-row">
      <?php
        include 'src/php/utils.php';
        $scratch_dir = "./workspace";
        echo print_jobs_table($scratch_dir);
      ?>
    </div>
  </div>

<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>
