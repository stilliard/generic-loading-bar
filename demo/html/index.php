<?php

require_once __DIR__ . '/init.php';

if ($_POST['reset'] ?? false) {
    $loading->reset();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading Bar Demo</title>
</head>
<body>

    <h1>HTML demo with background process using Redis</h1>

    <?php if ($loading->isReset()) { ?>
        <p>Run <code>php background.php</code> to start the background process.</p>
    <?php } ?>

    <?php echo $loading->display(); ?>

    <?php if (! $loading->isComplete()) { ?>
        <meta http-equiv="refresh" content="1">
    <?php } else { ?>
        <form method="post">
            <input type="submit" name="reset" value="Reset">
        </form>
    <?php } ?>

</body>
</html>
