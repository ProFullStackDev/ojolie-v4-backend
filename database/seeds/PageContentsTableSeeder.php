<?php

use Illuminate\Database\Seeder;
use App\PageContent;

class PageContentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $info = [
            ['page_id'=>1,'type'=>'image','name'=>'main_banner','content'=>'']
        ];

        foreach($info as $row)
        {
            $content = new PageContent;
            $content->page_id = $row['page_id'];
            $content->type = $row['type'];
            $content->name = $row['name'];
            $content->content = $row['content'];
            $content->save();
        }
    }
}
