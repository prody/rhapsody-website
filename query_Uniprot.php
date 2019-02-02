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
      <h2>Uniprot search tool</h2>
    </div>
  </div>


  <div class="container">
    <form class="needs-validation" novalidate action="javascript:query_Uniprot()">

    <div class="form-row">
      <div class="col-md"></div>

      <div class="col-md-6 py-4">
        <div class="input-group">
          <div class="input-group-prepend">
            <button class="btn btn-primary" type="submit" id="btn">
            <i class="fas fa-search"></i></button>
          </div>
          <input type="text" class="form-control" name="Uquery" id="Uquery"
          placeholder="search Uniprot..." required>
        </div>
        <small class="form-text text-muted">find the correct
          unique entry identifier for your sequence by querying the Uniprot
          database
        </small>
        <div class="invalid-feedback">
          Invalid query
        </div>
      </div>

      <div class="col-md"></div>
    </div>
    </form>
  </div>


  <?php readfile("./html/footer.html"); ?>
  <?php readfile("./html/js_src.html"); ?>

  <script>
    function query_Uniprot() {
      var query = document.getElementById("Uquery").value;
      query = query.trim().split(' ').join('+');
      var url = 'https://www.uniprot.org/uniprot/?query=' + query
      + '&fil=organism%3A%22Homo+sapiens+(Human)+[9606]%22&sort=score#';
      window.location.href = url;
    }

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