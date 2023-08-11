<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    public function view($id)
    {
        $soal = DB::table('soal')->where('id_quiz', $id)->get();
        $iteration = (session()->has('quiz')) ? (session('quiz')['iteration']) : 0;
        if (count($soal) == $iteration) {
            Session::put('complete', '');
            return redirect('/student/quiz/' . $id . '/score');
        } else {
            return view('user.quiz', [
                'name' => collect(session('account'))->get('name'),
                'soal' => $soal,
                'iteration' => $iteration,
                'id' => $id
            ]);
        }
    }

    public function inputChoice(Request $data)
    {
        if (session()->has('quiz')) {
        } else {
            Session::put('quiz', array(
                'iteration' => 0,
                'input' => array()
            ));
        }
        $iteration = session('quiz')['iteration'];

        $old = session('quiz')['input'];
        array_push($old, $data->input);

        Session::put('quiz', array(
            'iteration' => $iteration + 1,
            'input' => $old
        ));

        return back();
    }

    public function score($id)
    {
        if (session()->has('complete') && session()->has('quiz')) {
            $input = session('quiz')['input'];
            $correct = DB::table('soal')->where('id_quiz', $id)->get('correct');
            $currentCorrect = 0;
            for ($i = 0; $i < count($correct); $i++) {
                if ($input[$i] == $correct[$i]->correct) {
                    $currentCorrect++;
                }
            }
            $score = ceil($currentCorrect / count($correct) * 100);
            $id_user = DB::table('account')->where('email', session('account')['email'])->get('id')[0]->id;
            $cek = DB::table('quizScore')->where('id_user', $id_user)->where('id_quiz', $id)->get();

            if (count($cek) == 0) {
                DB::table('quizScore')->insert([
                    'id_user' => $id_user,
                    'id_quiz' => $id,
                    'score' => $score
                ]);
            } else {
                DB::table('quizScore')->where('id_user', $id_user)->where('id_quiz', $id)->update([
                    'score' => $score
                ]);
            }

            session()->remove('quiz');
            session()->remove('complete');

            return redirect('/student');
        } else {
            return redirect('/student/quiz/' . $id);
        }
    }
}
