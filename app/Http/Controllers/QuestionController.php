<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        array(
            1 => [
                "sentence" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                "alternatives" => [
                    "1" => "Lorem ipsum dolor",
                    "2" => "sit amet, consectetur adipiscing elit",
                    "3" => "sed do eiusmod tempor incididunt",
                ]

            ],
            2 => [
                "sentence" => "Urna nec tincidunt praesent semper feugiat nibh sed pulvinar. Mauris a diam maecenas sed enim ut sem viverra aliquet.",
                "alternatives" => [
                    "1" => "Viverra justo nec ultrices",
                    "2" => "Senectus et netus et malesuada fames ac",
                    "3" => "Odio pellentesque diam",
                ]

            ],
            3 => [
                "sentence" => "Mi eget mauris pharetra et ultrices neque ornare aenean euismod.",
                "alternatives" => [
                    "1" => "Enim nunc faucibus a pellentesque",
                    "2" => "Euismod nisi porta lorem mollis aliquam ut porttitor",
                    "3" => "Odio eu feugiat pretium nibh",
                ]

            ]
        );
        $questions = [];
        array_push($questions, Question::where("type", 1)->inRandomOrder()->first());
        array_push($questions, Question::where("type", 2)->inRandomOrder()->first());
        array_push($questions, Question::where("type", 3)->inRandomOrder()->first());


        return view('question', ["questions" => $questions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}