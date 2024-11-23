<?php include('../includes/db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returned Items</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <!-- NAV BAR -->
        <?php include('../includes/navbar.php'); ?>
        <!-- END NAV BAR -->

        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- HEADER -->
            <?php include('../includes/header.php'); ?>
            <!-- END HEADER -->

            <!-- RETURNED CONTENTS HERE -->
            <main class="p-6">
                <h1 class="text-2xl font-bold mb-4">Returned Items</h1>
                
                <div class="overflow-x-auto bg-white shadow rounded-lg p-4">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border border-gray-300 text-left font-medium text-gray-700">Item</th>
                                <th class="px-4 py-2 border border-gray-300 text-left font-medium text-gray-700">Borrower</th>
                                <th class="px-4 py-2 border border-gray-300 text-left font-medium text-gray-700">Date Returned</th>
                                <th class="px-4 py-2 border border-gray-300 text-left font-medium text-gray-700">Condition</th>
                                <th class="px-4 py-2 border border-gray-300 text-left font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Fetch returned items from the returned table
                                $stmt = $conn->query("SELECT * FROM returned");
                                $returned_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Debugging: Check if there are any returned items
                               
                                
                                // Check if there are any returned items
                                if (count($returned_items) > 0) {
                                    foreach ($returned_items as $item) {
                                        // Fetch the item details
                                        $item_stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
                                        $item_stmt->execute([$item['item_id']]);
                                        $item_details = $item_stmt->fetch(PDO::FETCH_ASSOC);

                                        echo '<tr class="hover:bg-gray-50">';
                                        echo '<td class="px-4 py-2 border border-gray-300">' . htmlspecialchars($item_details['name']) . '</td>';
                                        echo '<td class="px-4 py-2 border border-gray-300"> You </td>';
                                        echo '<td class="px-4 py-2 border border-gray-300">' . $item['return_date'] . '</td>';
                                        echo '<td class="px-4 py-2 border border-gray-300">' . htmlspecialchars($item['condition']) . '</td>';
                                        echo '<td class="px-4 py-2 border border-gray-300"><button class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">View Details</button></td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="5" class="text-center py-3">No returned items found.</td></tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
