<?php

use Illuminate\Database\Seeder;
use App\Ecard;

class EcardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $is_private = [0,1];
        $types = [1,2];
        $categories = [
                        [4=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)]],
                        [4=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],5=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],6=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)]],
                        [7=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],10=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)]],
                        [15=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)]],
                        [6=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],7=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],8=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)]],
                        [9=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],10=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],11=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],12=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],13=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)],14=>['type'=>$types[array_rand($types)],'sort'=>rand(1,100)]]
                    ];

        for($i=1; $i<=100; $i++)
        {
            $ecard = new Ecard;
            $ecard->private = array_rand($is_private);
            $ecard->filename = 'LITTLEWITCH01.jpg';
            $ecard->thumbnail = 'LITTLEWITCH01P.jpg';
            $ecard->caption = 'Card Caption '.$i;
            $ecard->detail = 'This is card details text, '.$i.'.';
            $ecard->video = 'VIDEOID';
            $ecard->save();

            $ecard->ecardcategories()->sync($categories[array_rand($categories)]);
        }
    }
}
