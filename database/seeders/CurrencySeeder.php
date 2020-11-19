<?php

namespace Database\Seeders;

use App\Http\Controllers\CurrencyController;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rates')->insert([
            [
                'code'  =>  'USD',
                'amount'    =>  CurrencyController::getRates('USD'),
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now(),
            ],
            [
                'code'  =>  'EUR',
                'amount'    =>  CurrencyController::getRates('EUR'),
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now(),
            ],
            [
                'code'  =>  'RUR',
                'amount'    =>  1,
                'created_at'    =>  Carbon::now(),
                'updated_at'    =>  Carbon::now(),
            ]
        ]);
    }
}
