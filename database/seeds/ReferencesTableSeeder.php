<?php

use Illuminate\Database\Seeder;
use App\Reference;

class ReferencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $info = [
            ['column'=>'active','referable_type'=>'App\User','referable_id'=>-1,'name'=>'Email not Verified'],
            ['column'=>'active','referable_type'=>'App\User','referable_id'=>0,'name'=>'Free'],
            ['column'=>'active','referable_type'=>'App\User','referable_id'=>1,'name'=>'Active'],
            ['column'=>'active','referable_type'=>'App\User','referable_id'=>2,'name'=>'Cancelled'],
            ['column'=>'active','referable_type'=>'App\User','referable_id'=>3,'name'=>'Expired'],

            ['column'=>'type','referable_type'=>'App\Member','referable_id'=>0,'name'=>'Free'],
            ['column'=>'type','referable_type'=>'App\Member','referable_id'=>1,'name'=>'Paid'],
            ['column'=>'type','referable_type'=>'App\Member','referable_id'=>2,'name'=>'Corporate'],
        ];

        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('references')->truncate();
        foreach($info as $row)
        {
            $reference = new Reference;
            $reference->column = $row['column'];
            $reference->name = $row['name'];
            $reference->referable_id = $row['referable_id'];
            $reference->referable_type = $row['referable_type'];
            $reference->save();
        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
