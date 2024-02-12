<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-flex justify-content-between mr-4">
    <h1 class="title h3 text-grey-900">Generate Report</h1>
    <input type="date" class="px-3" id="filter" style="border-radius: 10px;background-color: #A9AF7E">
  </div>
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
      <nav aria-label="Page navigation example" class="pl-2">
        <ul class="pagination" id="pagination">
          <!-- Pagination links will be added dynamically here -->
        </ul>
      </nav>
    </div>
  </div>

  <a href="<?php echo base_url(); ?>/report/generate" class="btn p-4" style="position: absolute; bottom: 20px; right: 80px; display: flex; justify-content: center; align-items: center; width: 100px; height: 100px; border-radius: 50%; background-color: #A9AF7E; cursor: pointer">
    <i class="fa-solid fa-print text-white" style="font-size: 3rem;"></i>
  </a>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script type="text/javascript">
  var filterInput = document.getElementById('filter');
  var currentURL = window.location.search;
  var urlParams = new URLSearchParams(currentURL);
  var dateParam = urlParams.get('date');
  var pageParam = urlParams.get('page');

  if (urlParams.has('date')) {
    filterInput.value = dateParam;
  }

  filterInput.addEventListener('change', function() {
    var selectedDate = filterInput.value;
    if (selectedDate) {
      window.location.replace(`<?php echo base_url(); ?>report?date=${selectedDate}&page=1`);
    } else {
      window.location.replace(`<?php echo base_url(); ?>report?page=1`);
    }
  });

  // PAGINATION
  function handlePagination(pageNumber) {
    window.location.replace(`<?php echo base_url(); ?>report?date=${dateParam || ""}&page=${pageNumber}`);
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