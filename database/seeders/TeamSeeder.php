<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::truncate();
  
        $csvFile = fopen(base_path("database/data/teams.csv"), "r");
  
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                Team::create([
                    "name" => ucfirst($data['0']),
                    "code" => $data['1'],
                    "group" => $data['2'],
                ]);    
            }
            $firstline = false;
        }
   
        fclose($csvFile);
    }
}
