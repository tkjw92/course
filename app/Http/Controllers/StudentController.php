<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StudentController extends Controller
{
    public function index()
    {
        $course = DB::table('course')->get();
        $topic = DB::table('topics')->get();
        return view('user.index', ['courses' => $course, 'count' => $topic, 'name' => collect(session('account'))->get('name')]);
    }

    public function course($id_course, $id_subtopic = null)
    {
        if ($id_subtopic == null) {
            $id_subtopic = DB::table('subtopics')
                ->where(
                    'id_topic',
                    DB::table('topics')
                        ->where('id_course', $id_course)
                        ->first('id')->id,
                )
                ->first('id')->id;
        }
        $topic = DB::table('topics')
            ->where('id_course', $id_course)
            ->get();
        $subtopics = collect(DB::table('subtopics')->get());
        $content = base64_decode(
            DB::table('contents')
                ->where('id_subtopic', $id_subtopic)
                ->first('content')->content,
        );
        $quiz = DB::table('quiz')->get();
        $score = DB::table('quizScore')
            ->get()
            ->where(
                'id_user',
                DB::table('account')
                    ->where('email', session('account')['email'])
                    ->first()->id,
            );

        $certificate = DB::table('certificate')->where('id_course', $id_course)->where('id_user', session('account')['id']);

        if ($certificate->first() == null) {
            DB::table('certificate')->insert([
                'signature' => uniqid(),
                'id_user' => session('account')['id'],
                'id_course' => $id_course,
                'name' => ucwords(session('account')['name']),
                'course' => DB::table('course')->where('id', $id_course)->first()->name,
                'url' => null
            ]);
        }

        $certificateApi = DB::table('certificateApi')->where('id_course', $id_course)->first();

        if ($certificate->first()->url == 'temp') {
            $response = Http::post($certificateApi->get_api, [
                'signature' => $certificate->first()->signature
            ])->body();

            $certificate->update([
                'url' => $response
            ]);
        }

        if (
            DB::table('certificateApi')->where('id_course', $id_course)->first() == null
        ) {
            return view('user.course', [
                'name' => collect(session('account'))->get('name'),
                'topics' => $topic,
                'id_course' => $id_course,
                'subtopics' => $subtopics,
                'content' => $content,
                'quiz' => collect($quiz),
                'score' => $score,
                'certificate' => $certificate->first()
            ]);
        }


        return view('user.course', [
            'name' => collect(session('account'))->get('name'),
            'topics' => $topic,
            'id_course' => $id_course,
            'subtopics' => $subtopics,
            'content' => $content,
            'quiz' => collect($quiz),
            'score' => $score,
            'api' => $certificateApi->submit_api,
            'certificate' => $certificate->first()
        ]);
    }
}
