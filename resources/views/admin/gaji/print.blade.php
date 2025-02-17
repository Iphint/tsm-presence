<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Slip</title>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="min-h-screen bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <i class="fas fa-building text-3xl"></i>
                    <div>
                        <h1 class="text-2xl font-bold">PT. Tsamaniya</h1>
                        <p class="text-sm opacity-90">Jl. Panglima Sudirman No.142, Pelem, Kec. Kertosono</p>
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-xl font-semibold">Salary Slip</h2>
                    <p class="text-sm opacity-90">March 2025</p>
                </div>
            </div>
        </div>

        <!-- Employee Information -->
        <div class="p-6 border-b">
            <div class="grid grid-cols-2 gap-6">
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user text-gray-500"></i>
                        <div>
                            <p class="text-sm text-gray-600">Employee Name</p>
                            <p class="font-medium">John Doe</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-gray-500"></i>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="font-medium">john_123@gmail.com</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Position</p>
                        <p class="font-medium">IT Manager</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-phone text-gray-500"></i>
                        <div>
                            <p class="text-sm text-gray-600">Phone</p>
                            <p class="font-medium">082121387612</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Salary Details -->
        <div class="p-6">
            <div class="grid grid-cols-2 gap-8">
                <!-- Earnings -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Earnings</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Basic Salary</span>
                            <span class="font-medium">Rp 12.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Transport Allowance</span>
                            <span class="font-medium">Rp 15.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Meal Allowance</span>
                            <span class="font-medium">Rp 88.000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Performance Bonus</span>
                            <span class="font-medium">Rp 78.000</span>
                        </div>
                    </div>
                </div>

                <!-- Deductions -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Deductions</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Income Tax</span>
                            <span class="font-medium">Rp 12.500</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Health Insurance</span>
                            <span class="font-medium">Rp 13.333</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Pension Fund</span>
                            <span class="font-medium">Rp 76.900</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total -->
            <div class="mt-8 pt-6 border-t">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Net Salary</h3>
                        <p class="text-sm text-gray-600">Total earnings minus deductions</p>
                    </div>
                    <div class="text-2xl font-bold text-blue-600">
                        Rp 123.000
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 p-6 text-center text-sm text-gray-600">
            <p>This is a computer-generated document. No signature is required.</p>
        </div>
    </div>
</body>
</html>