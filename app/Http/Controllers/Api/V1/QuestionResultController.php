<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizResult;
use App\Services\QuestionService;
use App\Services\QuizService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class QuestionResultController extends Controller
{
    use ApiResponse;
    public function __construct(
        private QuizService $quizService,
        private QuestionService $questionService
    ) {
    }

    public function attendQuiz(Request $request, $quizId)
    {
        $user = $request->user();
        /* Check this user already attended quiz of not */
        $result = QuizResult::where(['user_id' => $user->id, 'quiz_id' => $quizId])->first();
        if ($result instanceof QuizResult) {
            return $this->ResponseError($result, message: 'You have already attended this quiz');
        }


        $quiz = $this->quizService->show($quizId);
        if (!$quiz instanceof Quiz) {
            return $this->ResponseError('', message: 'Quiz not found');
        }
        // Now eager load questions
        $quiz->load('questions');

        $score = 0;
        $right_answer = 0;
        $wrong_answer = 0;

        foreach ($quiz->questions as $question) {
            if ($question->correct_answer === $request->input('answers.' . $question->id)) {
                $right_answer++;
                $score++;
            } else {
                $score--;          // negative mark for wrong answer
                $wrong_answer++;  // wrong answer count
            }
        }

        $result = QuizResult::create([
            'user_id' => $request->user()->id,
            'quiz_id' => $quizId,
            'score' => $score,
            'right_answer' => $right_answer,
            'wrong_answer' => $wrong_answer,
        ]);

        $result['question_count'] = count($quiz->questions);
        return $this->ResponseSuccess($result);
    }

    public function getResults(Request $request, $quizId)
    {
        $user = $request->user();

        $orderColumn = request('order_column', 'score');
        $orderDirection = request('order_direction', 'desc');
        if (!in_array($orderColumn, ['id', 'score', 'created_at'])) {
            $orderColumn = 'score';
        }
        if (!in_array($orderDirection, ['asc', 'desc'])) {
            $orderDirection = 'desc';
        }

        if ($user->is_admin) {
            $results = QuizResult::where(['quiz_id' => $quizId])
                ->with(['quiz:id,title,subject_name,quiz_date', 'student:id,name,email'])
                ->orderBy($orderColumn, $orderDirection)
                ->get();
        } else {
            $results = QuizResult::where(['quiz_id' => $quizId, 'user_id' => $user->id])
                ->with(['quiz:id,title,subject_name,quiz_date', 'student:id,name,email'])
                ->orderBy($orderColumn, $orderDirection)
                ->get();
        }

        return $this->ResponseSuccess($results);
    }
}
