<?php

use App\Models\GooglePlayStoreCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $gplay = new \Nelexa\GPlay\GPlayApps($defaultLocale = 'en_US', $defaultCountry = 'us');
        $appInfo = $gplay->getCategories();
        foreach ($appInfo as $index => $item) {
            if (preg_match('/GAME/', $item->getId())){
                if (!GooglePlayStoreCategory::where('code', $item->getId())->first()){
                    GooglePlayStoreCategory::create([
                        'category' => $item->getName(),
                        'code' => $item->getId()
                ]);
                }
            }
        }

    }
}
