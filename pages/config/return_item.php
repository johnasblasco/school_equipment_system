<?php
include('../../includes/db.php'); // Ensure the database connection is included

if (isset($_POST['issued_id'])) {
    $issued_id = $_POST['issued_id'];

    try {
        // Step 1: Fetch the issued item from the 'issued' table
        $stmt = $conn->prepare("SELECT * FROM issued WHERE id = ?");
        $stmt->execute([$issued_id]);
        $issued_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($issued_item) {
            // Step 2: Insert into 'returned' table
            $return_date = date('Y-m-d H:i:s'); // Current date-time
            $condition = 'Good'; // Default condition (you can change it if needed)

            // Insert into 'returned' table
            $insert_returned = $conn->prepare("INSERT INTO returned (issued_id, item_id, return_date, `condition`) VALUES (?, ?, ?, ?)");
            $insert_returned->execute([$issued_item['id'], $issued_item['item_id'], $return_date, $condition]);

            // Step 3: Delete from 'issued' table after inserting into 'returned'
            $delete_issued = $conn->prepare("DELETE FROM issued WHERE id = ?");
            $delete_issued->execute([$issued_id]);

            echo json_encode(['success' => true, 'message' => 'Item returned successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Item not found.']);
        }

    } catch (PDOException $e) {
        // Return the error message if any issue occurs
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No issued_id provided.']);
}
?>
