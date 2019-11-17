<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lib\Command\AutoGenerateBill;

class AutoAddHkBill extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AutoAddHkBill:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '检测到期时间自动生成订单';

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
     * @return mixed
     */
    public function handle()
    {
        (new AutoGenerateBill)->Fillter();
    }
}
