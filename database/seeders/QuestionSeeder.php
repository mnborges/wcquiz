<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;

function generateScoresWithCodes($exclude, $value, $codes)
{
    $score_arr = ["%" . $codes[0] . "% " . $exclude . " %" . $codes[1] . "%"];
    do {
        $score = "%" . $codes[0] . "% " . strval(rand(0, 5)) . ' x ' . strval(rand(0, 5)) . " %" . $codes[1] . "%";
        if (!in_array($score, $score_arr)) {
            array_push($score_arr, $score);
            $value--;
        }
    } while ($value > 1);
    return $score_arr;
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
    shuffle($score_arr);
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
        // $replace = "<img src='\${1}.jpg'>"
        // $pattern = '/%(\w{3})%/'
        // Load matches from API
        $matches = json_decode(file_get_contents("https://worldcupjson.net/matches"), true);
        // Filter completed matches
        $completed_matches = array_filter($matches, function ($var) {
            return $var["status"] == "completed";
        });

        $type1 = "In the match %code1% %team1%  vs. %team2% %code2% that occurred in %stage%, what was the final score?";
        $type2 = "In the match between %code1% %team1% and %code2% %team2% that occurred in %stage%, which team won?";
        $type3 = "True or False? %team1% played against %team2% in the %stage% and the result was %code1% %score% %code2%.";
        $type4 = "In the match between %code1% %team1% and %team2% %code2% that occurred in the %stage%, the %ternary% was %winner%.";

        $patterns = ["%code1%", "%code2%", "/%team1%/", "/%team2%/", "/%stage%/", "/%score%/", "/%ternary%/", "/%winner%/"];
        // Seed questions regarding game results
        foreach ($completed_matches as $m) {
            $score = $m["home_team"]["goals"] . " x " . $m["away_team"]["goals"];
            $replacements = [
                $m["home_team_country"],
                $m["away_team_country"],
                $m["home_team"]["name"],
                $m["away_team"]["name"],
                strtolower($m["stage_name"]),
                $score,
                $m["winner"] == "Draw" ? "result" : "winner",
                $m["winner"],
            ];

            $wrong_replacements = $replacements;
            $wrong_replacements[5] = generateScores($score, 2)[1];
            $wrong_replacements[6] = "winner";
            $wrong_replacements[7] = $m["winner"] == $m["home_team"]["name"] ? $m["away_team"]["name"] : $m["home_team"]["name"];
            $country_codes = [$m["home_team_country"], $m["away_team_country"]];

            // Check whether data is alrealy present in the table
            if (Question::where('api_key', $m["id"])->get()->first()) {
                continue;
            }
            // Otherwise populate DB
            Question::create([
                'type' => 1,
                'api_key' => $m["id"],
                'sentence' => preg_replace($patterns, $replacements, $type1),
                'answer' => "%" . $country_codes[0] . "% " . $score . " %" . $country_codes[1] . "%",
                "alternatives" => json_encode(generateScoresWithCodes($score, 3, $country_codes)),
            ]);
            Question::create([
                'type' => 2,
                'api_key' => $m["id"],
                'sentence' => preg_replace($patterns, $replacements, $type2),
                'answer' => $m["winner"] == "Draw" ? "Draw" : "%" . $m["winner_code"] . "% " . $m["winner"],
                "alternatives" => json_encode(["Draw", "%" . $country_codes[0] . "% " . $m["home_team"]["name"], "%" . $country_codes[1] . "% " . $m["away_team"]["name"]]),
            ]);
            Question::create([
                'type' => 3,
                'api_key' => $m["id"],
                'sentence' => preg_replace($patterns, $replacements, $type3),
                'answer' => "True",
                "alternatives" => json_encode(["True", "False"]),
            ]);
            Question::create([
                'type' => 3,
                'api_key' => $m["id"],
                'sentence' => preg_replace($patterns, $wrong_replacements, $type3),
                'answer' => "False",
                "alternatives" => json_encode(["True", "False"]),
            ]);
            Question::create([
                'type' => 4,
                'api_key' => $m["id"],
                'sentence' => preg_replace($patterns, $replacements, $type4),
                'answer' => "True",
                "alternatives" => json_encode(["True", "False"]),
            ]);
            Question::create([
                'type' => 4,
                'api_key' => $m["id"],
                'sentence' => preg_replace($patterns, $wrong_replacements, $type4),
                'answer' => "False",
                "alternatives" => json_encode(["True", "False"]),
            ]);

        }
    }
}