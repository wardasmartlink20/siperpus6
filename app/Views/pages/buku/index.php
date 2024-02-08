<?= $this->extend('layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="title h3 text-grey-900">BOOK DATA</h1>

  <!--begin::Tables Widget 9-->
  <div class="mb-5 mb-xl-8">
    <!-- begin::Header -->
    <div class="card-header border-0 pt-5">
      <div class="card-toolbar" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-trigger="hover" title="Click to add a user">
        <a class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_invite_friends">
          <i class="ki-outline ki-plus fs-2 justify-content-right"></i>Add Book Data +</a>
      </div>
      <!--begin::Modal - Invite Friends-->
      <div class="modal fade" id="kt_modal_invite_friends" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-650px">
          <!--begin::Modal content-->
          <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
            <div class="text-left">
                    <h1 class="h5"><strong> Add Book Data</strong></h1>
            </div>
              <!--begin::Close-->
              <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                <i class="ki-outline ki-cross fs-1"></i>
              </div>
              <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body">
              <!--begin::Heading-->
              <div class="p-5">
                            <form class="user">
                            <div class="form-group">
                                            <label for="email" class="form-label">Title</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Writer</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Publisher</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Year Publisher</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Synopsis</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="form-label">Add Photo</label>
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp">
                                        </div>
    
                                <a href="login.html" class="btn btn-primary btn-block">
                                    Simpan
                                </a>
                            </form>
                        </div>
          </div>
          <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
      </div>
      <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Invite Friend-->
  </div>
  <!-- end::Header -->
  <!-- begin::Body -->
  <div class="card-body py-3">
    <!-- begin::Table container -->
    <div class="table-responsive">
      <!-- begin::Table -->
      <table class="table table-bordered table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="tabledtbuku">
        <!-- begin::Table head -->
        <thead>
          <tr class="fw-bold text-muted ">
            <th class="min-w-150px">Book</th>
            <th class="min-w-150px">Title</th>
            <th class="min-w-150px">Writer</th>
            <th class="min-w-150px">Publisher</th>
            <th class="min-w-150px">Year Publisher</th>
            <th class="min-w-150px">Synopsis</th>
            <th class="min-w-100px">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <img src="assets/img/herrypoter.jpeg" alt="book image">
            </td>
            <td>Harry Potter and the Sorcerer's Stone</td>
            <td>J.K Rowling</td>
            <td>Bloomsbury</td>
            <td>1997</td>
            <td>a man named Kai Deverra
                or familiarly known as Deverra yang
                trying to live out his feelings of regret
                because <br> his girlfriend left him and
                then met Karina
                Maladivas. That is still a note
                who is locked in solitude and
                his own loneliness.</td>
            <td style="display: flex; flex-direction: row; justify-content: center; gap: 16px; height: 100%; padding: 17px">
                <i class="fas fa-edit" title="Edit"></i>
                <button type="button" class="btn-modal" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
                <i class="fas fa-trash-alt" title="Delete"></i>
                </button>
            </td>
          </tr>

          <tr>
            <td> <img src="assets/img/buku1.png" alt="book image"></td>
            <td>hary</td>
            <td>blom</td>
            <td>sygyd</td>
            <td>1997</td>  
            <td>KKN in Penari Village tells the story
                mystical events beyond logic
                befell six students in the village
                remote area of East Java
                in 2009. Six students from
                a college carries out
                KKN in a remote village. They are,
                Nur (Tissa Biani), Widya
                (Adinda Thomas), Ayu (Aghniny Haque),
                Bima (Achmad Megantara), Anton
                (Calvin Jeremy), and Wahyu (Fajar Nugraha).</td>
            <td style="display: flex; flex-direction: row; justify-content: center; gap: 16px; height: 100%; padding: 17px">
              <i class="fas fa-edit" title="Edit"></i>
            <button type="button" class="btn-modal" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">
              <i class="fas fa-trash-alt" title="Delete"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- modal delete -->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <div class="modal-body">
        <div class="icon-modal" style="justify-content: center">
          <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div class="text-body-modal">
        Are you sure want to leave me?
      </div>
      <div class="modal-footer" style="justify-content: center; gap: 16px">
        <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Yes</button>
        <button class="btn btn-secondary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">No</button>
      </div>
    </div>
  </div>
</div>
    </div>
  </div>
</div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>