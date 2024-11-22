<?php
include('../../includes/db.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure content type is JSON
header('Content-Type: application/json');

// Check if POST request contains 'item_id'
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $itemId = $_POST['item_id'];

    try {
        // Fetch the item details from the 'items' table
        $stmt = $conn->prepare("SELECT name, description FROM items WHERE id = ?");
        $stmt->execute([$itemId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $itemName = $item['name'];
            $itemDescription = $item['description'];

            // Insert into 'issued' table with the item name and description
            $stmt = $conn->prepare("INSERT INTO issued (item_id, name, description, borrow_date) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$itemId, $itemName, $itemDescription]);

            // Delete item from 'items' table
            $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
            $stmt->execute([$itemId]);

            echo json_encode(["success" => true, "message" => "Item borrowed successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Item not found"]);
        }
    } catch (Exception $e) {
        // If an error occurs, output error details
        echo json_encode(["success" => false, "message" => "Error: " . $e->getMessage()]);
    }
} else {
    // No 'item_id' in POST request
    echo json_encode(["success" => false, "message" => "No item_id provided"]);
}

?>