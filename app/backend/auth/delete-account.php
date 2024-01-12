<?php
require_once 'app/backend/core/Init.php';

User::delete($user->data()->user_id);

Redirect::to('index.php');
