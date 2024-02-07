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

            'stock_control' => array(
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
                $body = "<div class='container' style='margin-top:30px'>
                            <h2>Order Details</h2>";

                $body .= "<style>
                            .product-box {
                                border: 1px solid #fff;
                                padding: 10px;
                                margin-bottom: 10px;
                            }
        
                            .product-box h3 {
                                margin: 0;
                                padding-bottom: 10px;
                                border-bottom: 1px solid #fff;
                            }
        
                            .product-box p {
                                margin: 5px 0;
                            }
                          </style>";

                foreach ($products as $item) {
                    $product_details = explode(",", $item);

                    $quantity = $product_details[0];
                    $variation_name = $product_details[1];
                    $price = $product_details[2];
                    $discount = $product_details[3];
                    $product_name = $product_details[4];

                    $price_at_purchase = $price * (100 - $discount) / 100;
                    $subtotal = $price_at_purchase * $quantity;
                    $total += $subtotal;

                    $body .= "<div class='product-box'>
                                <h3>" . $product_name . "</h3>
                                <p><strong>Variation:</strong> " . $variation_name . "</p>
                                <p><strong>Quantity:</strong> " . $quantity . "</p>";
                    if ($discount > 0) {
                        $body .= "<p><strong>Price:</strong> <s>" . $price . "</s> " . $price_at_purchase . " (Discount: " . $discount . "%)</p>";
                    } else {
                        $body .= "<p><strong>Price:</strong> " . $price . "</p>";
                    }
                    $body .= "<p><strong>Subtotal:</strong> " . $subtotal . "</p>
                            </div>";
                }

                $body .= "<div class='total-box'>
                            <h3>Total: " . $total . "</h3>
                          </div>";

                $body .= "<br> <br>
                        </div>";

                Mail::send(User::getUserById(Input::get('user_id'))->email, $subject, $body, $altBody);

                Session::flash('create-post-success', 'Thanks for ordering.');
                Redirect::to('index.php');
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
}
