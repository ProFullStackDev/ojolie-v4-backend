<?php

use Illuminate\Database\Seeder;
use App\SubscriptionType;

class SubscriptionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $info  = [
            ['code'=>100,'name'=>'USER_SUBSCRIPTION_TYPE_SYSTEM'],
            ['code'=>101,'name'=>'USER_SUBSCRIPTION_TYPE_FREE'],
            ['code'=>102,'name'=>'USER_SUBSCRIPTION_TYPE_COUPON'],
            ['code'=>103,'name'=>'USER_SUBSCRIPTION_TYPE_GIFT'],
            ['code'=>1,'name'=>'USER_SUBSCRIPTION_TYPE_1YR'],
            ['code'=>2,'name'=>'USER_SUBSCRIPTION_TYPE_2YR'],
            ['code'=>11,'name'=>'USER_SUBSCRIPTION_TYPE_RENEW_1YR'],
            ['code'=>12,'name'=>'USER_SUBSCRIPTION_TYPE_RENEW_2YR'],
        ];

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('subscription_types')->truncate();
        foreach($info as $row)
        {
            $subscription_type = new SubscriptionType;
            $subscription_type->code = $row['code'];
            $subscription_type->name = $row['name'];
            $subscription_type->save();
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
