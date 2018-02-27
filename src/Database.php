<?php

class Database {

    private $host;
    private $user_name;
    private $password;
    private $db;
    private $con;

    public function __construct() {
        $this->host = constant('HOST');
        $this->user_name = constant('USER_NAME');
        $this->password = constant('DB_PASSWORD');
        $this->db = constant('DB_NAME');

        $this->make_connection();
    }

    /**
     * Make database connection using mysqli adapter 
     */
    public function make_connection() {

        $this->con = new mysqli($this->host, $this->user_name, $this->password, $this->db);
        if ($this->con->connect_errno) {
            echo "Error: " . $mysqli->connect_error;
            die();
        }
    }

    /**
     * Get query result from database 
     * @param type $query
     * @return array of results 
     */
    public function get($query) {

        if (!$result = $this->con->query($query)) {
            return false;
        }

        if ($result->num_rows === 0)
            return false;

        return $result->fetch_assoc();
    }

}

?>