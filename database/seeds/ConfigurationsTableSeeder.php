<?php

use Illuminate\Database\Seeder;
use App\Configuration;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $info = [
            ['type'=>'email','key'=>'driver','value'=>'smtp'],
            ['type'=>'email','key'=>'host','value'=>'smtp.gmail.com'],
            ['type'=>'email','key'=>'port','value'=>'465'],
            ['type'=>'email','key'=>'username','value'=>'saintkabyo@gmail.com'],
            ['type'=>'email','key'=>'password','value'=>'password'],
            ['type'=>'email','key'=>'encryption','value'=>'ssl'],
            ['type'=>'email','key'=>'from_address','value'=>'saintkabyo@gmail.com'],
            ['type'=>'email','key'=>'from_name','value'=>'Ojolie'],
            ['type'=>'contact_us','key'=>'contact_us_email','value'=>'saintkabyo@gmail.com'],
        ];

        foreach($info as $row)
        {
            $configuration = new Configuration;
            $configuration->type = $row['type'];
            $configuration->key = $row['key'];
            $configuration->value = $row['value'];
            $configuration->save();            
        }
    }
}