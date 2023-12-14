<?php if (!$user->isAdmin()) :
    Redirect::to('index.php');
endif; ?>