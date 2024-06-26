    <?php
    class Model extends Database {
        public function __construct() {
            $this->conn = $this->connect();
        }

        protected $limit   = 10;
        protected $offset   = 0;
        protected $order_type  = "desc";
        protected $order_column = "id";
        public $errors   = [];
        
        public function findAll()
        {
            $query = "select * from $this->table order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
    
            return $this->query($query);
        }
    
        public function test()
        {
            $stmt = "SELECT * FROM vendor";
            $results = $this->query($stmt);
    
            show($results);
        }
    
        // public function getDetailsByEmail($column, $email) {
        //     $query = "SELECT * FROM $this->table WHERE $column = :email LIMIT 1";
        //     $data = ['email' => $email];
            
        //     return $this->query($query, $data);
        // }
    
    
    
        // public function where($data, $data_not = [])
        // {
        // $keys = array_keys($data);
        // $keys_not = array_keys($data_not);
        // $query = "select * from $this->table where ";
    
        // foreach ($keys as $key) {
        // $query .= $key . " = :". $key . " && ";
        // }
    
        // foreach ($keys_not as $key) {
        // $query .= $key . " != :". $key . " && ";
        // }
        
        // $query = trim($query," && ");
    
        // $query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        // $data = array_merge($data, $data_not);
    
        // return $this->query($query, $data);
        // }
    
        public function where($conditions) {
            $query = "SELECT * FROM {$this->table} WHERE ";
            $values = [];
            foreach ($conditions as $column => $value) {
                $query .= "{$column} = ? AND ";
                $values[] = $value;
            }
            $query = rtrim($query, ' AND ');
            $query .= " ORDER BY add_id DESC"; // Use add_id if ordering is needed
            $query .= " LIMIT 1"; // If you want to limit the results to 1
    
            return $this->query($query, $values);
        }
    
        public function first($data, $data_not = []) {
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $this->table where ";
    
        foreach ($keys as $key) {
            $query .= $key . " = :". $key . " && ";
        }
    
        foreach ($keys_not as $key) {
            $query .= $key . " != :". $key . " && ";
        }
    
        $query = trim($query," && ");
    
        $query .= " limit 1"; // Adjusted limit to 1 for single record
        $data = array_merge($data, $data_not);
        
        // Debugging output
        // echo "Constructed query: " . $query . "<br>";
        // echo "Query parameters: <pre>" . print_r($data, true) . "</pre>";
    
        $result = $this->query($query, $data);
        if($result)
            return $result[0];
    
        return false;
        }
    
    
       
    
    
        //modified
        public function insert($data)
        {
            /**remove unwanted data **/
            if(!empty($this->allowedColumns))
            {
                foreach ($data as $key => $value) {
                    if(!in_array($key, $this->allowedColumns))
                    {
                        unset($data[$key]);
                    }
                }
            }
    
            $keys = array_keys($data);
            $query = "insert into $this->table (".implode(",", $keys).") values (:".implode(",:", $keys).")";
            $result = $this->query($query, $data);
    
            return $result !== false;
        }
    
        //modified
        public function update($id, $data, $id_column = 'id')
        {
            // Remove unwanted data
            if(!empty($this->allowedColumns)) {
                foreach ($data as $key => $value) {
                    if(!in_array($key, $this->allowedColumns)) {
                        unset($data[$key]);
                    }
                }
            }
    
            $keys = array_keys($data);
            $query = "update $this->table set ";
    
            foreach ($keys as $key) {
                $query .= $key . " = :". $key . ", ";
            }
    
            $query = trim($query,", ");
    
            $query .= " where $id_column = :$id_column";
    
            $data[$id_column] = $id;
    
            return $this->query($query, $data);
        }
    
    
        public function delete($id, $id_column = 'id')
        {
    
        $data[$id_column] = $id;
        $query = "delete from $this->table where $id_column = :$id_column ";
        $this->query($query, $data);
    
        return false;
    
        }
    
        public function getLastInsertedCustomerID() {
            $query = "SELECT currval('customer_cus_id_seq') AS last_insert_id";
            $result = $this->query($query);
            if ($result && isset($result[0]['last_insert_id'])) {
                return $result[0]['last_insert_id'];
            }
            return false;
        }
        
        
    
        public function firsttoken($data, $data_not = []) {
            $keys = array_keys($data);
            $keys_not = array_keys($data_not);
            $query = "SELECT * FROM $this->table WHERE ";
        
            foreach ($keys as $key) {
                $query .= $key . " = :" . $key . " AND ";
            }
        
            foreach ($keys_not as $key) {
                $query .= $key . " != :" . $key . " AND ";
            }
        
            $query = rtrim($query, " AND ");
            $query .= " LIMIT $this->limit OFFSET $this->offset";
        
            $data = array_merge($data, $data_not);
        
            // Debugging output
            echo "Constructed query: " . $query . "<br>";
            echo "Query parameters: <pre>" . print_r($data, true) . "</pre>";
        
            $result = $this->query($query, $data);
            if ($result) {
                return $result[0];
            }
        
            return false;
        }

}



    