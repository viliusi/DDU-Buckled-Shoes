<?php

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'rating' => array(
                'required' => true,
                'min' => 1,
                'max' => 2
            ),

            'text' => array(
                'required' => true,
                'min' => 2,
                'max' => 255,
            ),

            'user_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 10,
            ),

            'review_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 10,
            ),
            ),
        );

        if ($validation->passed() && $user->data()->user_id == Input::get('user_id')) {
            try {
                Review::edit(array(
                    'rating' => Input::get('rating'),
                    'text' => Input::get('text'),
                ), Input::get('review_id'));

                Session::flash('update-success', 'Review successfully updated!');
                $product_id = Review::getReviewById(Input::get('review_id'))->product_id;
                Redirect::to('product.php?product_id=' . $product_id);
            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            echo '<div class="alert alert-danger"><strong></strong>' . cleaner($validation->error()) . '</div>';
        }
    }
}
