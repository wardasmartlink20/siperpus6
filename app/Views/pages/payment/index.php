<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="title h3 text-grey-900">Payment</h1>
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
            <th>Date</th>
            <th>Proof of Payment</th>
            <th>Confirmed By</th>
          </tr>
        </thead>
        <tbody>
          <?php $startIndex = ($pager["currentPage"] - 1) * $pager["limit"] + 1; ?>
          <?php foreach ($data as $d) : ?>
            <tr>
              <td><?= $startIndex++ ?></td>
              <td><?= $d['user_name'] ?></td>
              <td><?= $d['title'] ?></td>
              <td><?= date_format(date_create($d['updated_at']), 'd/m/Y') ?></td>
              <td><?= 'Rp ' . number_format($d['total_fine'], 0, ',', '.') ?></td>
              <td><?= $d['confirm_by']?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <nav aria-label="Page navigation example" class="custom-navigation">
      <ul class="pagination" id="pagination">
      </ul>
    </nav>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript">
  var currentURL = window.location.search;
  var urlParams = new URLSearchParams(currentURL);
  var pageParam = urlParams.get('page');

  // PAGINATION
  function handlePagination(pageNumber) {
    window.location.replace(`<?php echo base_url(); ?>payment?page=${pageNumber}`);
  }

  var paginationContainer = document.getElementById('pagination');
  var totalPages = <?= $pager["totalPages"] ?>;
  if (totalPages >= 1) {
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
  }
</script>
<?= $this->endSection() ?>