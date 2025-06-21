<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Helpers\Datehelper;
use Maatwebsite\Excel\Concerns\WithTitle;

class AttendanceRecapExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithTitle
{
    protected $startDate;
    protected $endDate;
    protected $recapData;

    public function __construct($startDate, $endDate, $recapData)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->recapData = $recapData;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->recapData);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        $headings = ['Nama User'];
        foreach (DateHelper::getDatesFromRange($this->startDate, $this->endDate) as $date) {
            $headings[] = $date;
        }
        return $headings;
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($recap): array
    {
        $row = [$recap['user']->name];
        foreach (DateHelper::getDatesFromRange($this->startDate, $this->endDate) as $date) {
            if (isset($recap['data'][$date])) { // Cek apakah ada data untuk tanggal ini
                if ($recap['data'][$date]['type'] == 'attendance') {
                    $row[] = 'Hadir (' . $recap['data'][$date]['data']->time_in . ')';
                } elseif ($recap['data'][$date]['type'] == 'permission') {
                    $row[] = 'Izin (' . $recap['data'][$date]['data']->reason . ')';
                }
            } else {
                $row[] = ''; // Biarkan sel kosong jika tidak ada data
            }
        }
        return $row;
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Rekap Absensi';
    }
}
