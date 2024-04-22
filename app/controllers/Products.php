<?php


class Products extends Controller
{
    public function index() {
        $database = new Database();
        $conn = $database->connect();

        // Use $conn for database operations (e.g., executing queries)
        if ($conn) {
            echo "Connected to PostgreSQL successfully!";
            // Example query
            $stmt = $conn->query('SELECT * FROM vendor');
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $shows = new Function;
            $shows ->show($results);
            // print_r($results);
        } else {
            echo "Failed to connect to PostgreSQL.";
        }
    }

}
