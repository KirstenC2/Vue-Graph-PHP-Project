<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

try {
    // Connect to SQLite database
    $db = new SQLite3('./database.db');  // Adjust the path to your database file

    // Check if the request is for the API endpoint
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint']) && $_GET['endpoint'] === 'getItems') {

        // Perform a SELECT query to retrieve all items
        $query = "SELECT * FROM data ORDER BY date DESC";
        $result = $db->query($query);

        // Fetch data
        $data = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }

        // Output the data as JSON
        echo json_encode(array('data' => $data));
    } else {
        // Handle other types of requests or invalid endpoints
        http_response_code(404); // Not Found
        echo json_encode(array('error' => 'Invalid endpoint'));
    }

    // Close the database connection
    $db->close();

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Connection failed: ' . $e->getMessage()));
}
?>
