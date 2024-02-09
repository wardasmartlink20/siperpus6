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
            <th style="width: 150px;">Username</th>
            <th style="width: 150px;">Loan Date</th>
            <th style="width: 150px;">Due Date</th>
            <th style="width: 150px;">Title</th>
            <th style="width: 150px;">Total Payment</th>
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
</div>