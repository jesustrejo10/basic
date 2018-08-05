<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->EmptyTables([
            'countries'
        ]);
        $this->call(CountrySeeder::class);
        $this->call(VenezuelanBankSeeder::class);

    }

    public function EmptyTables(array $tables): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;'); // Desactivamos la revisión de claves foráneas
        foreach ($tables as $table){
            DB::table($table)->truncate();

        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;'); // Reactivamos la revisión de claves foráneas        // $this->call(UsersTableSeeder::class);
    }
}
