<?php
$posts = Post::getUserPosts($_SESSION['user']['id']);
foreach ($posts as $post) :
?>
    <div class="thum" id="post<?= $post[0]['post_id'] ?>">
        <img class="img" src=" <?php echo C_GAL . '/Users/' . $post[0]['filename'] ?> ">
        <button class="butt" onclick="deletePost(<?php echo $post[0]['post_id'] ?>)" >Delete</button>
    </div>
<?php endforeach; ?>
<div id="error"></div>