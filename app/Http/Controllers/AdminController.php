<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function cleanTable($type, $id)
    {
        switch ($type) {
            case 'course':
                $topics = DB::table('topics')->where('id_course', $id);
                foreach ($topics->get() as $topic) {
                    $subtopics = DB::table('subtopics')->where('id_topic', $topic->id);
                    foreach ($subtopics->get() as $subtopic) {
                        DB::table('contents')
                            ->where('id_subtopic', $subtopic->id)
                            ->delete();
                    }
                    $subtopics->delete();
                }
                $topics->delete();
                DB::table('course')
                    ->where('id', $id)
                    ->delete();
                break;

            case 'topic':
                $subtopics = DB::table('subtopics')->where('id_topic', $id);
                foreach ($subtopics->get() as $subtopic) {
                    DB::table('contents')
                        ->where('id_subtopic', $subtopic->id)
                        ->delete();
                }
                $subtopics->delete();
                break;
        }
    }

    public function addCourse(Request $data)
    {
        $data->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // thumbnail name
        $imgName = time() . '.' . $data->thumbnail->extension();

        // save in storage
        $data->thumbnail->storeAs('public', $imgName);

        // input to database
        DB::table('course')->insert([
            'name' => $data->name,
            'thumbnail' => $imgName,
        ]);

        return back();
    }

    public function editCourse(Request $data, $id)
    {
        $data->validate([
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // thumbnail name
        $imgName = $data->thumbnailName;

        // save in storage
        $data->thumbnail->storeAs('public', $imgName);

        // input to database
        DB::table('course')
            ->where('id', $id)
            ->update([
                'name' => $data->name,
                'thumbnail' => $imgName,
            ]);

        return back();
    }

    public function getAllCourse()
    {
        $data = DB::table('course')->get();
        $topic = DB::table('topics')->get();
        return view('admin.index', ['courses' => $data, 'count' => $topic]);
    }

    public function deleteCourse($id)
    {
        if (
            unlink(
                storage_path(
                    'app/public/' .
                        collect(
                            DB::table('course')
                                ->where('id', $id)
                                ->first(),
                        )->get('thumbnail'),
                ),
            )
        ) {
            $this->cleanTable('course', $id);
            return redirect('/admin');
        }
    }

    public function manage($id)
    {
        $course = DB::table('course')
            ->where('id', $id)
            ->first();
        $topic = DB::table('topics')
            ->where('id_course', $id)
            ->get();
        $subtopic = DB::table('subtopics')->get();

        return view('admin.manage', ['course' => $course, 'topics' => $topic, 'subtopics' => $subtopic]);
    }

    public function addTopic(Request $data)
    {
        DB::table('topics')->insert([
            'id_course' => $data->idCourse,
            'name' => $data->name,
        ]);
        return back();
    }

    public function addSubtopic(Request $data)
    {
        DB::table('subtopics')->insert([
            'id_topic' => $data->idTopic,
            'name' => $data->name,
        ]);

        DB::table('contents')->insert([
            'id_subtopic' => DB::table('subtopics')
                ->where('id_topic', $data->idTopic)
                ->where('name', $data->name)
                ->get()
                ->first()->id,
        ]);

        return back();
    }

    public function deleteTopic($id)
    {
        $this->cleanTable('topic', $id);
        DB::table('topics')
            ->where('id', $id)
            ->delete();
        return back();
    }

    public function editTopic(Request $data, $id)
    {
        DB::table('topics')
            ->where('id', $id)
            ->update([
                'name' => $data->name,
            ]);

        return back();
    }

    public function deleteSubtopic($id)
    {
        DB::table('subtopics')
            ->where('id', $id)
            ->delete();
        DB::table('contents')
            ->where('id_subtopic', $id)
            ->delete();
        return back();
    }

    public function editContentView($id)
    {
        $title = DB::table('subtopics')
            ->where('id', $id)
            ->get()
            ->first()->name;
        $content = DB::table('contents')
            ->where('id_subtopic', $id)
            ->get()
            ->first()->content;
        return view('admin.content', ['id' => $id, 'title' => $title, 'content' => base64_decode($content)]);
    }

    public function editContent($id, Request $data)
    {
        DB::table('contents')
            ->where('id_subtopic', $id)
            ->update([
                'content' => $data->content,
            ]);

        DB::table('subtopics')
            ->where('id', $id)
            ->update([
                'name' => $data->title,
            ]);

        return 'sukses';
    }

    public function quizView()
    {
        $quiz = DB::table('quiz')->get();
        $subtopics = DB::table('subtopics')->get();
        return view('admin.quiz', ['quiz' => collect($quiz), 'subtopics' => collect($subtopics)]);
    }

    public function editQuizView($id)
    {
        $soal = DB::table('soal')
            ->where('id_quiz', $id)
            ->get();
        return view('admin.soal', ['soal' => collect($soal), 'id' => $id]);
    }

    public function addSoal(Request $data)
    {
        $pilihan = $data->pilihan1 . '|' . $data->pilihan2 . '|' . $data->pilihan3 . '|' . $data->pilihan4;
        DB::table('soal')->insert([
            'id_quiz' => $data->id,
            'soal' => $data->soal,
            'pilihan' => $pilihan,
            'correct' => $data->current,
        ]);

        return back();
    }

    public function deleteSoal($id)
    {
        DB::table('soal')
            ->where('id', $id)
            ->delete();
        return back();
    }

    public function editSoal(Request $data)
    {
        $pilihan = $data->pilihan1 . '|' . $data->pilihan2 . '|' . $data->pilihan3 . '|' . $data->pilihan4;
        DB::table('soal')
            ->where('id', $data->id)
            ->update([
                'soal' => $data->soal,
                'pilihan' => $pilihan,
                'correct' => $data->current,
            ]);
        return back();
    }

    public function deleteQuiz($id)
    {
        DB::table('soal')
            ->where('id_quiz', $id)
            ->delete();
        DB::table('quiz')
            ->where('id', $id)
            ->delete();
        return back();
    }

    public function addQuiz(Request $data)
    {
        DB::table('quiz')->insert([
            'name' => $data->name,
            'id_subtopic' => $data->id_subtopic,
        ]);
        return back();
    }

    public function updateQuiz(Request $data)
    {
        DB::table('quiz')
            ->where('id', $data->id)
            ->update([
                'name' => $data->name,
                'id_subtopic' => $data->id_subtopic,
            ]);
        return back();
    }

    public function certificateView()
    {
        $course = DB::table('course')->get();
        $data = DB::table('certificateApi')->get();
        return view('admin.certificate', ['course' => $course, 'data' => $data]);
    }

    public function addCertificateApi(Request $data)
    {
        DB::table('certificateApi')->insert([
            'id_course' => $data->id_course,
            'get_api' => $data->getApi,
            'submit_api' => $data->submitApi
        ]);

        return back();
    }

    public function deleteCertificateApi($id)
    {
        DB::table('certificateApi')->where('id', $id)->delete();
        return back();
    }

    public function updateCertificateApi(Request $data)
    {
        DB::table('certificateApi')->where('id_course', $data->id)->update([
            'get_api' => $data->get_api,
            'submit_api' => $data->submit_api
        ]);

        return back();
    }
}
