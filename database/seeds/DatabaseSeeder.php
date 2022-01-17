<?php

use Illuminate\Database\Seeder;
use App\Ecard;
use App\EcardToCategory;
// use Illuminate\Foundation\Testing\RefreshDatabase;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    // use RefreshDatabase;

    public function run()
    {
        factory(Ecard::class,25)->create();
        // factory(EcardToCategory::class,25)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigurationsTableSeeder::class);
        $this->call(ReferencesTableSeeder::class);
        $this->call(SubscriptionTypesTableSeeder::class);
        $this->call(PricesTableSeeder::class);
        $this->call(EcardCategoriesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
    }
}
