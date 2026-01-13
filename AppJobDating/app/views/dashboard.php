<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Modern Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Sidebar -->
  <div class="flex">
    <aside class="w-64 bg-white shadow-lg hidden md:block">
      <div class="p-6 text-xl font-bold text-green-600">MyDashboard</div>
      <nav class="mt-6">
        <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-green-50">🏠 Dashboard</a>
        <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-green-50">👤 Users</a>
        <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-green-50">💳 Wallet</a>
        <a href="#" class="block px-6 py-3 text-gray-700 hover:bg-green-50">📊 Statistics</a>
        <a href="#" class="block px-6 py-3 text-red-500 hover:bg-red-50">🚪 Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1">
      <!-- Header -->
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Dashboard</h1>
        <div class="flex items-center gap-4">
          <span class="text-gray-600">Hello, User</span>
          <img src="https://i.pravatar.cc/40" class="rounded-full" />
        </div>
      </header>

      <!-- Cards -->
      <main class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Users</p>
            <h2 class="text-3xl font-bold">1,240</h2>
          </div>
          <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Revenue</p>
            <h2 class="text-3xl font-bold">$8,540</h2>
          </div>
          <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Transactions</p>
            <h2 class="text-3xl font-bold">320</h2>
          </div>
          <div class="bg-white p-5 rounded-xl shadow">
            <p class="text-gray-500">Errors</p>
            <h2 class="text-3xl font-bold text-red-500">12</h2>
          </div>
        </div>

        <!-- Table -->
        <div class="mt-10 bg-white rounded-xl shadow p-6">
          <h3 class="text-xl font-semibold mb-4">Latest Transactions</h3>
          <table class="w-full text-left">
            <thead>
              <tr class="text-gray-500 border-b">
                <th class="py-2">User</th>
                <th>Amount</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b">
                <td class="py-2">Ahmed</td>
                <td>$120</td>
                <td class="text-green-600">Success</td>
              </tr>
              <tr class="border-b">
                <td class="py-2">Sara</td>
                <td>$80</td>
                <td class="text-yellow-500">Pending</td>
              </tr>
              <tr>
                <td class="py-2">Yassine</td>
                <td>$45</td>
                <td class="text-red-500">Failed</td>
              </tr>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>

</body>
</html>