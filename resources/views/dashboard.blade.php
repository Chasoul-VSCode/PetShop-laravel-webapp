<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        .sidebar-icon { 
            @apply relative flex items-center justify-center h-12 w-12 mt-2 mb-2 mx-auto shadow-lg 
            bg-gray-800 text-blue-500 hover:bg-blue-600 hover:text-white rounded-3xl hover:rounded-xl 
            transition-all duration-300 ease-linear cursor-pointer;
        }
        .sidebar-tooltip {
            @apply absolute w-auto p-2 m-2 min-w-max left-14 rounded-md shadow-md text-white bg-gray-900 
            text-xs font-bold transition-all duration-100 scale-0 origin-left;
        }
        .sidebar {
            transition: width 0.3s ease;
        }
        .sidebar.expanded {
            width: 200px;
        }
        .sidebar.expanded .sidebar-icon {
            width: 100%;
            justify-content: flex-start;
            padding-left: 1rem;
            border-radius: 0.5rem;
        }
        .sidebar.expanded .sidebar-tooltip {
            position: static;
            scale: 1;
            margin-left: 1rem;
        }
        .card {
            @apply bg-white rounded-lg shadow-md p-6 transition-transform duration-300 ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stat-value {
            @apply text-3xl font-bold text-gray-800 mt-2;
        }
        .chart-container {
            width: 100%;
            height: 300px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
    </style>
</head>
<body class="bg-gray-100 flex h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[70px] overflow-y-auto text-center bg-gray-900">
        <div class="text-gray-100 text-xl">
            <div class="p-2.5 mt-1 flex items-center">
                <i class="fas fa-paw px-2 py-1 rounded-md bg-blue-600"></i>
                <span class="sidebar-tooltip">PetShop</span>
            </div>
        </div>
        <div class="my-2 bg-gray-600 h-[1px]"></div>
        <div class="sidebar-icon group">
            <i class="fas fa-home"></i>
            <span class="sidebar-tooltip group-hover:scale-100">Home</span>
        </div>
        <div class="sidebar-icon group">
            <i class="fas fa-user-friends"></i>
            <span class="sidebar-tooltip group-hover:scale-100">Customers</span>
        </div>
        <div class="sidebar-icon group">
            <i class="fas fa-shopping-cart"></i>
            <span class="sidebar-tooltip group-hover:scale-100">Orders</span>
        </div>
        <div class="sidebar-icon group">
            <i class="fas fa-chart-line"></i>
            <span class="sidebar-tooltip group-hover:scale-100">Analytics</span>
        </div>
        <div class="sidebar-icon group">
            <i class="fas fa-cog"></i>
            <span class="sidebar-tooltip group-hover:scale-100">Settings</span>
        </div>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- App Bar -->
        <header class="flex justify-between items-center p-4 bg-white shadow-md">
            <div class="flex items-center space-x-4">
                <button id="sidebarToggle" class="text-gray-500 hover:text-gray-600">
                    <i class="fas fa-bars"></i>
                </button>
                <span class="text-2xl font-semibold text-gray-800">PetShop Dashboard</span>
            </div>
            <div class="flex items-center space-x-4">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-300">
                    <i class="fas fa-plus mr-2"></i>New Order
                </button>
                <img class="h-10 w-10 rounded-full" src="/api/placeholder/40/40" alt="User avatar" />
            </div>
        </header>

        <!-- Tab Bar -->
        <nav class="flex bg-white border-b">
            <a href="#" class="tab-link active text-blue-500 py-4 px-6 block hover:text-blue-500 focus:outline-none border-b-2 border-blue-500">
                Overview
            </a>
            <a href="#" class="tab-link text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
                Products
            </a>
            <a href="#" class="tab-link text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
                Services
            </a>
            <a href="#" class="tab-link text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none">
                Appointments
            </a>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
            <div class="container mx-auto px-6 py-8">
                <h3 class="text-gray-700 text-3xl font-medium">Dashboard</h3>
                
                <!-- Stats Cards -->
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-full p-3">
                                <i class="fas fa-paw text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Total Pets</p>
                                <p class="stat-value" id="totalPets">1,250</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-full p-3">
                                <i class="fas fa-dollar-sign text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Revenue</p>
                                <p class="stat-value" id="revenue">$15,350</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-full p-3">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Customers</p>
                                <p class="stat-value" id="customers">820</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-full p-3">
                                <i class="fas fa-calendar-check text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Appointments</p>
                                <p class="stat-value" id="appointments">75</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="mt-8">
                    <div class="card">
                        <h4 class="text-gray-600 text-xl font-medium mb-4">Monthly Revenue</h4>
                        <div class="chart-container" id="revenueChart"></div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="mt-8">
                    <h4 class="text-gray-600 text-xl font-medium">Recent Orders</h4>
                    <div class="mt-4">
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Customer
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="recentOrders">
                                    <!-- Orders will be dynamically added here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white shadow-lg">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm">© 2024 PetShop. All rights reserved.</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-500 hover:text-gray-700">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-gray-700">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('expanded');
        });

        // Tab Switching
        document.querySelectorAll('.tab-link').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector('.tab-link.active').classList.remove('active', 'text-blue-500', 'border-b-2', 'border-blue-500');
                this.classList.add('active', 'text-blue-500', 'border-b-2', 'border-blue-500');
            });
        });

        // Animated Counter
        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Animate stat values
        animateValue(document.getElementById("totalPets"), 0, 1250, 2000);
        animateValue(document.getElementById("customers"), 0, 820, 2000);
        animateValue(document.getElementById("appointments"), 0, 75, 2000);

        // Animate revenue with currency format
        const revenueElement = document.getElementById("revenue");
        const revenueValue = 15350;
        const revenueDuration = 2000;
        let revenueStart = null;

        function animateRevenue(timestamp) {
            if (!revenueStart) revenueStart = timestamp;
            const progress = Math.min((timestamp - revenueStart) / revenueDuration, 1);
            const currentValue = Math.floor(progress * revenueValue);
            revenueElement.innerHTML = '$' + currentValue.toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(animateRevenue);
            }
        }

        window.requestAnimationFrame(animateRevenue);

        // Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Monthly Revenue',
                    data: [12000, 19000, 15000, 17000, 22000, 24000, 25000, 28000, 30000, 32000, 35000, 38000],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true, 
            }
        });
    </script>
</body>
</html>
