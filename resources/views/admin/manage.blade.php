@extends('admin.main')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="m-5 text-capitalize">Topic List of {{ $course->name }}</h3>
            <button class="btn btn-primary m-3" style="width: 150px;height: 50px" data-bs-toggle="modal" data-bs-target="#addTopic">Add Topic</button>
            <!-- Modal -->
            <div class="modal fade" id="addTopic" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Add new topic</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/course" method="post">
                            @csrf
                            <input type="hidden" name="idCourse" value="{{ $course->id }}">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name">Topic Name</label>
                                    <input type="text" class="form-control" name="name" id="name" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div class="container-fluid shadow-lg rounded overflow-x-hidden">

            @foreach ($topics as $topic)
                <div class="m-5">
                    <div class="d-flex justify-content-between">
                        <h3 class="text-capitalize">{{ $topic->name }}</h3>
                        <div>
                            <button onclick="(confirm('Apakah anda ingin menghapus topic, semua subtopic dari topic ini akan ikut terhapus !!!')) ? location.href='/admin/course/delete/{{ $topic->id }}' : ''" class="btn btn-danger">Delete</button>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubtopic-{{ $topic->id }}">Add</button>
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editTopic-{{ $topic->id }}">Edit</button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="editTopic-{{ $topic->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Edit topic</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/admin/course/edit/{{ $topic->id }}" method="post">
                                        @csrf
                                        <input type="hidden" name="idTopic" value="{{ $topic->id }}">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name">Subtopic Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $topic->name }}" id="name" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addSubtopic-{{ $topic->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Add new subtopic</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/admin/course/topic" method="post">
                                        @csrf
                                        <input type="hidden" name="idTopic" value="{{ $topic->id }}">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="name">Subtopic Name</label>
                                                <input type="text" class="form-control" name="name" id="name" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @foreach ($subtopics as $subtopic)
                        @if ($subtopic->id_topic == $topic->id)
                            <h5 class="ps-5 text-capitalize">
                                <button class="btn btn-outline-danger me-1" onclick="(confirm('Apakah anda yakin ingin menghapus subtopic ini ? kontent yang ada akan terhapus !!!')) ? location.href='/admin/course/subtopic/delete/{{ $subtopic->id }}' : ''">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <a class="btn btn-outline-warning me-3" href="/admin/course/subtopic/edit/{{ $subtopic->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                {{ $subtopic->name }}
                            </h5>
                        @endif
                    @endforeach
                </div>
            @endforeach

        </div>
    @endsection
