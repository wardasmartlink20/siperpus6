<?= $this->extend('layouts/auth_layout') ?>
<?= $this->section('content') ?>
<section class="container__login">
    <div style="display: flex; flex-direction: column; align-items: center">
        <img src="assets/img/sipeprus.png" alt="logo siperpus" style="width: 250px">
        <form action="<?php echo base_url(); ?>/register/submit" method="post">
            <h1>Sign Up, here!</h1>
            <span>Input your data</span>
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
            <div class="form-input">
                <input name="user_name" type="text" placeholder="Username">
                <input name="email" type="email" placeholder="Email">
                <input name="password" type="password" placeholder="Password">
                <input name="address" type="text" placeholder="Address">
            </div>
            <button type="submit">Sign Up</button>
        </form>
    </div>
    <div class="cover-image">
        <img src="assets/img/objek_satu.png" alt="siperpus" width="400px" height="400px">
    </div>
</section>
<?= $this->endSection() ?>