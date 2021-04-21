<?php

namespace App\Console\Commands;

use App\Exports\OrdersExport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now()->toDateString();
        Excel::store(new OrdersExport, 'excel/' . $now . '訂單清單.xlsx');
    }
}
