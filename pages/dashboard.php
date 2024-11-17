<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Dashboard</title>
      <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
       <!-- NAV BAR -->
      <?php include('../includes/navbar.php') ?>
        <!-- END NAV BAR -->

        <div class="flex flex-col flex-1 overflow-hidden">

            <!-- HEADER -->
            <?php include('../includes/header.php') ?>
            <!-- END HEADER -->

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container px-6 py-8 mx-auto">
                    <h3 class="text-3xl font-medium text-gray-700">Dashboard</h3>
    
                    <!-- REPORT CARDS -->
                        <?php include('components/reportCards.php') ?>
                   <!-- END REPORT CARDS -->
    
                   
                   <!-- BORROWER TABLES -->
                        <?php include('components/borrowerTable.php') ?>
                   <!-- END BORROWER TABLES -->
                </div>
            </main>
        </div>
    </div>
</div>
</body>
</html>