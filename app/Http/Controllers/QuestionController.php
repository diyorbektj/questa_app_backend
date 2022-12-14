<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionRequest;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(CreateQuestionRequest $request): JsonResponse
    {
        $question = Question::query()->create([
            'title' => $request->title,
            'A' => $request->A,
            'B' => $request->B,
            'C' => $request->C,
            'D' => $request->D,
            'answer' => $request->answer,
            'category_id' => $request->category_id,
            'user_id' => auth('sanctum')->id(),
        ]);
        return response()->success($question);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $questions = Question::query()->where('category_id', $id)->inRandomOrder()->limit(10)->get();
        return response()->success($questions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkAnswer(Request $request)
    {
        $question = Question::query()->find($request->id);
           if ($question){
               $answer = $question->where('id', $request->id)->where('answer', $request->answer)->first();
               $check = QuestionAnswer::query()->create([
                   'user_id' => auth('sanctum')->id(),
                   'question_id' => $question->id,
                   'answer' => $request->answer,
                   'is_true' => (bool)$answer,
               ]);
           }
        return $question ? response()->success($check) : response()->error("Not found");
    }
}
