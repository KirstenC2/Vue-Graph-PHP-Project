<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

try {
    // Connect to SQLite database
    $db = new SQLite3('./database.db');  // Adjust the path to your database file
    
    // Check if the request is for the API endpoint
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'getItems') {
        // Get user-selected column and filter value
        $selectedColumn = isset($_GET['column']) ? $_GET['column'] : 'date';
        $filterValue = isset($_GET['value']) ? $_GET['value'] : '';

        // Validate selected column to prevent SQL injection (replace with your validation logic)
        $allowedColumns = array('date', 'Open', 'High', 'Low', 'Close', 'Inflation', 'country', 'ISO3');
        if (!in_array($selectedColumn, $allowedColumns)) {
            http_response_code(400); // Bad Request
            echo json_encode(array('error' => 'Invalid column selected'));
            exit();
        }

        // Perform a SELECT query with user-selected column and filter value
        $query = "SELECT * FROM data WHERE $selectedColumn LIKE '%$filterValue%' ORDER BY date DESC"; // Replace 'your_table_name' with the actual table name
        $result = $db->query($query);

        // Fetch data
        $data = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }

        // Output the data as JSON
        echo json_encode($data);
    } else {
        // Handle other types of requests or invalid endpoints
        http_response_code(404); // Not Found
        echo json_encode(array('error' => 'Invalid endpoint'));
    }

    // Close the database connection
    $db->close();

} catch (Exception $e) {
    echo json_encode(array('error' => 'Connection failed: ' . $e->getMessage()));
}
?>
