<?php 
session_start();
include("../includes/db.php");

// Fetch user data
$user_id = $_SESSION['user_id']; // Replace with actual session logic
$query = "SELECT * FROM user WHERE user_id = :user_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $user['password'];

    $update_query = "UPDATE user SET name = :name, email = :email, password = :password WHERE user_id = :user_id";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $update_stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $update_stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        echo "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Edit Profile</title>
      <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
      <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
            <!-- NAV BAR -->
            <?php include('../includes/navbar.php') ?>
            <!-- END NAV BAR -->

            <div class="flex flex-col flex-1 overflow-hidden">

                  <!-- HEADER -->
                  <?php include('../includes/header.php') ?>
                  <!-- END HEADER -->

                  <!-- INPUT HERE-->
                  <div class="flex justify-center items-center p-6">
                        <div class="w-full max-w-lg bg-white shadow-md rounded-lg p-6">
                              <h2 class="text-3xl font-bold text-gray-700 text-center mb-8">Edit Profile</h2>
                              <form method="POST" action="">
                                    <div class="mb-6">
                                    <label for="name" class="block text-lg font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" id="name" value="<?= htmlspecialchars($user['name']) ?>" 
                                          class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg p-4" required>
                                    </div>

                                    <div class="mb-6">
                                    <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email']) ?>" 
                                          class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg p-4" required>
                                    </div>

                                    <div class="mb-6">
                                    <label for="password" class="block text-lg font-medium text-gray-700">New Password (optional)</label>
                                    <input type="password" name="password" id="password" 
                                          class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg p-4">
                                    </div>

                                    <button type="submit" 
                                          class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg text-lg font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Save Changes
                                    </button>
                              </form>
                        </div>
                        </div>

                  <!-- END INPUT HERE-->

            </div>
      </div>
</body>
</html>
