<?php

use Illuminate\Database\Seeder;
use App\Price;

class PricesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $info = [
            ['subscription_type'=>1,'currency'=>'USD','currency_symbol'=>'$','amount'=>14],
            ['subscription_type'=>1,'currency'=>'EUR','currency_symbol'=>'€','amount'=>17],
            ['subscription_type'=>1,'currency'=>'GBP','currency_symbol'=>'£','amount'=>14],
            ['subscription_type'=>2,'currency'=>'USD','currency_symbol'=>'$','amount'=>21],
            ['subscription_type'=>2,'currency'=>'EUR','currency_symbol'=>'€','amount'=>25],
            ['subscription_type'=>2,'currency'=>'GBP','currency_symbol'=>'£','amount'=>21],
        ];

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('prices')->truncate();
        foreach($info as $row)
        {
            $price = new Price;
            $price->subscription_type = $row['subscription_type'];
            $price->currency = $row['currency'];
            $price->currency_symbol = $row['currency_symbol'];
            $price->amount = $row['amount'];
            $price->save();
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
