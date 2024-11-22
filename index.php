<?php
      include 'includes/db.php';

      if ($_POST['password'] !== $_POST['confirm-password']) {
            die('Passwords do not match.');
        }

      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name =  $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
            $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
        
            if ($stmt->execute()) {
                header('Location: pages/login.php');
                exit;
            } else {
                $error = "Failed to register.";
            }
        }
        ?>
       


<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Registration</title>
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
<section class="bg-[url('https://the-post-assets.sgp1.digitaloceanspaces.com/2022/03/CAMPUS-3-MARCH-23.png')] bg-cover bg-no-repeat bg-center">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Create an account
              </h1>
              <form class="space-y-4 md:space-y-6" method="POST">
              <div>
                      <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kimi no nawa (Your Name)</label>
                      <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Alex Caparas" required="">
                  </div>
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@your-email.com" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <div>
                      <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                      <input type="confirm-password" name="confirm-password" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <div class="flex items-start">
                      <div class="flex items-center h-5">
                        <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                      </div>
                      <div class="ml-3 text-sm">
                        <label for="terms" class="font-light text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">Terms and Conditions</a></label>
                      </div>
                  </div>
                  <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create an account</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      Already have an account? <a href="pages/login.php" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>
</body>
</html>