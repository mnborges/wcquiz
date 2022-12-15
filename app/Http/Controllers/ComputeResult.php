<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ComputeResult extends Controller
{
    /**
     * Handle the incoming POST request.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Request $request)
    {
        // Collect answers submitted through the form
        $answers = $request->collect()->except(["_token"]);
        // Create collection with only correct answers
        $correct = $answers->filter(function ($v, $k) {
            $q = Question::where('id', $k)->get()->first();
            if (!$q)
                Log::error(strval($k) . " key not found.");
            return $q["answer"] == $v;
        });
        return view('question', ["correct" => $correct, "answers" => $answers, "questions" => null]);
    }
}