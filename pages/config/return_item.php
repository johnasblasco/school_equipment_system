<?php
include('../../includes/db.php'); // Make sure to include your DB connection

// Check if 'issued_id' is passed
if (isset($_POST['issued_id'])) {
    $issued_id = $_POST['issued_id'];

    // Step 1: Fetch the issued item
    $stmt = $conn->prepare("SELECT * FROM issued WHERE id = ?");
    $stmt->execute([$issued_id]);
    $issued_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($issued_item) {
        // Step 2: Insert the item into the 'returned' table
        $return_date = date('Y-m-d H:i:s'); // Current timestamp as return date
        $condition = 'Good'; // You can change this as per your return condition
        
        // Prepare and execute the INSERT query for the 'returned' table
        $insert_returned = $conn->prepare("INSERT INTO returned (issued_id, item_id, return_date, `condition`) VALUES (?, ?, ?, ?)");
        
        // Execute the query with appropriate values
        $insert_returned->execute([$issued_id, $issued_item['item_id'], $return_date, $condition]);

        // Step 3: Delete the item from the 'issued' table
        $delete_issued = $conn->prepare("DELETE FROM issued WHERE id = ?");
        $delete_issued->execute([$issued_id]);

        // If the operations were successful, return a success response
        echo json_encode(['success' => true, 'message' => 'Item successfully returned and moved to returned table.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found in issued table.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No issued_id provided.']);
}
?>
