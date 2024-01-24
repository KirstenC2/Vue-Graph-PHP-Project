<?php
// Enable CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


try {
    // Connect to SQLite database
    $dbPath = $_SERVER['DOCUMENT_ROOT'] . '/Technical_task/backend/database.db';
    $db = new SQLite3($dbPath);  // Update the path to your absolute path

    // Check if the request is for the API endpoint
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['endpoint'])) {

        switch ($_GET['endpoint']) {
            case 'getItems':
                // Use a prepared statement to prevent SQL injection
                $stmt = $db->prepare("SELECT * FROM data ORDER BY date DESC");

                $result = $stmt->execute();

                // Fetch data
                $data = [];
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $data[] = $row;
                }

                // Output the data as JSON
                echo json_encode(array('data' => $data));
                break;

            case 'getGraphData':
                // Handle new endpoint to get data for the graph
                $country = isset($_GET['country']) ? $_GET['country'] : '';
                            
                $stmt = $db->prepare("SELECT
                                        country,
                                        strftime('%Y', date) AS year,
                                        (MAX(close) - MIN(open)) / MIN(open) * 100 AS yearly_inflation
                                    FROM
                                        data
                                    WHERE 
                                        country LIKE :country 
                                    GROUP BY
                                        country, year
                                    ORDER BY
                                        country, year");
                $stmt->bindValue(':country', '%' . $country . '%', SQLITE3_TEXT);

                                        
                $result = $stmt->execute();
            
                // Fetch data
                $graphData = [];
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $graphData[] = $row;
                }
            
                // Output the data as JSON
                echo json_encode(array('data' => $graphData));
                break;

            case 'getCountries':
                // Use a prepared statement to prevent SQL injection
                $stmt = $db->prepare("SELECT DISTINCT country FROM data ORDER BY country");
                $result = $stmt->execute();
                
                // Fetch data
                $countries = [];
                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                    $countries[] = $row['country'];
                }

                // Output the data as JSON
                echo json_encode(array('data' => $countries));
                break;

            default:
                // Handle unknown endpoint
                http_response_code(404);
                echo json_encode(array('error' => 'Invalid endpoint'));
                break;
        }
    } else {
        // Handle other types of requests or invalid endpoints
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Invalid request'));
    }

    // Close the database connection
    $db->close();

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('error' => 'Connection failed: ' . $e->getMessage()));
}
?>
