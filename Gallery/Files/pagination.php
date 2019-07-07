<?php

$max = ceil(Database::readRowQuery('SELECT COUNT(id) FROM posts') / POSTS_PAGE);

if ($page >= $max)
        header('Location: /404');

?>

<div class="pagination" >
    <a id="first" href="/gallery/">First</a>
    <?php if ($page - 1 >= 0) : ?>
    <a id="prev" href="/gallery/?page=<?= $page - 1 ?>">Previous</a>
    <?php endif; ?>
    <p id="curr">Current page <?= $page ?></p>
    <?php if($page + 1 < $max) : ?>
    <a id="next" href="/gallery/?page=<?= $page + 1 ?>">Next</a>
    <?php endif; ?>
    <a id="last" href="/gallery/?page=<?= $max - 1 ?>">Last</a>
</div>