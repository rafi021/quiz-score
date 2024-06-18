<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\QuizService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuizRequest;

class QuizController extends Controller
{
    use ApiResponse;
    public function __construct(
        private QuizService $quizService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function all(Request $request)
    {
        $data = $this->quizService->all($request);
        $metadata['count'] = count($data);
        if (!$data) {
            return $this->ResponseSuccess([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    public function index(Request $request)
    {
        $perPage = request('per_page') ?? 10;
        $data = $this->quizService->allPaginate($request, $perPage);
        $metadata['count'] = count($data);
        if (!$data) {
            return $this->ResponseSuccess([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data, $metadata);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->quizService->store($request);
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
        $data = $this->quizService->show($id);
        if (!$data) {
            return $this->ResponseSuccess([], null, 'No Data Found!');
        }
        return $this->ResponseSuccess($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreQuizRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $data = $this->quizService->update($request, $id);
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
            $data = $this->quizService->delete($request, $id);
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
