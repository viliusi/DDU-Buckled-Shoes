<?php
require_once 'app/backend/core/Init.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {
        try {
            $db = Database::getInstance();

            foreach ($_POST['add_stock'] as $variation_id => $new_stock) {
                // Update the stock for this variation in the database
                $sql = "UPDATE variations SET stock = ? WHERE id = ?";
                $stmt = $db->getConnection()->prepare($sql);
                $stmt->execute([$new_stock, $variation_id]);
            }

            // Loop over the discount array from the form
            foreach ($_POST['discount'] as $product_id => $new_discount) {
                // Update the discount for this product in the database
                $sql = "UPDATE products SET discount = ? WHERE id = ?";
                $stmt = $db->getConnection()->prepare($sql);
                $stmt->execute([$new_discount, $product_id]);
            }

            Session::flash('create-post-success', 'Thanks for inventorying.');
            Redirect::to('product.php?product_id=' . Input::get('product_id'));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
