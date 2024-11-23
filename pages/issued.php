<?php
include('../includes/db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <div class="flex h-screen bg-gray-200">
        <!-- NAV BAR -->
        <?php include('../includes/navbar.php'); ?>
        <!-- END NAV BAR -->

        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- HEADER -->
            <?php include('../includes/header.php'); ?>
            <!-- END HEADER -->

            <!-- ISSUED CONTENTS HERE -->
            <main class="p-6">
                <h2 class="text-2xl font-bold mb-4">Issued Items</h2>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                                <th class="py-3 px-6 text-left">Item</th>
                                <th class="py-3 px-6 text-left">Description</th>
                                <th class="py-3 px-6 text-left">Issue Date</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Fetch issued items from the 'issued' table
                                $stmt = $conn->query("SELECT * FROM issued");
                                $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                // Check if there are any items
                                if ($items) {
                                    foreach ($items as $item) {
                                        echo '<tr class="border-b hover:bg-gray-50">';
                                        echo '<td class="py-3 px-6">' . htmlspecialchars($item['name']) . '</td>';
                                        echo '<td class="py-3 px-6">' . htmlspecialchars($item['description']) . '</td>';
                                        echo '<td class="py-3 px-6">' . $item['borrow_date'] . '</td>';
                                        echo '<td class="py-3 px-6"><span class="bg-green-100 text-green-600 px-2 py-1 rounded-full text-xs">Active</span></td>';
                                        echo '<td class="py-3 px-6 text-center">';
                                        echo '<button onclick="returnItem(' . $item['id'] . ')" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Return</button>';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center py-3">No issued items found.</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <script>
        function returnItem(issuedId) {
    console.log("Returning item with ID: " + issuedId);  // Debugging line to check if the ID is being passed correctly

    fetch('/BARRA_school_equipment_system/pages/config/return_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'issued_id=' + issuedId
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);  // Log the response from the PHP script

        if (data.success) {
            alert('Item returned successfully.');
            location.reload(); // Reload the page to update the list
        } else {
            alert('There was an error returning the item: ' + data.message); // Show the error message from the server
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error.');
    });
}

    </script>
</body>
</html>
