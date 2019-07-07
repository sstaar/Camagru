<?php
if (!isset($_SESSION['user'])) {
    header('Location: /login');
}
?>

<link rel="stylesheet" href="<?= C_CAM . '/' ?>camerastyle.css? <?php echo time(); ?>">

<div class="cam">
    <div class="main">
        <video id="vid" playsinline autoplay></video>
        <img hidden id="blah" src="#" alt="your image" width="500" height="500" />
        <canvas hidden id="canvas" width="500" height="500"></canvas>
        <div class="fills">
            <img hidden id="filter" alt="" width="200" height="200">

            <div class="fill" id="fill10">
                <img  id="filter" src="<?= C_GAL . '/Filters/10.png' ?>" alt="" width="200" height="200">
                <button class="butt" onclick="changeImg(10)"></button>
            </div>

            <div class="fill" id="fill21">
                <img  id="filter" src="<?= C_GAL . '/Filters/21.png' ?>" alt="" width="200" height="200">
                <button class="butt" onclick="changeImg(21)"></button>
            </div>

            <div class="fill" id="fill30">
                <img  id="filter" src="<?= C_GAL . '/Filters/30.png' ?>" alt="" width="200" height="200">
                <button class="butt" onclick="changeImg(30)"></button>
            </div>

        </div>
        <input hidden id="data" type="text" name="data">
        <input type="file" accept="image/x-png" name="" id="" onchange="handleOuterImage(this)">
        <button class="buttCap" id="capture" onclick="capture()" type="submit" name="submitImg">Submit</button>
    </div>

    <div class="side">
        <?php require_once(S_CAM . '/side.php') ?>
    </div>
</div>

<script src="<?= C_CAM . '/camera.js?' . time() ?>"></script>