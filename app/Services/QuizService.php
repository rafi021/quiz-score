<?php

namespace App\Services;

use App\Models\Quiz;

final class QuizService
{
    public function allPaginate($request, $perPage)
    {

        $orderColumn = request('order_column', 'quiz_date');
        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderColumn, ['id', 'title', 'quiz_date', 'subject_name'])) {
            $orderColumn = 'quiz_date';
        }
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }

        return Quiz::query()
            ->orderBy($orderColumn, $orderDirection)
            ->paginate($perPage);
    }
    public function all($request)
    {
        return Quiz::query()
            ->select('id', 'title')
            ->get();
    }
    public function store($request)
    {
        return Quiz::create([
            'title' => $request->title,
            'subject_name' => $request->subject_name,
            'quiz_date' => $request->quiz_date,
            'total_mark' => $request->total_mark,
            'pass_mark' => $request->pass_mark,
        ]);
    }

    public function update($request, $id)
    {
        return $this->show($id)->update([
            'title' => $request->title,
            'subject_name' => $request->subject_name,
            'quiz_date' => $request->quiz_date,
            'total_mark' => $request->total_mark,
            'pass_mark' => $request->pass_mark,
        ]);
    }

    public function show($id)
    {
        $quiz = Quiz::with(['questions'])->find($id);
        return $quiz;
    }

    public function delete($request, $id)
    {
        return $this->show($id);
    }
}
