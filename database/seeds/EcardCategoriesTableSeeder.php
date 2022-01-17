<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\EcardCategory;

class EcardCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $info = [
            ['parent_id'=>null,'name'=>'HOLIDAYS'],
            ['parent_id'=>null,'name'=>'OCCASIONS'],
            ['parent_id'=>null,'name'=>'COLLECTIONS'],
            ['parent_id'=>1,'name'=>'HALLOWEEN ECARDS'],
            ['parent_id'=>1,'name'=>'THANKSGIVING ECARD'],
            ['parent_id'=>1,'name'=>'SAUTUMN/FALL ECARDS'],
            ['parent_id'=>1,'name'=>'NEW YEAR ECARDSCHRISTMAS ECARDS'],
            ['parent_id'=>2,'name'=>'BIRTHDAY ECARDS'],
            ['parent_id'=>2,'name'=>'THINKING OF YOU ECARDS'],
            ['parent_id'=>2,'name'=>'LOVE ECARDS'],
            ['parent_id'=>2,'name'=>'ANNIVERSARY & WEDDING ECARDS'],
            ['parent_id'=>2,'name'=>'THANK YOU ECARDS'],
            ['parent_id'=>2,'name'=>'SYMPATHY ECARDS'],
            ['parent_id'=>2,'name'=>'FRIENDSHIP ECARDS'],
            ['parent_id'=>2,'name'=>'CONGRATULATIONS ECARDS'],
            ['parent_id'=>2,'name'=>'NEW BABY ECARDS'],
            ['parent_id'=>3,'name'=>'CAUSES ECARDS'],
            ['parent_id'=>3,'name'=>'FLOWERS ECARDS'],
            ['parent_id'=>3,'name'=>'DOGS & CATS ECARDS'],
            ['parent_id'=>3,'name'=>'ECARDS FOR CHILDREN'],
            ['parent_id'=>3,'name'=>'ECARDS FOR MEN'],
            ['parent_id'=>3,'name'=>'ECARDS FOR WOMEN'],
            ['parent_id'=>3,'name'=>'ORIGAMI ECARDS'],
            ['parent_id'=>3,'name'=>'BIRDS ECARDS'],
            ['parent_id'=>3,'name'=>'WILDLIFE ECARDS']
        ];

        foreach($info as $row)
        {
            $category = new EcardCategory;
            $category->parent_id = $row['parent_id'];
            $category->name = $row['name'];
            $category->slug = Str::of($row['name'])->slug('-');
            $category->header_image = 'https://www.ojolie.com/cards/resource/picture/All/new_year_ecards_header.jpg';
            $category->header_color = '#BCC6CC';
            $category->header_descripion = 'Ecard Category Header Descriptiopn';
            $category->page_title = 'Ecard Category Page Title Tag';
            $category->page_description = 'Ecard Category Page Description';
            $category->meta_keyword = 'Meta KeyWord';
            $category->save();
        }
    }
}