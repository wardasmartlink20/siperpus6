<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>SIPERPUS</title>
  <meta name="description" content="The small framework with powerful features">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/png" href="/assets/img/sipeprus.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha384-GLhlTQ8iKu1iTRzNk0Zq44uKPSQ8gFQdYxy9N7u2mN7u2zU5CKTIbFgZYDnE+Ibb" crossorigin="anonymous">
  <link href="<?= base_url('assets/'); ?>endor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>css/sb-admin-2.css?<?= time() ?>" rel="stylesheet">
  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <?= $this->renderSection('content') ?>
        <!-- end::Tables Widget 9 -->

      </div>
    </div>
  </div>
</body>

<script>
  $(".success").fadeTo(2000, 500).slideUp(500, function() {
    $(".success").slideUp(500);
  });
</script>

</html>