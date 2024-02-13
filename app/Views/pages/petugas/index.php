<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="title h3 text-grey-900">Petugas</h1>

  <!--begin::Tables Widget 9-->
  <div class="mb-5 mb-xl-8">
    <!-- begin::Header -->
    <div class="card-header border-0 pt-5">
      <div class="card-toolbar mb-4" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
        <a class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#createModal">
          <i class="ki-outline ki-plus fs-2 justify-content-right"></i>Add Petugas +</a>
      </div>
      <?php if (session()->getFlashData('failed')) : ?>
        <div class="alert alert-danger" role="alert">
          <?php echo session("failed") ?>
        </div>
      <?php endif; ?>

      <?php if (session()->getFlashData('success')) : ?>
        <div class="alert success alert-success" role="alert">
          <?php echo session("success") ?>
        </div>
      <?php endif; ?>
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
              <th>Email</th>
              <th>Address</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach ($data as $d) : ?>
              <tr>
                <td><?= $i++ ?></td>
                <td><?= $d["user_name"] ?></td>
                <td><?= $d["email"] ?></td>
                <td><?= $d["address"] ?></td>
                <td>
                  <div>
                    <i class="fas fa-edit" title="Edit" data-bs-toggle="modal" data-bs-target="#editModal<?= $d['user_id'] ?>"></i>
                    <i class="fas fa-trash-alt" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $d['user_id'] ?>"></i>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <nav aria-label="Page navigation example" class="custom-pagination">
        <ul class="pagination" id="pagination">
        </ul>
      </nav>
    </div>

    <!-- modal create -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog mw-650px">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="h5"><strong> Add Petugas</strong></h1>
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
              <i class="ki-outline ki-cross fs-1"></i>
            </div>
          </div>
          <div class="modal-body">
            <div class="px-4">
              <form action="<?php echo base_url(); ?>/register/submit?redirectTo=petugas" method="post">
                <div class="form-group">
                  <label for="user_name" class="form-label">Username</label>
                  <input required name="user_name" type="text" class="form-control form-control-user" id="user_name" aria-describedby="user_name">
                </div>
                <div class="form-group">
                  <label for="email" class="form-label">Email</label>
                  <input required name="email" type="email" class="form-control form-control-user" id="email" aria-describedby="email">
                </div>
                <div class="form-group">
                  <label for="password" class="form-label">Password</label>
                  <input required name="password" type="password" class="form-control form-control-user" id="password" aria-describedby="password">
                </div>
                <div class="form-group">
                  <label for="address" class="form-label">Address</label>
                  <input required name="address" type="text" class="form-control form-control-user" id="address" aria-describedby="address">
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                  Simpan
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- modal edit -->
    <?php foreach ($data as $d) : ?>
      <div class="modal fade" id="editModal<?= $d['user_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog mw-650px">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="h5"><strong>Edit Petugas</strong></h1>
              <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                <i class="ki-outline ki-cross fs-1"></i>
              </div>
            </div>
            <div class="modal-body">
              <div class="px-4">
                <form action="<?php echo base_url(); ?>petugas/update/<?= $d['user_id'] ?>?redirectTo=petugas" method="post">
                  <div class="form-group">
                    <label for="user_name" class="form-label">Username</label>
                    <input required name="user_name" type="text" class="form-control form-control-user" id="user_name" aria-describedby="user_name" value="<?= $d['user_name'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input required name="email" type="email" class="form-control form-control-user" id="email" aria-describedby="email" value="<?= $d['email'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input required name="password" type="password" class="form-control form-control-user" id="password" aria-describedby="password">
                  </div>
                  <div class="form-group">
                    <label for="address" class="form-label">Address</label>
                    <input required name="address" type="text" class="form-control form-control-user" id="address" aria-describedby="address" value="<?= $d['address'] ?>">
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">
                    Simpan
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- modal delete -->
    <?php foreach ($data as $d) : ?>
      <div class="modal fade" id="deleteModal<?= $d['user_id'] ?>" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body d-flex flex-column justify-content-center text-center">
              <div class="icon-modal">
                <i class="fa-solid fa-circle-exclamation"></i>
              </div>
              <div class="text-body-modal">
                Are you sure want to delete this data?
              </div>
              <div class="modal-footer" style="justify-content: center; gap: 16px">
                <form class="d-inline" method="post" action="<?= base_url(); ?>/petugas/delete/<?= $d['user_id'] ?>">
                  <button type="submit" class="btn btn-primary">Yes</button>
                </form>
                <button class="btn btn-secondary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">No</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
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
    window.location.replace(`<?php echo base_url(); ?>petugas?page=${pageNumber}`);
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