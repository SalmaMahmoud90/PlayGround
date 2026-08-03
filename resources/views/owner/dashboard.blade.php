<!DOCTYPE html>
<html>
<head>
    <title>Owner Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-white shadow">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-emerald-600">PlayGround - Owner</h1>
                <div>
                    <span class="text-gray-700 mr-4">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container mx-auto px-6 py-8">
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}!</h1>
                <p class="text-gray-600 mt-2">This is your owner dashboard.</p>
                
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-emerald-50 rounded-xl p-6 border border-emerald-200">
                        <h3 class="text-sm font-semibold text-gray-600">My Playgrounds</h3>
                        <p class="text-3xl font-bold text-emerald-600 mt-2">0</p>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                        <h3 class="text-sm font-semibold text-gray-600">Total Bookings</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-2">0</p>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-6 border border-purple-200">
                        <h3 class="text-sm font-semibold text-gray-600">Revenue</h3>
                        <p class="text-3xl font-bold text-purple-600 mt-2">$0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>