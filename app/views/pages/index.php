<?php require APPROOT.'/views/inc/header.php'; ?>
    <div class="container">
        <h1 class="display-3 text-center"><?php echo $data['title']; ?></h1>
        <?php SessionHelper::flash('login_success'); ?>
    </div>
<?php require APPROOT.'/views/inc/footer.php'; ?>