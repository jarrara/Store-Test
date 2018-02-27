<?php

include 'Users.php';


class Order {

    private $user_id;
    private $db;
    private $cart_id;
    private $user_discount_rate;
    private $order_table;

    public function __construct($user_id, $cart_id) {
        $this->order_table = constant('order_table');
        $this->db = new Database();

        $this->user_id = $user_id;

        $user_obj = new Users($user_id);
        $this->user_discount_rate = $user_obj->get_discount_rate();

        $this->cart_id = $cart_id;
    }

    //get total cart amount
    function get_total_amount() {
        $total_amount = 0;

        $total_amount_query = "SELECT sum(amount) total_amount FROM `cart` WHERE cart_id = " . $this->cart_id . " and user_id = " . $this->user_id;

        if ($result = $this->db->get($total_amount_query))
            $total_amount = $result['total_amount'];

        return $total_amount;
    }

    //get non grocery cart amount
    function get_non_grocery_amount() {
        $non_grocery_sum = 0;

        //get total amount of non-grocery product
        $total_non_grocery_query = "SELECT sum(amount) total FROM `cart` JOIN product on  cart.product_id  = product.product_id JOIN categories on product.category_id =  categories.category_id   WHERE cart.cart_id = " . $this->cart_id . " and user_id = " . $this->user_id . "
		and categories.category_id != " . constant('grocery_category_id');

        if ($rs = $this->db->get($total_non_grocery_query))
            $non_grocery_sum = $rs['total'];

        return $non_grocery_sum;
    }

    public function get_order_summary() {
        $total_amount = $this->get_total_amount();
        $fixed_discount = self::get_fixed_discount($total_amount);
        $non_grocery_sum = $this->get_non_grocery_amount();
        $percentage_discount = $non_grocery_sum * $this->user_discount_rate;

        $net_amount = $total_amount - ($fixed_discount + $percentage_discount);

        $order_data = array(
            "total_amount" => $total_amount,
            "fixed_discount" => $fixed_discount,
            "non_grocery_sum" => $non_grocery_sum,
            "user_discount_rate" => $this->user_discount_rate,
            "percentage_discount" => $percentage_discount,
            "net_amount" => $net_amount
        );

        print_r($order_data);
    }

    public static function get_fixed_discount($order_amount) {
        return floor($order_amount / 100) * 5;
    }

}
