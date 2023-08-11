@extends('user.main')

@section('content')
    <div class="container mt-5">
        <h3>Course</h3>
        <div class="container-wrapper row row-cols-auto">
            @foreach ($courses as $course)
                <div class="row row-cols-auto">
                    <div class="col shadow-sm m-3 p-3 border rounded bg-white d-flex flex-column justify-content-between" style="width: 350px">
                        <a href="/student/course/{{ $course->id }}">
                            <img src="/storage/{{ $course->thumbnail }}" class="mt-1 mb-5 w-100">
                        </a>
                        <div>
                            <h5 class="mt-3 text-capitalize">{{ $course->name }}</h5>
                            <p><i class="fa-regular fa-file"></i> {{ collect($count)->where('id_course', $course->id)->count() }} module</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
