<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ComputeResult extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request)
    {

        $answers = $request->collect()->except(["_token"]);
        $correct = $answers->filter(function ($v, $k) {
            $q = Question::where('id', $k)->get()->first();
            if (!$q)
                Log::error(strval($k) . " key not found.");
            return $q["answer"] == $v;
        });
        return view('question', ["correct" => $correct, "answers" => $answers, "questions" => null]);
    }
}