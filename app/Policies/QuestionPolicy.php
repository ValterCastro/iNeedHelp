<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    public function accept(User $user, Question $question, Answer $answer)
    {
        return $user->id === $question->user_id && $answer->question->id === $question->id;
    }

    public function update(User $user, Question $question)
    {
        // dd($user);
        return $user->id === $question->user_id;
    }
}
