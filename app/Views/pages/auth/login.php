<?= $this->extend('layouts/auth_layout') ?>
<?= $this->section('content') ?>
<section class="container__login">
    <div class="content">
        <img src="assets/img/sipeprus.png" alt="logo siperpus" class="img-siperpus">
        <form action="<?php echo base_url(); ?>/login/submit" method="post">
            <h1>Sign In, here!</h1>
            <span>input your email password to sign in</span>
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
                <input name="email" type="email" placeholder="Email">
                <input name="password" type="password" placeholder="Password">
            </div>
            <button type="submit">Sign In</button>
        </form>
    </div>
    <div class="cover-image">
        <img src="assets/img/objek_satu.png" alt="siperpus" width="400px" height="400px">
    </div>
</section>
<?= $this->endSection() ?>