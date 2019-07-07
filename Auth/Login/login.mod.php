<?php

$errors = [];

if (isset($_POST['submitLog'])) {
    $acc = Auth::connect($_POST['uname'], $_POST['pass']);
    if ($acc == false)
        $errors[] = "UserName or PassWord is incorect.";
    else {
        if ($acc['activated'] == 0)
            $errors[] = "Your account is not active yet";
        else {
            $_SESSION['user'] = $acc;
            $dirname = S_GAL . '/Users/' . $acc['id'];
            if (!file_exists($dirname))
                mkdir($dirname);
        }
    }
}

?>

<?php if (count($errors) != 0) : ?>
    <div class="errors">
        <?php foreach ($errors as $error) : ?>
            <p><?= $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>