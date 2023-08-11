@extends('admin.main')

@section('content')
    <div class="container my-5">
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCertificate">Add</button>
        <!-- Modal -->
        <div class="modal fade" id="addCertificate" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Certificate Template</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <div class="modal-body">
                            <label class="w-100">
                                Course
                                <select class="form-select text-capitalize" name="id_course" required>
                                    <option selected value="">Select Course</option>
                                    @foreach ($course as $c)
                                        <option class="text-capitalize" value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="w-100">
                                Submit API
                                <textarea class="form-control" name="submitApi"></textarea>
                            </label>
                            <label class="w-100">
                                Get API
                                <textarea class="form-control" name="getApi"></textarea>
                            </label>
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
                <th>No</th>
                <th>Course</th>
                <th>Action</th>
            </tr>
            <tr>
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $d)
                    <td>{{ $no }}</td>
                    <td>{{ $course->where('id', $d->id_course)->first()->name }}</td>
                    <td>
                        <button class="btn btn-danger" onclick="confirm('Apakah anda yakin ingin menghapus template certificate ini ?') ? location.href='/admin/certificate/delete/{{ $d->id }}' : ''">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCertificate-{{ $d->id_course }}">
                            <i class="fa-regular fa-pen-to-square"></i>
                            Edit
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="editCertificate-{{ $d->id_course }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">Edit Certificate Template</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="/admin/certificate/update" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $d->id_course }}">
                                        <div class="modal-body">
                                            <label class="w-100">
                                                Course
                                                <input type="text" class="form-control" value="{{ $course->where('id', $d->id_course)->first()->name }}" disabled>
                                            </label>
                                            <label class="w-100">
                                                Submit API
                                                <textarea class="form-control" name="submit_api">{{ $d->submit_api }}</textarea>
                                            </label>
                                            <label class="w-100">
                                                Get API
                                                <textarea class="form-control" name="get_api">{{ $d->get_api }}</textarea>
                                            </label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                    @php
                        $no++;
                    @endphp
                @endforeach
            </tr>
        </table>
    </div>
@endsection
