<?= $this->extend('layouts/auth_layout') ?>
<?= $this->section('content') ?>
<table>
    <tr>
        <th>
            <div class="container">
                <!-- Outer Row -->
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card o-hidden border-0 shadow-lg my-5">
                            <div class="card-body p-0">
                                <!-- Nested Row within Card Body -->
                                <div class="row">
                                    <div class="col-lg-">
                                        <div class="sd-heading">
                                        </div>
                                        <div class="p-5">
                                            <div class="text-left">
                                                <h1 class="h5 text-gray-900 mb-4">Isi <strong>Data </strong>anda dengan benar untuk membuat <strong>Akun </strong>anda</strong></strong></h1>
                                            </div>
                                            <form class="user">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">E-Mail</label>
                                                    <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Nama Lengkap</label>
                                                    <input type="password" class="form-control form-control-user">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Alamat</label>
                                                    <input type="password" class="form-control form-control-user">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Username</label>
                                                    <input type="password" class="form-control form-control-user">
                                                </div>
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Password</label>
                                                    <input type="password" class="form-control form-control-user">
                                                </div>
                                                <div class="form-group">
                                                    <div class="text-center">
                                                        <a class="small" href="registration">Belum punya akun?</a>
                                                    </div>
                                                    <a href="index.html" class="btn btn-primary btn-user btn-block">
                                                        Masuk
                                                    </a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </th>
        <th>
            <div class="row justify-content-right">
                <img src=<?php echo base_url("assets/img/logoPerpus.png") ?> alt="logo siperpus" class="img-siperpus"></iamge>
            </div>
        </th>
    </tr>
</table>
<?= $this->endSection() ?>