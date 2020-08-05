<?php require APPROOT.'/views/inc/header.php'; ?>
<div class="row">
    <div class="col-md-6 mx-auto">
        <?php SessionHelper::flash('register_success'); ?>
        <?php SessionHelper::flash('logout_success'); ?>
        <div class="card card-body bg-light mt-5">
            <h2><?php echo ucfirst($data['title']); ?></h2>
            <p>Please fill in your credentials to log in</p>
            <form action="<?php echo URLROOT; ?>/users/login" method="post">
                <div class="form-group">
                    <label for="username">Username: <sup>*</sup></label>
                    <input class="form-control form-control-lg <?php echo (!empty($data['username_err']))
                        ? 'is-invalid' : '' ?>" type="text" name="username" value="<?php echo $data['username']; ?>"
                           id="username">
                    <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input class="form-control form-control-lg <?php echo (!empty($data['password_err']))
                        ? 'is-invalid' : '' ?>" type="password" name="password" value="<?php echo $data['password']; ?>"
                           id="password">
                    <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input class="form-control btn-success btn-block" type="submit" value="Log in">
                    </div>
                    <div class="col">
                        <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-light btn-block">
                            No account? Register
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT.'/views/inc/footer.php'; ?>
