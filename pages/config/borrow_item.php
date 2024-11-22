<?php
include('../../includes/db.php');

// Get the item_id from POST data
$item_id = $_POST['item_id'];

// Fetch the item data from the items table
$stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the item exists and is available
if ($item && $item['status'] === 'available') {
    // Insert into the issued table
    $stmt = $conn->prepare("INSERT INTO issued (item_id, name, description, borrow_date) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$item['id'], $item['name'], $item['description']]);

    // Update the status of the item in the items table to 'borrowed'
    $stmt = $conn->prepare("UPDATE items SET status = 'borrowed' WHERE id = ?");
    $stmt->execute([$item['id']]);

    // Return success response
    echo json_encode(['success' => true]);
} else {
    // If the item is not available
    echo json_encode(['success' => false, 'message' => 'Item is already borrowed or does not exist']);
}
?>
