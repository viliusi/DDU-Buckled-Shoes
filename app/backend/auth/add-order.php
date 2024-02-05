<?php
require_once 'app/backend/core/Init.php';
require_once 'app/backend/classes/Order.php';

if (Input::exists()) {
    if (Token::check(Input::get('csrf_token'))) {

        $validate = new Validation();

        $validation = $validate->check($_POST, array(
            'user_id' => array(
                'required' => true,
                'min' => 1,
                'max' => 64,
            ),

            'products' => array(
                'required' => true,
                'min' => 1,
                'max' => 255,
            ),
        ));

        if ($validate->passed()) {
            try {
                Order::create(array(
                    'user_id' => Input::get('user_id'), // Use the user ID from the session
                    'products' => Input::get('products'), // Use the products from the cart
                ));

                unset($_SESSION['cart']);

                $subject = 'Order confirmation for Buckled Shoes';

                $order = Order::getOrdersByUserId(Input::get('user_id'));
                $order = end($order);

                $products = rtrim($order->products, ";");

                $products = explode(";", $products);

                $total = 0;
                $body = "<p>Thank you for your order!</p>";
                $body .= "<table style='width:100%; border: 1px solid'>";
                $altBody = "Thank you for your order!\n";

                foreach ($products as $item) {
                    if (!preg_match('/^(\d+),([^,]+),(\d+),(\d+),([^,]+)$/', $item, $matches)) {
                        error_log("Invalid product item: $item");
                        continue;
                    }

                    // $matches[0] is the entire match, $matches[1] is the first group, etc.
                    $quantity = $matches[1];
                    $variation_name = $matches[2];
                    $price = $matches[3];
                    $discount = $matches[4];
                    $product_name = $matches[5];

                    $subtotal = $price * $quantity;
                    $total += $subtotal;

                    $body .= "<tr>
                                <td>{$product_name}</td>
                                <td>{$variation_name}</td>
                                <td>{$price}</td>
                                <td>{$discount}%</td>
                                <td>{$quantity}</td>
                                <td>{$subtotal}</td>
                              </tr>";

                    $altBody .= "Product Name: {$product_name}\nVariation: {$variation_name}\nPrice: {$price}\nDiscount: {$discount}%\nQuantity: {$quantity}\nSubtotal: {$subtotal}\n-------------------\n";
                }

                $body .= "<tr><td colspan='4'><a href='http://buckledshoes.store/order-details.php?order_id=" . $order->order_id . "'><button>Details</button></a></td><td>Total: " . $total . "</td></tr>";
                $body .= "</table><br>";
                $body .= "<p>We appreciate your business. If you have any questions, please don't hesitate to contact us.</p>";

                $altBody .= "Order Details: http://buckledshoes.store/order-details.php?order_id=" . $order->order_id . "\nTotal: " . $total . "\n";
                $altBody .= "We appreciate your business. If you have any questions, please don't hesitate to contact us.\n";

                Mail::send(User::getUserById(Input::get('user_id'))->email, $subject, $body, $altBody);

                Session::flash('create-post-success', 'Thanks for ordering.');
                Redirect::to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
}
