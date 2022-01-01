<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\QuestionTags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function show($id)
    {
        $question = Question::find($id);
        return view('pages.question', ['question' => $question]);
    }

    public function browse()
    {
        $new_questions = Question::orderBy('created_at', 'desc')->limit(10)->get();
        $top_questions = Question::withCount('likes')->orderBy('likes_count', 'desc')->limit(10)->get();
        return view('pages.questions', ['new_questions' => $new_questions, 'top_questions' => $top_questions]);
    }

    public function show_create()
    {
        return view('pages.new-question');
    }

    protected function create_question(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|string|min:10',
            'content' => 'required|string|min:10',
        ]);

        $questionCreated = Question::create([
            'user_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        $tagName = $request->input('tags');
        // dd($tagName);

        if ($tagName != null) {
            $existsTag = Tag::where('name', $tagName)->first();

            if ($existsTag) {

                QuestionTags::create([
                    'question_id' => $questionCreated->id,
                    'tag_id' => $existsTag->id,
                ]);

            } else {

                $createdTag = Tag::create(['name' => $tagName,]);

                QuestionTags::create([
                    'question_id' => $questionCreated->id,
                    'tag_id' => $createdTag->id,
                ]);
            }
        }

        return redirect('questions/' . $questionCreated->id);
    }

    public function acceptAnswer(Question $question, Answer $answer)
    {
        $this->authorize('accept', [$question, $answer]);

        $question->acceptedAnswer()->associate($answer);
        $question->save();

        return back();
    }

    public function review(Request $request, Question $question, string $type)
    {
        if ($question->reviewedBy($request->user())) {
            $this->unreview($request, $question);
        }

        $question->reviews()->create([
            'user_id' => $request->user()->id,
            'type' => $type,
        ]);

        return back();
    }

    public function unreview(Request $request, Question $question)
    {
        $request->user()->questionReviews()->where('question_id', $question->id)->delete();
        return back();
    }

    public function delete($id)
    {
        $question = Question::find($id);

        $question->delete();
        return view('pages.home');
    }

    public function editQuestion( Question $question)
    {
        return view('pages.edit-question', ['question' => $question]);
    }
    
    protected function updateQuestion(Request $request, Question $question)
    {
        $this->validate($request, [
            'title' => 'required|string|min:10',
            'content' => 'required|string|min:10',
        ]);

        $question->title = $request->get('title');
        $question->content = $request->get('content');


        $question->save();

        return view('pages.question', ['question' => $question]);
    }
}
