<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;

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

        // Seed questions regarding game results
        foreach ($completed_matches as $m) {
            //$team1 = "<img src='flags/ " . $m["home_team"]["country"] . ".jpg" . "'>" . $m["home_team"]["name"];
            // Check whether data is alrealy present in the table
            if (Question::where('api_key', $m["id"])->get()->first()) {
                continue;
            }
            // Otherwise populate DB
            $score = $m["home_team"]["goals"] . " x " . $m["away_team"]["goals"];
            Question::create([
                'type' => 1,
                'api_key' => $m["id"],
                'sentence' => "In the match " . $m["home_team"]["name"] . " vs. " . $m["away_team"]["name"] . " that occurred in " . strtolower($m["stage_name"]) . ", what was the final score?",
                'answer' => $score,
                "alternatives" => json_encode(generateScores($score, 3)),
            ]);
            Question::create([
                'type' => 2,
                'api_key' => $m["id"],
                'sentence' => "In the match between " . $m["home_team"]["name"] . " and " . $m["away_team"]["name"] . " that occurred in " . strtolower($m["stage_name"]) . ", which team won?",
                'answer' => $m["winner"],
                "alternatives" => json_encode(["Draw", $m["home_team"]["name"], $m["away_team"]["name"]])
            ]);
            Question::create([
                'type' => 3,
                'api_key' => $m["id"],
                'sentence' => "True or False? " . $m["home_team"]["name"] . " played against " . $m["away_team"]["name"] . " in the " . strtolower($m["stage_name"]) . " and the result was " . $score . ".",
                'answer' => "True",
                "alternatives" => json_encode(["True", "False"]),
            ]);
            $wrong_result = generateScores($score, 2)[1];
            Question::create([
                'type' => 3,
                'api_key' => $m["id"],
                'sentence' => "True or False? " . $m["home_team"]["name"] . " played against " . $m["away_team"]["name"] . " in the " . strtolower($m["stage_name"]) . " and the result was " . $wrong_result . ".",
                'answer' => "False",
                "alternatives" => json_encode(["True", "False"]),
            ]);
            Question::create([
                'type' => 4,
                'api_key' => $m["id"],
                'sentence' => "In the match between " . $m["home_team"]["name"] . " and " . $m["away_team"]["name"] . " that occurred in the " . strtolower($m["stage_name"]) . ", the " . $m["winner"] == "Draw" ? "result" : "winner" . " was " . $m["winner"],
                'answer' => "True",
                "alternatives" => json_encode(["True", "False"]),
            ]);
            $wrong_result = $m["winner"] == $m["home_team"]["name"] ? $m["away_team"]["name"] : $m["home_team"]["name"];
            Question::create([
                'type' => 4,
                'api_key' => $m["id"],
                'sentence' => "In the match between " . $m["home_team"]["name"] . " and " . $m["away_team"]["name"] . " that occurred in the " . strtolower($m["stage_name"]) . ", the winner was " . $wrong_result,
                'answer' => "False",
                "alternatives" => json_encode(["True", "False"]),
            ]);

        }
        // $team1 = "Brazil";
        // $team2 = "Korea Republic";
        // $stage = "Round of 16";
        // $score = "4 x 1";
        // Question::create([
        //     'type' => 1,
        //     'api_key' => -1,
        //     'sentence' => "Regarding the match " . $team1 . " vs " . $team2 . " that occurred in " . strtolower($stage) . ", what was the final score?",
        //     'answer' => $score,
        //     "alternatives" => json_encode(generateScores($score, 5)),
        // ]);
        // Question::create([
        //     'type' => 2,
        //     'api_key' => -1,
        //     'sentence' => "In the match between " . $team1 . " and " . $team2 . " that occurred in " . strtolower($stage) . ", which team won?",
        //     'answer' => $team1,
        //     "alternatives" => json_encode(["None", $team1, $team2])
        // ]);
        // Question::create([
        //     'type' => 3,
        //     'api_key' => -1,
        //     'sentence' => "True or False? " . $team2 . " played against " . $team1 . " in the " . strtolower($stage) . " and the result was " . $score . ".",
        //     'answer' => "True",
        //     "alternatives" => json_encode(["True", "False"]),
        // ]);
    }
}