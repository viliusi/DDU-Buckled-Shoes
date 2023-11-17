<div class="container">
    <div class="row">
        <div class="jumbotron text-center" style="margin-bottom:0">
            <h1>Post title: <?php echo $post->title; ?></h1>
            <h2>The Comment Section</h1>

                <?php
                echo '<a href="create-comment.php?post_id=' . $post_id . '" class="btn btn-primary">Create a comment</a>';
                if (isset($comments) && $comments->count()) {
                    foreach ($comments->results() as $c) {
                        echo '<div class="card">';
                        echo '<div class="card-body">';
                        echo '<h4 class="card-title">' . $c->username . '</h4>';
                        echo '<p class="card-text">' . $c->content . '</p>';
                        echo '<p class="card-text">' . $c->created_at . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger"><strong></strong>No comments found!</div>';
                }
                ?>
        </div>
    </div>
</div>