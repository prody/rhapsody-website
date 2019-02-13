<!DOCTYPE html>
<html lang="en">

<head>
<?php readfile("./html/header.html"); ?>
</head>

<body>

  <?php
    $currentPage = 'Saturation mutagenesis';
    include './html/navbar.php';
  ?>

  <div class="jumbotron">
    <div class="container text-center">
      <h2><i>In silico</i> saturation mutagenesis</h2>
      Scanning of all possible amino acid substitutions in a protein sequence
    </div>
  </div>


<div class="container">
  <form class="needs-validation" novalidate action="submit_job.php"
  method="post" enctype="multipart/form-data">

<!-- row for query -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="sm_query">
        <h5>Uniprot sequence ID</h5>
      </label>
      <input type="text" class="form-control" name="sm_query" id="sm_query"
      placeholder="P01112" value="">
      <small id="jobIDHelp" class="form-text text-muted">type a Uniprot
        <a href="query_Uniprot.php" target='_blank'>unique accession number</a>
        or leave blank to run test case. <br>
        optional: add a specific position for single-site scanning, e.g. "P01112 100"
      </small>
      <div class="invalid-feedback">
        Invalid query
      </div>
    </div>
  </div>

  <div class="col-md"></div>
</div>

<!-- row with checkbox for opening collapsable row below -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <div class="form-group">
      <div class="custom-control custom-checkbox" data-toggle="collapse"
      data-target="#collapse1">
        <input type="checkbox" class="custom-control-input"
        name="customPDB_checkbox" id="customPDB_checkbox" autocomplete="off">
        <label class="custom-control-label" for="customPDB_checkbox">
          use custom PDB structure
        </label>
      </div>
    </div>
  </div>

  <div class="col-md"></div>
</div>

<!-- collapsable row with radio buttons for typing/uploading PDB -->
<div class="panel-collapse collapse" id="collapse1">
  <div class="form-row">
  <div class="col-md"></div>

    <div class="col-md-6">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="customPDB_radios"
        id="customPDBID_radio" value="PDBID" checked>
        <div class="form-group">
          <input class="form-control" type="text" name="customPDBID" value=""
          id="customPDBID" maxlength="4" placeholder="type a PDB code..."
          onfocus="document.getElementById('customPDBID_radio').checked=true">
          <!-- <small id="PDBIDHelp" class="form-text text-muted">PDB ID</small> -->
        </div>
      </div>
    </div>

    <div class="col-md"></div>
  </div>

  <div class="form-row">
    <div class="col-md"></div>

    <div class="col-md-6">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="customPDB_radios"
        id="customPDBfile_radio" value="PDBfile">
        <div class="form-group">
          <!-- "classic" upload button -->
          <input type="file" accept=".pdb,.pdb.gz" name="customPDBFile"
          id="customPDBFile" autocomplete="off"
          onfocus="document.getElementById('customPDBfile_radio').checked=true">
<!-- "custom" upload button -->
<!--
<div class="custom-file">
  <input type="file" class="custom-file-input" name="customPDBFile"
  id="customPDBFile" accept=".pdb,.pdb.gz"
  onfocus="document.getElementById('customPDBfile_radio').checked=true">
  <label class="custom-file-label text-truncate" for="customPDBFile">
  Upload PDB file</label>
</div>
-->
<!--
<script>
  // JS for updating label after uploading file, in case you are
  using "custom" upload button
  // NB: does not work...
  // see: https://stackoverflow.com/questions/48613992/bootstrap-4-file-input-doesnt-show-the-file-name
  $('#customPDBFile').on('change',function(){
    // get the filename
    var fileName = $(this).val();
    // replace the label
    $(this).next('.custom-file-label').html(fileName);
  })
</script>
-->
        </div>
      </div>
    </div>

    <div class="col-md"></div>
  </div>
</div>



<!-- email row -->
<div class="form-row">
  <div class="col-md"></div>

  <div class="col-md-6">
    <div class="form-group">
      <label for="email">
        <h5>email</h5>
      </label>
      <input type="email" class="form-control" name="email" id="email"
      aria-describedby="emailHelp"  value="" placeholder="(optional)">
      <small id="emailHelp" class="form-text text-muted">
        you'll be notified when results are ready
      </small>
      <div class="invalid-feedback">
        Invalid email address
      </div>
    </div>
  </div>

  <div class="col-md"></div>
</div>


<!-- submit button row -->
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

<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>

</body>

</html>
