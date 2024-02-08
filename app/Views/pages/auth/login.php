<?= $this->extend('layouts/auth_layout') ?>
<?= $this->section('content') ?>
<section class="container__login">
    <div class="content">
        <img src="assets/img/sipeprus.png" alt="logo siperpus" class="img-siperpus">
        <form>
            <h1>Sign In, here!</h1>
            <span>input your email password to sign in</span>
            <div class="form-input">
                <input type="username" placeholder="Username">
                <input type="password" placeholder="Password">
            </div>
            <button>Sign In</button>
        </form>
    </div>
    <div class="cover-image">
        <img src="assets/img/objek_satu.png" alt="logo siperpus">
    </div>
</section>
<?= $this->endSection() ?>