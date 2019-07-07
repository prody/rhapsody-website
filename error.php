<!DOCTYPE html>
<html lang="en">

<?php
$err_msg = filter_input(INPUT_GET, 'err_msg', FILTER_SANITIZE_STRING);
$back_link = filter_input(INPUT_GET, 'back_link', FILTER_SANITIZE_STRING);
?>

<head>
<?php readfile("./html/header.html"); ?>

<style>
.jumbotron {
  background-image: url("./img/sm_colormap-blur.png");
}
</style>

</head>

<body>

  <?php
    $currentPage = '';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2>...something went wrong :(</h2>
    </div>
  </div>


  <div class="container border rounded bg-3">
    <h5>error log:</h5>
    <p>
      <pre>
        <?php echo $err_msg;?>
      </pre>
    </p>
    <p><a href="<?php echo $back_link;?>">Back</a></p>
  </div>


  <?php readfile("./html/footer.html"); ?>
  <?php readfile("./html/js_src.html"); ?>

</body>

</html>
