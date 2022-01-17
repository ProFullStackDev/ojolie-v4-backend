<?php

use Illuminate\Database\Seeder;
use App\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $info = [
            ['name'=>'home','title'=>'Home','description'=>'Home Description','keywords'=>'keywords,here'],
            ['name'=>'about','title'=>'About','description'=>'About Description','keywords'=>'keywords,here'],
            ['name'=>'contact','title'=>'Contact US','description'=>'Contact Description','keywords'=>'keywords,here'],
            ['name'=>'faq','title'=>'FAQ','description'=>'FAQ Description','keywords'=>'keywords,here'],
            ['name'=>'privacy','title'=>'Privacy','description'=>'Privacy Description','keywords'=>'keywords,here'],
            ['name'=>'terms','title'=>'Terms & Condition','description'=>'Terms & Condition Description','keywords'=>'keywords,here']
        ];

        foreach($info as $row)
        {
            $page = new Page;
            $page->name = $row['name'];
            $page->title = $row['title'];
            $page->description = $row['description'];
            $page->keywords = $row['keywords'];
            $page->save();

        }
    }
}
