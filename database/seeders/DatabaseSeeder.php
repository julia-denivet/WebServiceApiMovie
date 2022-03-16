<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();
        //$this->call([]);

        collect([
            [
                'name' => 'Action',
            ],
            [
                'name' => 'Horreur',
            ],
            [
                'name' => 'Science Fiction',
            ],
            [
                'name' => 'Drame',
            ],

            [
                'name' => 'Animation',
            ],

        ])->each(function ($category, $index) {
            $id = DB::table('categories')->insertGetId([
                'name' => $category["name"],
                'created_at' => Carbon::now(),
            ]);
        });



        collect([
            [
                'name' => 'Captain America',
                'description' => 'Film avec Chris Evans',
                'note' => 4

            ],
            [
                'name' => 'Vendredi 13',
                'description' => 'Jason Voorhees',
                'note' => 3
            ],
            [
                'name' => 'E.T',
                'description' => 'E.T télephone maison',
                'note' => 4
            ],
            [
                'name' => 'La Ligne Verte',
                'description' => 'John Coffee accusé à mort, nous suivons la fin de sa vie dans le couloir de la mort.',
                'note' => 5
            ],

            [
                'name' => 'Toy Story',
                'description' => 'Andy est un gosse gate. Buzz va lui remettre les points sur les i.',
                'note' => 5
            ],

        ])->each(function ($movie, $index) {
            $id = DB::table('movies')->insertGetId([
                'name' => $movie["name"],
                'description' => $movie["description"],
                'note' => $movie["note"],
                'created_at' => Carbon::now(),
            ]);

            $usedcategory = [];
            for ($i = 0; $i <= 2; $i++) {
                $category = rand(1, 5);
                if (!in_array($category, $usedcategory)) {
                    $pivotLine = DB::table('category_movie')->insertGetId([
                        'movie_id' => $id,
                        'category_id' => $category,
                        'created_at' => Carbon::now(),
                    ]);
                    $usedcategory[] = $category;
                }
            }
        });
    }
}
