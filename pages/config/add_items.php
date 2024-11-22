<?php
include('../../includes/db.php');

// Set the response type to JSON
header('Content-Type: application/json');

// Check if the request is a POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize the form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';

    // Debugging output (only for development)
    if ($_SERVER['ENV'] == 'development') {
        echo json_encode(['debug' => ['name' => $name, 'description' => $description]]);
    }

    // Check if both fields are filled
    if (empty($name) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in both fields.']);
        exit;
    }

    // Prepare and execute the SQL query
    try {
        // Prepare the insert query with placeholders
        $stmt = $conn->prepare("INSERT INTO items (name, description) VALUES (:name, :description)");

        // Bind parameters
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Item added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add item.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
