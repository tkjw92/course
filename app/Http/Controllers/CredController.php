<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CredController extends Controller
{
    public function loginView()
    {
        return view('login.login');
    }

    public function registerView()
    {
        return view('login.register');
    }

    public function register(Request $data)
    {

        if ((DB::table('account')->where('email', $data->email)->get()->count()) > 0) {
            return '<script>alert("Email address yang anda masukkan telah terdaftar !!!");location.href="/register"</script>';
        } else {
            DB::table('account')->insert([
                'name' => $data->name,
                'email' => $data->email,
                'password' => Hash::make($data->password),
                'role' => 'user'
            ]);

            return '<script>alert("Berhasil melakukan registrasi akun, silahkan konfirmasi email address anda untuk dapat login");location.href="/"</script>';
        }
    }

    public function login(Request $data)
    {
        $user =  DB::table('account')->where('email', $data->email)->get();

        if ($user->count() == 0) {
            return '<script>alert("Maaf anda tidak memiliki akses !!!");location.href="/"</script>';
        }

        $user = $user->first();

        if (Hash::check($data->password, $user->password)) {
            Session::put('account', [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]);

            return redirect('/student');
        } else {
            return '<script>alert("Maaf anda tidak memiliki akses !!!");location.href="/"</script>';
        }
    }
}
