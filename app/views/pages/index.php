<?php require APPROOT.'/views/inc/header.php'; ?>

    <div class="container">
        <h1 class="display-3 text-center"><?php echo ucfirst($data['title']); ?></h1>

        <?php SessionHelper::flash('login_success'); ?>

        <div class="row justify-content-center">

        <?php if (!isset($_SESSION['user_id'])) : ?>

            <p class="col-12 text-center mt-3">Please login or register to start the game!</p>
            <div class="col-2 text-center mt-3">
                <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-success"">Log in</a>
            </div>
            <div class="col-2 text-center mt-3">
                <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-success"">Register</a>
            </div>

        <?php else: ?>

            <div class="col-12 text-center mt-3">
                <p>You will have 30 seconds to show your skills.</p>
                <p>Each correct awnser grants you additional 3 seconds.</p>
                <p>Press "Start game" to start the game.</p>
                <button class="btn btn-success mt-3">Start game</button>
            </div>
            <div class="col-6 position-relative text-center">
                <img class="h-25" src="<?php echo URLROOT; ?>/public/img/purzen_Clock_face_web.png" alt="clock" title="clock">
                <span class="clock-value"></span>
            </div>
            <div class="col-6 position-relative text-center">
                <img class="h-25" src="<?php echo URLROOT; ?>/public/img/vector-dartboard-1966525_960_720.png" alt="score" title="score">
                <span class="score-value"></span>
            </div>

        <?php endif; ?>

        </div>

    </div>

<?php require APPROOT.'/views/inc/footer.php'; ?>
