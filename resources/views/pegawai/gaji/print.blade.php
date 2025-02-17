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

<body class="min-h-screen bg-gray-100 p-4 sm:p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-green-600 text-white p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-building text-2xl sm:text-3xl"></i>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold">PT. Tsamaniya</h1>
                        <p class="text-xs sm:text-sm opacity-90">Jl. Panglima Sudirman No.142, Pelem, Kec. Kertosono</p>
                    </div>
                </div>
                <div class="text-center sm:text-right">
                    <h2 class="text-lg sm:text-xl font-semibold">Salary Slip</h2>
                    <p class="text-xs sm:text-sm opacity-90"></p>
                </div>
            </div>
        </div>

        <!-- Employee Information -->
        <div class="p-4 sm:p-6 border-b">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user text-gray-500"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Nama Karyawan</p>
                            <p class="text-sm sm:text-base font-medium">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-gray-500"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Email</p>
                            <p class="text-sm sm:text-base font-medium">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user text-gray-500"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Posisi</p>
                            <p class="text-sm sm:text-base font-medium">{{ $user->posisi }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-gray-500"></i>
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600">Cabang Outlet</p>
                            <p class="text-sm sm:text-base font-medium">{{ $user->outlet_cabang }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-3 sm:mb-4 text-gray-800">Salary</h3>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-600">Gaji Pokok</span>
                            <span class="text-sm sm:text-base font-medium">Rp. {{ number_format($salary, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-600">Total kehadiran</span>
                            <span class="text-sm sm:text-base font-medium">
                                {{ $workedDays }} Hari
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-600">Tunjangan Masa Kerja</span>
                            <span class="text-sm sm:text-base font-medium">Rp. {{ number_format($tunjanganMasaKerja, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-600">Tunjangan Jabatan</span>
                            <span class="text-sm sm:text-base font-medium">Rp. {{ number_format($tunjanganJabatan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-600">Lembur</span>
                            <span class="text-sm sm:text-base font-medium">Rp. {{ number_format($totalGajiLembur, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-3 sm:mb-4 text-gray-800">Potongan</h3>
                    <div class="space-y-2 sm:space-y-3">
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-600">Potongan tidak masuk</span>
                            <span class="text-sm sm:text-base font-medium">Rp. {{ number_format($dendaAbsent, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-600">BPJS Kesehatan</span>
                            <span class="text-sm sm:text-base font-medium">Rp. {{ number_format($bpjs, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs sm:text-sm text-gray-600">BPJS Ketenagakerjaan</span>
                            <span class="text-sm sm:text-base font-medium">Rp. {{ number_format($ketenagakerjaan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0">
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800">Net Salary</h3>
                        <p class="text-xs sm:text-sm text-gray-600">Total pendapatan di kurangi total potongan</p>
                    </div>
                    <div class="text-xl sm:text-2xl font-bold text-green-600">
                        Rp {{ number_format($totalSalary, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 p-4 sm:p-6 text-center text-xs sm:text-sm text-gray-600">
            <p>الحمد لله جزاكم الله خيرا</p>
        </div>
    </div>
</body>

</html>