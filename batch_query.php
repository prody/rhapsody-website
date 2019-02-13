<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

<?php
  $currentPage = 'Batch query';
  include './html/navbar.php';
?>

<div class="jumbotron">
  <div class="container text-center">
    <h2>Batch query</h2>
    Get predictions for a list of variants from mutliple sequences
  </div>
</div>

<div class="container">
<form class="needs-validation" novalidate action="submit_job.php" method="post"
      enctype="multipart/form-data">

<!-- row with radio buttons -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <label for="bq_radios">
      <h5>list of missense variants</h5>
    </label>

    <!-- radio button with text area -->
    <div class="form-check">
      <div class="form-group">
        <input class="form-check-input" type="radio" name="bq_radios"
        id="bq_text_radio" value="bq_text" checked>
        <textarea class="form-control" rows="3" name="bq_text"
        id="bq_text" maxlength="500"
        onfocus="document.getElementById('bq_text_radio').checked=true"
        placeholder="P01112 99 Q R
EGFR_HUMAN 300 V A
..."></textarea>
        <small id="bq_text" class="form-text text-muted">
          type <a href="query_Uniprot.php" target='_blank'>Uniprot coordinates</a>
          or leave blank to run test case
        </small>
      </div>
    </div>

    <!-- radio button with upload file -->
    <div class="form-check">
      <input class="form-check-input" type="radio" name="bq_radios"
      id="bq_file_radio" value="bq_file">
      <div class="form-group">
        <!-- "classic" upload button -->
        <input type="file" name="bq_file" id="bq_file" autocomplete="off"
        onfocus="document.getElementById('bq_file_radio').checked=true" >
        <small id="bq_text" class="form-text text-muted">
          upload the list in a text file</small>
      </div>
    </div>

  </div>

  <div class="col-md"></div>
</div>


<!-- row for email -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="email">
        <h5>email</h5>
      </label>
      <input type="email" class="form-control" name="email" id="email"
      aria-describedby="emailHelp" value="" placeholder="(optional)">
      <small id="emailHelp" class="form-text text-muted">you'll be notified
        when results are ready
      </small>
      <div class="invalid-feedback">
        Invalid email address
      </div>
    </div>
  </div>

  <div class="col-md"></div>
</div>



<!-- row for submit button -->
<div class="form-row py-2">
  <div class="col-md text-center">
    <div class="form-group">
      <button class="btn btn-primary" type="submit">Submit job</button>
    </div>
  </div>
</div>


</form>
</div>

<?php readfile("./html/footer.html"); ?>
<?php readfile("./html/js_src.html"); ?>

</body>

</html>