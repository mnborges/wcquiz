<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;

function generateAlternatives($exclude, $max, $value)
{
    $arr = [$exclude];
    do {
        $score = rand(0, $max);
        if (!in_array($score, $arr)) {
            array_push($arr, $score);
            $value--;
        }
    } while ($value > 1);
    return $arr;
}
function generateScores($exclude, $value)
{
    $score_arr = [$exclude];
    do {
        $score = strval(rand(0, 5)) . ' x ' . strval(rand(0, 5));
        if (!in_array($score, $score_arr)) {
            array_push($score_arr, $score);
            $value--;
        }
    } while ($value > 1);
    return $score_arr;
}
class QuestionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load matches from API
        $matches = json_decode(file_get_contents("https://worldcupjson.net/matches"), true);
        // Filter completed matches
        $completed_matches = array_filter($matches, function ($var) {
            return $var["status"] == "completed";
        });
        // Load team data from API
        $result = json_decode(file_get_contents("https://worldcupjson.net/teams"), true);
        // Transform teams data
        $teams = [];
        foreach ($result["groups"] as $k => $v) {
            array_push($teams, $v["teams"]);
        }
        $teams = $teams[0];

        // Seed questions regarding game results
        foreach ($completed_matches as $m) {
            // Check whether data is alrealy present in the table
            if (Question::where('api_key', $m["id"])->get()) {
                continue;
            }
            // Otherwise populate DB
            $score = $m["home_team"]["goals"] . " x " . $m["away_team"]["goals"];
            Question::create([
                'type' => 1,
                'api_key' => $m["id"],
                'sentence' => "Regarding the match " . $m["home_team"]["name"] . " vs " . $m["away_team"]["name"] . " that occurred in " . strtolower($m["stage_name"]) . ", what was the final score?",
                'answer' => $score,
                "alternatives" => json_encode(generateScores($score, 5)),
            ]);
            Question::create([
                'type' => 2,
                'api_key' => $m["id"],
                'sentence' => "In the match between " . $m["home_team"]["name"] . " and " . $m["away_team"]["name"] . " that occurred in " . strtolower($m["stage_name"]) . ", which team won?",
                'answer' => $m["winner"],
                "alternatives" => json_encode(["None", $m["home_team"]["name"], $m["away_team"]])
            ]);
            Question::create([
                'type' => 3,
                'api_key' => $m["id"],
                'sentence' => "True or False? " . $m["home_team"]["name"] . " played against " . $m["away_team"] . " in the " . strtolower($m["stage_name"]) . " and the result was " . $score . ".",
                'answer' => "True",
                "alternatives" => json_encode(["True", "False"]),
            ]);
            Question::create([
                'type' => 3,
                'api_key' => $m["id"],
                'sentence' => "True or False? " . $m["home_team"]["name"] . " played against " . $m["away_team"] . " in the " . strtolower($m["stage_name"]) . " and the result was " . generateScores($score, 1)[1] . ".",
                'answer' => "False",
                "alternatives" => json_encode(["True", "False"]),
            ]);

        }
        foreach ($teams as $t) {
            $on_db_4 = Question::where('api_key', $t["country"])->where('type', 4)->get();
            if ($on_db_4) {
                $on_db_4->each->update([
                    'sentence' => $t["name"] . " played " . $t["games_played"] . " games in the tournment. How many did it win?",
                    'answer' => $t["wins"],
                    'alternatives' => json_encode(generateAlternatives($t["wins"], 3, $t["games_played"])),
                ]);
            } else {
                Question::create([
                    'type' => 4,
                    'api_key' => $t["country"],
                    'sentence' => $t["name"] . " played " . $t["games_played"] . " games in the tournment. How many did it win?",
                    'answer' => $t["wins"],
                    'alternatives' => json_encode(generateAlternatives($t["wins"], 3, $t["games_played"])),
                ]);
            }
        }
        $team1 = "Brazil";
        $team2 = "Korea Republic";
        $stage = "Round of 16";
        $score = "4 x 1";
        Question::create([
            'type' => 1,
            'api_key' => -1,
            'sentence' => "Regarding the match " . $team1 . " vs " . $team2 . " that occurred in " . strtolower($stage) . ", what was the final score?",
            'answer' => $score,
            "alternatives" => json_encode(generateScores($score, 5)),
        ]);
        Question::create([
            'type' => 2,
            'api_key' => -1,
            'sentence' => "In the match between " . $team1 . " and " . $team2 . " that occurred in " . strtolower($stage) . ", which team won?",
            'answer' => $team1,
            "alternatives" => json_encode(["None", $team1, $team2])
        ]);
        Question::create([
            'type' => 3,
            'api_key' => -1,
            'sentence' => "True or False? " . $team2 . " played against " . $team1 . " in the " . strtolower($stage) . " and the result was " . $score . ".",
            'answer' => "True",
            "alternatives" => json_encode(["True", "False"]),
        ]);
    }
}