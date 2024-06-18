<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\QuizService;
use App\Services\QuestionService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\StoreQuestionRequest;

class QuestionController extends Controller
{
    use ApiResponse;
    public function __construct(
        private QuizService $quizService,
        private QuestionService $questionService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function all(Request $request)
    {
        $data = $this->questionService->all($request);
        $metadata['count'] = count($data);
        if (!$data) {
            return $this->ResponseSuccess([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    public function index(Request $request)
    {
        $perPage = request('per_page');
        $data = $this->questionService->allPaginate($request, $perPage);
        $metadata['count'] = count($data);
        if (!$data) {
            return $this->ResponseSuccess([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $data = $this->questionService->store($request);
            DB::commit();
            return $this->ResponseSuccess($data);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->ResponseError($e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine(), null, 'Data Process Error! Consult Tech Team');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->questionService->show($id);
        if (!$data) {
            return $this->ResponseSuccess([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreQuestionRequest $request, string $id)
    {
        DB::beginTransaction();
        $quiz = $this->quizService->show($request->quiz_id);
        if (!$quiz) {
            return $this->ResponseSuccess([], null, 'Quiz Not Found!', 200);
        }
        try {
            $data = $this->questionService->update($request, $id);
            DB::commit();
            return $this->ResponseSuccess($data);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->ResponseError($e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine(), null, 'Data Process Error! Consult Tech Team');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $data = $this->questionService->delete($request, $id);
            if (!$data) {
                return $this->ResponseSuccess([], null, 'Data Not Found!', 204);
            }
            $data->delete();
            DB::commit();
            return $this->ResponseSuccess($data, null, 'Data successfully delete!', 204);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->ResponseError($e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine(), null, 'Data Not Found!');
        }
    }
}
