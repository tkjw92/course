@extends('admin.main')

@section('content')
    <div class="container my-5">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addQuiz">Add</button>

        <!-- Modal -->
        <div class="modal fade" id="addQuiz" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Quiz</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/admin/quiz/add" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label for="name">Name Quiz</label>
                            <input type="text" class="form-control" id="name" name="name" required>

                            <label for="select">For subtopic</label>
                            <select name="id_subtopic" class="form-select" id="select" required>
                                <option value="" selected>Choose ...</option>
                                @foreach ($subtopics as $subtopic)
                                    <option value="{{ $subtopic->id }}">{{ $subtopic->id }} : {{ $subtopic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-striped table-hover">
            <tr>
                <th>Id Quiz</th>
                <th>Name</th>
                <th>For Subtopic</th>
                <th>Action</th>
            </tr>
            @foreach ($quiz as $q)
                <tr>
                    <td>{{ $q->id }}</td>
                    <td class="text-capitalize"><a href="/admin/quiz/edit/{{ $q->id }}">{{ $q->name }}</a></td>
                    <td>id: {{ $q->id_subtopic }} | name: {{ $subtopics->where('id', $q->id_subtopic)->first()->name }}</td>
                    <td>
                        <button class="btn btn-danger" onclick="(confirm('semua soal yang ada dalam quiz ini akan ikut terhapus !!!')) ? location.href='/admin/quiz/delete/{{ $q->id }}' : ''">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editQuiz-{{ $q->id }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                            Edit
                        </button>
                    </td>
                </tr>

                <!-- Modal -->
                <div class="modal fade" id="editQuiz-{{ $q->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Edit Quiz</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/admin/quiz/update" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <label for="name">Name Quiz</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $q->name }}" required>

                                    <label for="select">For subtopic</label>
                                    <select name="id_subtopic" class="form-select" id="select" required>
                                        <option value="" selected>Choose ...</option>
                                        @foreach ($subtopics as $subtopic)
                                            <option value="{{ $subtopic->id }}" {{ $q->id_subtopic == $subtopic->id ? 'selected' : '' }}>{{ $subtopic->id }} : {{ $subtopic->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                                <input type="hidden" name="id" value="{{ $q->id }}">
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </table>
    </div>
@endsection
