<?php
include '../includes/db.php';  // Include the database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize the email and password to avoid any extra spaces or unwanted characters
    $email = trim($email);
    $password = trim($password);

    // Prepare the query to check if the email exists
    $stmt = $conn->prepare('SELECT * FROM user WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Check if user exists
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Debugging: Check if email matches
        echo "User found: " . $user['email'] . "<br>";

        // Check if the password is correct using password_verify()
        if (password_verify($password, $user['password'])) {
            // Password matches, user is authenticated
            echo "Password is correct!<br>";  // Debugging

            // Start the session
            session_start();
            $_SESSION['user_id'] = $user['user_id'];  // Store user data in session
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            header('Location: dashboard.php');  // Redirect to the dashboard page
            exit;
        } else {
            // Password does not match
            echo "Incorrect password.<br>";  // Debugging
        }
    } else {
        // User does not exist
        echo "User not found.<br>";  // Debugging
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
            tailwind.config = {
                  darkMode: 'class',
                  theme: {
                  extend: {
                        colors: {
                        primary: {"50":"#eff6ff","100":"#dbeafe","200":"#bfdbfe","300":"#93c5fd","400":"#60a5fa","500":"#3b82f6","600":"#2563eb","700":"#1d4ed8","800":"#1e40af","900":"#1e3a8a","950":"#172554"}
                        }
                  },
                  fontFamily: {
                        'body': [
                  'Inter', 
                  'ui-sans-serif', 
                  'system-ui', 
                  '-apple-system', 
                  'system-ui', 
                  'Segoe UI', 
                  'Roboto', 
                  'Helvetica Neue', 
                  'Arial', 
                  'Noto Sans', 
                  'sans-serif', 
                  'Apple Color Emoji', 
                  'Segoe UI Emoji', 
                  'Segoe UI Symbol', 
                  'Noto Color Emoji'
                  ],
                        'sans': [
                  'Inter', 
                  'ui-sans-serif', 
                  'system-ui', 
                  '-apple-system', 
                  'system-ui', 
                  'Segoe UI', 
                  'Roboto', 
                  'Helvetica Neue', 
                  'Arial', 
                  'Noto Sans', 
                  'sans-serif', 
                  'Apple Color Emoji', 
                  'Segoe UI Emoji', 
                  'Segoe UI Symbol', 
                  'Noto Color Emoji'
                  ]
                  }
                  }
                  }
      </script>
</head>
<body>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<section class="bg-[url('https://the-post-assets.sgp1.digitaloceanspaces.com/2022/03/CAMPUS-3-MARCH-23.png')] bg-cover bg-no-repeat bg-center">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        
        <div class="w-full bg-white rounded-lg shadow dark:border sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Login to your account
                </h1>
                <?php if (isset($error)): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form class="space-y-4 md:space-y-6" method="POST">
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                            </div>
                        </div>
                        <a href="forgotPassword.php" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Login</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Don’t have an account yet? <a href="../index.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
</body>
</html>
