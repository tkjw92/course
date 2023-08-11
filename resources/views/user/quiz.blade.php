@extends('user.main')

@php
    $pilihan = explode('|', $soal[$iteration]->pilihan);
@endphp

@section('content')
    <div class="container my-5">
        <form action="" method="post">
            @csrf
            <div>
                <h4 class="text-capitalize">{{ $soal[$iteration]->soal }}</h4>
                @for ($i = 1; $i < 5; $i++)
                    <label class="rounded p-2 border border-1 w-50 mt-2">
                        <input type="radio" name="input" required value="{{ $i }}" class="me-3">
                        {{ $pilihan[$i - 1] }}
                    </label>
                @endfor
            </div>
            <button class="btn btn-success mt-3">Submit</button>
        </form>
    </div>
@endsection
