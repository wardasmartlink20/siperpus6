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
            <th>Total Fine</th>
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
              <td><?= date_format(date_create($d['loan_date']), 'd/m/Y') ?></td>
              <td><?= date_format(date_create($d['due_date']), 'd/m/Y') ?></td>
              <td><?= 'Rp ' . number_format($d['total_fine'], 0, ',', '.') ?></td>
              <td>
                <?php if ($d['status'] === 'done') : ?>
                  <?php if ($d['updated_at'] > $d['due_date']) : ?>
                    <span class="badge bg-danger text-white"><?= $d['status'] ?></span>
                  <?php else : ?>
                    <span class="badge bg-success text-white"><?= $d['status'] ?></span>
                  <?php endif; ?>
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

    <nav aria-label="Page navigation example" class="pl-2">
      <ul class="pagination" id="pagination">
      </ul>
    </nav>
  </div>
</div>

<!-- modal confirm -->
<?php foreach ($data as $d) : ?>
  <div class="modal fade" id="confirmModal<?= $d['borrow_id'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body d-flex flex-column justify-content-center text-center">
          <div class="icon-modal">
            <i class="fa-solid fa-circle-exclamation"></i>
          </div>
          <div class="text-body-modal">
            Are you sure want to confirm this data?
          </div>
          <div class="modal-footer" style="justify-content: center; gap: 16px">
            <button class="btn btn-secondary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">No</button>
            <form class="d-inline" method="put" action="<?= base_url(); ?>/borrowing/update/<?= $d['borrow_id'] ?>/done/return">
              <button type="submit" class="btn btn-primary">Yes</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript">
  var currentURL = window.location.search;
  var urlParams = new URLSearchParams(currentURL);
  var pageParam = urlParams.get('page');

  // PAGINATION
  function handlePagination(pageNumber) {
    window.location.replace(`<?php echo base_url(); ?>return?page=${pageNumber}`);
  }

  var paginationContainer = document.getElementById('pagination');
  var totalPages = <?= $pager["totalPages"] ?>;
  for (var i = 1; i <= totalPages; i++) {
    var pageItem = document.createElement('li');
    pageItem.classList.add('page-item');
    pageItem.classList.add('primary');
    if (i === <?= $pager["currentPage"] ?>) {
      pageItem.classList.add('active');
    }

    var pageLink = document.createElement('a');
    pageLink.classList.add('page-link');
    pageLink.href = 'javascript:void(0);'
    pageLink.textContent = i;

    pageLink.addEventListener('click', function() {
      var pageNumber = parseInt(this.textContent);
      handlePagination(pageNumber);
    });

    pageItem.appendChild(pageLink);
    paginationContainer.appendChild(pageItem);
  }
</script>
<?= $this->endSection() ?>