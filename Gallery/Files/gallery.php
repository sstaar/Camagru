<link rel="stylesheet" href="<?= C_GAL . '/Files/' ?>gallery.css? <?php echo time(); ?>">

<?php $_SESSION['token'] = $token = str_shuffle(time() . 'abcdefghijklmnopqrstuvwxyz') . time();?>

<div class="posts">
    <?php
    
    if (!isset($_GET['page']))
        $page = 0;
    else
        $page = $_GET['page'];
    if (!is_numeric($page))
        header('Location: /404');
    $posts = Post::getAllPosts($page);
    foreach ($posts as $post) :
    ?>

    <div class="post">
        <div class="userInfo">
            <p class="userName"><?php echo $post['user'] ?></p>
            <p class="postDate"><?php echo $post['date'] ?></p>
        </div>
        <?php foreach ($post['filenames'] as $filename) : ?>
            <img  class="image" src=" <?php echo C_GAL . '/Users/' . $filename['filename'] ?>">
        <?php endforeach; ?>
            <?php if (isset($_SESSION['user'])) : ?>
                <label class="like" for="like<?= $post['id'] ?>" id="likes<?= $post['id'] ?>"><?php echo Post::getPostLikes($post['id']) ?></label>
                <button hidden id="like<?= $post['id'] ?>" onclick="like(<?= $_SESSION['user']['id'] ?>, <?= $post['id'] ?>, '<?= $_SESSION['token'] ?>')" value="<?php if (Database::readRowQuery('SELECT COUNT(id) FROM likes WHERE post_id LIKE ? AND user_id LIKE ?', [ $post['id'], $_SESSION['user']['id'] ]) != 1) echo '0'; else echo '1'; ?>"><?php echo Post::getPostLikes($post['id']) ?></button>
            <?php endif; ?>
        
        <div id="post<?= $post['id'] ?>">
            <?php if (isset($_SESSION['user'])) : ?>
                <div class="makeComment">
                    <textarea type="text" id="comment<?php echo $post['id'] ?>"></textarea>
                    <button onclick="comment('<?= $_SESSION['user']['uname'] ?>', <?= $_SESSION['user']['id'] ?>, <?= $post['id'] ?>, <?= $post['user_id'] ?>, '<?= $_SESSION['token'] ?>')">COMMENT</button>
                </div>
            <?php endif; ?>
            <?php
            $comments = Post::getPostComments($post['id']);
            foreach ($comments as $comment) :
            ?>
            <div class="comment">
                <div class="info">
                    <p class="commenterName"><?php echo $comment['uname'] ?></p>
                    <p class="commenterDate"><?php echo $comment['date'] ?></p>
                </div>
                <div class="text">
                    <?php echo htmlspecialchars($comment['text']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require_once(S_GAL . '/Files/pagination.php') ?>

<div id="error"></div>

<script src="<?= C_GAL . '/Files/gallery.js?' . time() ?>" ></script>
