<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MainModuleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Schema::hasTable('mastermodels')) {
            Schema::create('mastermodels', function ($table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        // Use updateOrInsert to ensure IDs and names are set correctly
        $modules = [
            1 => 'Country Management',
            2 => 'State Management',
            3 => 'City Management',
            4 => 'Area Management',
            5 => 'Address Book Management',
        ];

        DB::table('mastermodels')->whereNotIn('id', array_keys($modules))->delete();

        foreach ($modules as $id => $name) {
            DB::table('mastermodels')->updateOrInsert(
                ['id' => $id],
                [
                    'name' => $name,
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
