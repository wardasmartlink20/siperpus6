<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="title h3 text-grey-900">PAYMENT</h1>
  <div class="card-body py-3">
    <!-- begin::Table container -->
    <div class="table-responsive">
      <!-- begin::Table -->
      <table class="table table-bordered table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="tabledtbuku">
        <!-- begin::Table head -->
        <thead>
          <tr class="fw-bold text-muted ">
            <th class="min-w-150px">No</th>
            <th class="min-w-150px">Username</th>
            <th class="min-w-150px">Loan Date</th>
            <th class="min-w-150px">Due Date</th>
            <th class="min-w-150px">Book Title</th>
            <th class="min-w-150px">Total Payment</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1.</td>
            <td>syafira</td>
            <td>25/03/2023</td>
            <td>28/03/2023</td>
            <td>KKN di Desa Penari</td>
            <td>Rp.5000,00</td>
          </tr>
          <tr>
            <td>2.</td>
            <td>syafira</td>
            <td>25/03/2023</td>
            <td>28/03/2023</td>
            <td>KKN di Desa Penari</td>
            <td>Rp.5000,00</td>
          </tr>
          
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>