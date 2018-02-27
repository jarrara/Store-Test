<?php

include 'Database.php';
include 'config.php';

class Users {

    private $user_id;
    private $db;
    private $user_table;
    private $order_table;
    private $loyal_customer_year;

    public function __construct($user_id) {

        $this->user_table = constant('user_table');
        $this->user_id = $user_id;

        $this->order_table = constant('order_table');
        $this->db = new Database();
        $this->loyal_customer_year = 2;
    }

    /**
     * get user type i.e. employee, affiliated, or loyal or normal customer
     * @return type
     */
    public function get_user_type() {
        $query = "Select type from " . $this->user_table . " where id  = " . $this->user_id;

        if (!$result = $this->db->get($query)) {
            die('Invalid user');
        }
        return $result['type'];
    }

    /**
     * check if user has made order 2 year ago or not
     * @return boolean
     */
    public function is_loyal_customer() {
        $query = "Select 1 from " . $this->order_table . " where user_id  = " . $this->user_id . " and order_date < DATE_SUB(NOW(),INTERVAL " . $this->loyal_customer_year . " YEAR) limit 0, 1";

        if (!$result = $this->db->get($query))
            return false;
        else
            return true;
    }

    /**
     * Get the discounted rate for selected user
     * @return real
     */
    public function get_discount_rate() {
        $user_type = $this->get_user_type();
        $discount_rate = 0;
        if ($user_type == 'employee')
            $discount_rate = 0.3;
        elseif ($user_type == 'affiliated')
            $discount_rate = 0.1;
        elseif ($this->is_loyal_customer())
            $discount_rate = 0.05;
        else
            $discount_rate = 0.0;

        return $discount_rate;
    }

}

?>
