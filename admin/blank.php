<?php include 'header.php'; ?>

<div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
    <main class="w-full flex-grow p-6">
        <h1 class="text-3xl text-black pb-6">Dashboard</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div class="bg-white border rounded-lg shadow p-5">
                <h2 class="text-xl font-semibold">Total Users</h2>
                <p class="text-gray-600 text-2xl">1,250</p>
            </div>
            <!-- Card 2 -->
            <div class="bg-white border rounded-lg shadow p-5">
                <h2 class="text-xl font-semibold">Total Sales</h2>
                <p class="text-gray-600 text-2xl">$45,000</p>
            </div>
            <!-- Card 3 -->
            <div class="bg-white border rounded-lg shadow p-5">
                <h2 class="text-xl font-semibold">New Orders</h2>
                <p class="text-gray-600 text-2xl">150</p>
            </div>
            <!-- Card 4 -->
            <div class="bg-white border rounded-lg shadow p-5">
                <h2 class="text-xl font-semibold">Pending Requests</h2>
                <p class="text-gray-600 text-2xl">10</p>
            </div>
        </div>

        <div class="mt-6 bg-white p-6 rounded-lg shadow">
            <h2 class="text-2xl font-semibold mb-4">Recent Activity</h2>
            <ul class="space-y-3">
                <li class="p-3 border-b">User John Doe signed up</li>
                <li class="p-3 border-b">Product XYZ sold for $120</li>
                <li class="p-3 border-b">Admin updated settings</li>
                <li class="p-3">New blog post published</li>
            </ul>
        </div>
    </main>
</div>

<?php include 'footer.php'; ?>
