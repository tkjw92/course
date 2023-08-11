<div class="container-fluid">
    <div style="display: flex; justify-content: space-between; align-items: center">
        <h3 class="m-5">Course List</h3>
        <button class="btn btn-primary m-3" style="width: 150px; height: 50px;" data-bs-toggle="modal" data-bs-target="#addCourse">Add Course</button>
        <!-- Modal -->
        <div class="modal fade" id="addCourse" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add new course</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/admin" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name">Course Name</label>
                                <input type="text" class="form-control" name="name" id="name" autocomplete="off" required>
                            </div>
                            <div class="mb3 d-none" id="preview">
                                <img class="img-thumbnail" id="preview-img" width="200px">
                            </div>
                            <div class="mb-3">
                                <label for="thumbnail">Thumbnail</label>
                                <input type="file" class="form-control" name="thumbnail" id="thumbnail" accept="image/*" required>
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

        <div class="row row-cols-auto justify-content-center">

            @foreach ($courses as $course)
                <div class="col shadow-sm m-5 p-3 border rounded d-flex flex-column justify-content-between" style="width: 350px">
                    <a href="/admin/course/{{ $course->id }}">
                        <img src="storage/{{ $course->thumbnail }}" class="mt-1 mb-5 w-100">
                    </a>
                    <div>
                        <h5 class="mt-3 text-capitalize">{{ $course->name }}</h5>
                        <p><i class="fa-regular fa-file"></i> {{ collect($count)->where('id_course', $course->id)->count() }} module</p>
                        <div class="d-flex justify-content-between mt-3">
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#course-{{ $course->id }}">
                                <i class="fa-solid fa-pen-to-square"></i>
                                Edit
                            </button>
                            <button onclick="(confirm('Yakin ingin menghapus course ini ?')) ? location.href='/admin/delete/{{ $course->id }}' : ''" class="btn btn-danger">
                                <i class="fa-solid fa-trash"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="course-{{ $course->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Edit course</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/admin/edit/{{ $course->id }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="thumbnailName" value="{{ $course->thumbnail }}">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name">Course Name</label>
                                        <input type="text" class="form-control" value="{{ $course->name }}" name="name" autocomplete="off" required>
                                    </div>
                                    <div class="mb3">
                                        <img class="img-thumbnail" src="storage/{{ $course->thumbnail }}" width="200px">
                                    </div>
                                    <div class="mb-3">
                                        <label for="thumbnail">Thumbnail</label>
                                        <input type="file" class="form-control" name="thumbnail" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

</div>
