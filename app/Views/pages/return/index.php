<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="title h3 text-grey-900">Return Data</h1>
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
            <th>Title</th>
            <th>Loan Date</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Confirmation</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          <?php foreach ($data as $d) : ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= $d['user_name'] ?></td>
              <td><?= $d['title'] ?></td>
              <td><?= date_format(date_create($d['loan_date']), 'd M Y') ?></td>
              <td><?= date_format(date_create($d['due_date']), 'd M Y') ?></td>
              <td>
                <?php if ($d['status'] === 'done') : ?>
                  <span class="badge bg-warning text-dark"><?= $d['status'] ?></span>
                <?php else : ?>
                  <span class="badge bg-primary text-white"><?= $d['status'] ?></span>
                <?php endif; ?>
              </td>
              <?php if ($d['status'] === 'borrowed') : ?>
                <td>
                  <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $d['borrow_id'] ?>">
                    Confirm
                  </button>
                </td>
              <?php else : ?>
                <td>-</td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?= $this->endSection() ?>