<?php include('../includes/db.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
        <!-- NAV BAR -->
        <?php include('../includes/navbar.php'); ?>
        <!-- END NAV BAR -->

        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- HEADER -->
            <?php include('../includes/header.php'); ?>
            <!-- END HEADER -->

            <!-- MAIN CONTENT -->
            <main class="p-6">
                <div class="flex justify-between">
                    <div class="flex justify-center gap-4 items-center mb-4">
                        <input 
                            type="text" 
                            placeholder="Search items..." 
                            class="w-full max-w-md p-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" 
                        >
                        <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Search
                        </button>
                    </div>

                    <!-- Add Items Button -->
                    <button onclick="showModal()" class="m-4 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600">
                        + ADD ITEMS
                    </button>

                    <!-- Modal Structure -->
                    <div id="itemModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
                        <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                            <h2 class="text-xl font-bold mb-4">Add New Item</h2>
                            <form id="addItemForm">
                                <input type="text" id="itemName" placeholder="Item Name" class="w-full p-2 mb-4 border rounded-lg">
                                <textarea id="itemDescription" placeholder="Description" class="w-full p-2 mb-4 border rounded-lg"></textarea>
                                <button type="button" onclick="addItem()" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                    Submit
                                </button>
                                <button type="button" onclick="closeModal()" class="ml-2 px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                                    Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Item List Container -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="itemList">
                    <?php
                    $stmt = $conn->query("SELECT * FROM items");
                    while ($item = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="bg-white shadow rounded-lg p-4">';
                        echo '<h3 class="text-lg font-semibold">' . htmlspecialchars($item['name']) . '</h3>';
                        echo '<p class="text-sm text-gray-600">' . htmlspecialchars($item['description']) . '</p>';
                        // Modify Borrow button to redirect to the 'issued' page
                        echo '<button onclick="borrowItem(' . $item['id'] . ')" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Borrow</button>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </main>
            <!-- END MAIN CONTENT -->
        </div>
    </div>

    <!-- JavaScript for Modal and Item Addition -->
    <script>
        function showModal() {
            document.getElementById('itemModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('itemModal').classList.add('hidden');
        }

        function addItem() {
            const name = document.getElementById('itemName').value;
            const description = document.getElementById('itemDescription').value;

            if (name && description) {
                  const formData = new FormData();
                  formData.append('name', name);
                  formData.append('description', description);

                  fetch('/BARRA_school_equipment_system/pages/config/add_items.php', {
                        method: 'POST',
                        body: formData
                  })
                  .then(response => response.json())  // Expecting JSON response
                  .then(data => {
                        if (data.success) {
                        alert(data.message);
                        // Optionally, update the UI to show the new item
                        closeModal();  // Close the modal after successful addition
                        } else {
                        alert(data.message);
                        }


        location.reload();
                  })
                  .catch(error => {
                        console.error('Error:', error);
                        alert('There was an error adding the item.');
                  });
            } else {
                  alert('Please fill in both fields.');
            }
        }

        // Function to handle the Borrow button click
        function borrowItem(itemId) {
    fetch('/BARRA_school_equipment_system/pages/config/borrow_item.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'item_id=' + itemId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Item borrowed successfully.');
            location.reload(); // Reload the page to update the list
        } else {
            alert('There was an error borrowing the item.');
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
