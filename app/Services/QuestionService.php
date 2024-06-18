<?php

namespace App\Services;

use App\Models\QuestionBank;

class QuestionService
{
    public function allPaginate($request, $perPage)
    {
        $orderColumn = request('order_column', 'created_at');
        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderColumn, ['id', 'title', 'created_at'])) {
            $orderColumn = 'created_at';
        }
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }

        return QuestionBank::query()
            ->when($request->quiz_id, function ($query) use ($request) {
                $query->where(['quiz_id' => $request->quiz_id]);
            })
            ->with(['quiz:id,title'])
            ->orderBy($orderColumn, $orderDirection)
            ->paginate($perPage);
    }
    public function all($request)
    {
        return QuestionBank::query()
            ->when($request->quiz_id, function ($query) use ($request) {
                $query->where(['quiz_id' => $request->quiz_id]);
            })
            ->select('id', 'question')
            ->get();
    }
    public function store($request)
    {
        $quiz = (new QuizService())->show($request->quiz_id);
        $question = QuestionBank::create([
            'quiz_id' =>$request->quiz_id,
            'question' => $request->question,
            'correct_answer' => $request->correct_answer,
            'options' =>$request->options,
        ]);
        return $question;
    }

    public function update($request, $id)
    {
        $question = $this->show($id);
        $question->update([
            'quiz_id' => $request->quiz_id,
            'question' => $request->question,
            'correct_answer' => $request->correct_answer,
            'options' => $request->options,
        ]);
        return $question;
    }

    public function show($id)
    {
        return QuestionBank::findOrFail($id);
    }

    public function delete($request, $id)
    {
        return $this->show($id);
    }
}
