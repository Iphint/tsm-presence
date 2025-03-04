<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class PajakExport implements FromCollection, WithHeadings
{
    protected $dataPajak;

    public function __construct($dataPajak)
    {
        $this->dataPajak = $dataPajak;
    }

    public function collection()
    {
        return $this->dataPajak->map(function ($pajak, $index) {
            return [
                'No' => $index + 1,
                'Tgl Pemotongan (dd/MM/yyyy)' => Carbon::parse($pajak['tanggal_pemotongan'])->format('d/m/Y'),
                'Penerima Penghasilan? (NPWP/NIK)' => 'NIK',
                'NPWP (tanpa format/tanda baca)' => $pajak['npwp'] ?? '-',
                'NIK (tanpa format/tanda baca)' => $pajak['nik'],
                'Nama Penerima Penghasilan Sesuai NIK' => $pajak['nama'],
                'Alamat Penerima Penghasilan Sesuai NIK' => $pajak['alamat'],
                'Kode Objek Pajak' => '21-100-01',
                'Penandatangan Menggunakan? (NPWP/NIK)' => 'NPWP',
                'NPWP Penandatangan (tanpa format/tanda baca)' => '933607194429000',
                'NIK Penandatangan (tanpa format/tanda baca)' => '3273201705880002',
                'Kode PTKP' => $pajak['ptkp'] ?? '-',
                'Pegawai Harian? (Ya/Tidak)' => 'Tidak',
                'Menggunakan Gross Up? (Ya/Tidak)' => 'Tidak',
                'Penghasilan Bruto' => number_format($pajak['totalGaji'], 0, ',', '.'),
                'Terdapat Akumulasi Penghasilan Bruto Sebelumnya? (Ya/Tidak)' => 'Tidak',
                'Akumulasi Penghasilan Bruto Sebelumnya' => number_format($pajak['net_salary_bulan_sebelumnya'], 0, ',', '.'),
                'Mendapatkan Fasilitas ? (N/SKB/DTP)' => 'N',
                'Nomor SKB/Nomor DTP' => '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tgl Pemotongan (dd/MM/yyyy)',
            'Penerima Penghasilan? (NPWP/NIK)	',
            'NPWP (tanpa format/tanda baca)',
            'NIK (tanpa format/tanda baca)',
            'Nama Penerima Penghasilan Sesuai NIK',
            'Alamat Penerima Penghasilan Sesuai NIK',
            'Kode Objek Pajak',
            'Penandatangan Menggunakan? (NPWP/NIK)',
            'NPWP Penandatangan (tanpa format/tanda baca)',
            'NIK Penandatangan (tanpa format/tanda baca)',
            'Kode PTKP',
            'Pegawai Harian? (Ya/Tidak)',
            'Menggunakan Gross Up? (Ya/Tidak)',
            'Penghasilan Bruto',
            'Terdapat Akumulasi Penghasilan Bruto Sebelumnya? (Ya/Tidak)',
            'Net Salary Bulan Sebelumnya',
            'Mendapatkan Fasilitas ? (N/SKB/DTP)',
            'Nomor SKB/Nomor DTP'
        ];
    }
}
