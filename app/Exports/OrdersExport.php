<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OrdersExport implements FromCollection, WithHeadings, WithColumnFormatting, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $dataCount;

    public function collection()
    {
        $oders = Order::with(['user', 'cart.cartItems.product'])->get();
        $oders = $oders->map(function($oders) {
            return [
                $oders->id,
                $oders->user->name,
                $oders->is_shipped,
                $oders->cart->cartItems->sum(function($cartItem) {
                    return $cartItem->product->price * $cartItem->quantity;
                }),
                Date::dateTimeToExcel($oders->created_at)
            ];
        });
        $this->dataCount = $oders->count();

        return $oders;
    }

    public function headings(): array
    {
        // return Schema::getColumnListing('orders');
        return ['編號', '購買者', '是否運送', '總價', '建立時間'];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(50);

                for ($i=0; $i < $this->dataCount; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(50);
                }

                $event->sheet->getDelegate()->getStyle('A1:B'. $this->dataCount)->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A1:A'. $this->dataCount)->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                        'bold' => true,
                        'italic' => true,
                        'color' => [
                            'rgb' => 'FF0000'
                        ]
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '000000'
                        ],
                        'endColor' => [
                            'rgb' => '000000',
                        ],
                    ]
                ]);
                $event->sheet->getDelegate()->mergeCells('G1:H1');
            }
        ];
    }
}
