<?php

class Database {
    private $connection;

    public function __construct($host, $username, $password, $database) {
        $this->connection = new mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function escapeString($string) {
        return $this->connection->real_escape_string($string);
    }

    public function insertId() {
        return $this->connection->insert_id;
    }

    public function affectedRows() {
        return $this->connection->affected_rows;
    }

    public function createTables() {
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(255) NOT NULL,
            username VARCHAR(255) NULL,
            telegram_id BIGINT NOT NULL UNIQUE,
            referral_id BIGINT NOT NULL DEFAULT 0,
            balance BIGINT NOT NULL DEFAULT 0,
            referral_count BIGINT NOT NULL DEFAULT 0,
            referral_balance BIGINT NOT NULL DEFAULT 0,
            referral_bonus BIGINT NOT NULL DEFAULT 0,
            step VARCHAR(255) NOT NULL DEFAULT '0',
            step_admin VARCHAR(255) NOT NULL DEFAULT '0',
            created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        );
        ";

        if ($this->connection->multi_query($sql) === TRUE) {
            do {
                if ($result = $this->connection->store_result()) {
                    $result->free();
                }
            } while ($this->connection->more_results() && $this->connection->next_result());
        } else {
            echo "Error creating tables: " . $this->connection->error;
        }

        return $this->connection;
    }


    public function insert($tableName, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $values = array_values($data);

        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $this->connection->error;
            return false;
        }

        try {
            $types = str_repeat('s', count($values)); // Assuming all values are strings
            $stmt->bind_param($types, ...$values);

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return $this->connection->insert_id;
            } else {
                echo "Error executing statement: " . $stmt->error;
                return false;
            }
        } catch (\Throwable $th) {
            echo "Error inserting data: " . $th->getMessage();
            return false;
        }
    }


    public function update($tableName, $data, $where, $logicalOperator = 'AND') {
        $setClause = '';
        foreach ($data as $column => $value) {
            $setClause .= "$column = ?, ";
        }
        $setClause = rtrim($setClause, ', ');

        $whereClause = '';
        foreach ($where as $column => $value) {
            $whereClause .= "$column = ? $logicalOperator ";
        }
        $whereClause = rtrim($whereClause, "$logicalOperator ");

        $values = array_merge(array_values($data), array_values($where));

        $sql = "UPDATE $tableName SET $setClause WHERE $whereClause";
        $stmt = $this->connection->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $this->connection->error;
            return false;
        }

        try {
            $types = str_repeat('s', count($values)); // Assuming all values are strings
            $stmt->bind_param($types, ...$values);

            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                // echo "No rows affected by the update.";
                return true;
            }
        } catch (\Throwable $th) {
            echo "Error updating data: " . $th->getMessage();
            return false;
        }
    }


    public function select($tableName, $conditions = array(), $logicalOperator = 'AND', $orderBy = '', $limit = '', $fetchone=false) {
        $sql = "SELECT * FROM $tableName";

        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $conditionsStr = array();
            foreach ($conditions as $key => $value) {
                $conditionsStr[] = "$key = ?";
            }
            $sql .= implode(" $logicalOperator ", $conditionsStr);
        }

        if (!empty($orderBy)) {
            $sql .= " ORDER BY $orderBy";
        }

        if (!empty($limit)) {
            $sql .= " LIMIT $limit";
        }

        $stmt = $this->connection->prepare($sql);

        if ($stmt === false) {
            echo "Error preparing statement: " . $this->connection->error;
            return false;
        }

        if (!empty($conditions)) {
            $types = str_repeat('s', count($conditions)); // Assuming all conditions are strings
            $stmt->bind_param($types, ...array_values($conditions));
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();

        if ($fetchone) {
            return $data[0];
        }
        
        return $data;
    }

    function getUser($user_id){
        $user_info = $this->select("users", ['telegram_id'=>$user_id], $fetchone=true);
        return $user_info;
    }
}


?>
