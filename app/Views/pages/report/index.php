<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="title h3 text-grey-900">Generate Report</h1>
  <div class="card-body py-3">
    <!-- begin::Table container -->
    <div class="table-responsive">
      <!-- begin::Table -->
      <table class="table table-bordered table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="tabledtbuku">
        <!-- begin::Table head -->
        <thead style="background-color: #A9AF7E; color: black">
          <tr class="fw-bold">
            <th>No</th>
            <th>Username</th>
            <th>Loan Date</th>
            <th>Due Date</th>
            <th>Title</th>
            <th>Total Payment</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($data as $d) : ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= $d['user_name'] ?></td>
              <td><?= date_format(date_create($d['loan_date']), 'd/m/Y') ?></td>
              <td><?= date_format(date_create($d['due_date']), 'd/m/Y') ?></td>
              <td><?= $d['title'] ?></td>
              <td><?= 'Rp ' . number_format($d['total_fine'], 0, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <a href="<?php echo base_url(); ?>/report/generate" class="btn p-4" style="position: absolute; bottom: 20px; right: 80px; display: flex; justify-content: center; align-items: center; width: 100px; height: 100px; border-radius: 50%; background-color: #A9AF7E; cursor: pointer">
    <i class="fa-solid fa-print text-white" style="font-size: 3rem;"></i>
  </a>
</div>
<?= $this->endSection() ?>