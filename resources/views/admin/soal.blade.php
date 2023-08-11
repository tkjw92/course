@extends('admin.main')

@section('content')
    <div class="container my-5">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSoal">Add</button>
        @foreach ($soal as $s)
            @php
                $pilihan = explode('|', $s->pilihan);
            @endphp
            <div class="mt-5">
                <div class="input-group flex-nowrap">
                    <input type="text" class="form-control fs-3 text-capitalize" disabled value="{{ $s->soal }}">
                    <button data-bs-toggle="modal" data-bs-target="#editSoal-{{ $s->id }}" class="btn btn-warning">Edit</button>
                    <button class="input-group-text bg-danger text-decoration-none text-white" onclick="(confirm('Apakah anda yakin ingin menghapus soal ini ?')) ? location.href='/admin/quiz/delete/soal/{{ $s->id }}' : ''">Delete</button>
                </div>
                <div class="d-flex flex-column" style="padding-left: 30px">
                    @for ($i = 0; $i < count($pilihan); $i++)
                        <label class="flex-fill m-2 p-3 d-flex" style="width: 600px">
                            <input disabled type="radio" class="form-check-input p-3" value="{{ $i + 1 }}" {{ $i + 1 == $s->correct ? 'checked' : '' }}>
                            <input disabled type="text" class="form-control" style="margin-left: 10px" value="{{ $pilihan[$i] }}">
                        </label>
                    @endfor
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="editSoal-{{ $s->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Soal</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/quiz/soal/edit" method="post">
                            @csrf
                            <div class="modal-body">
                                <label for="soal">Soal</label>
                                <input type="text" id="soal" name="soal" class="form-control" value="{{ $s->soal }}" required>
                                @for ($i = 0; $i < count($pilihan); $i++)
                                    <div class="input-group mt-1">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="radio" name="current" value="{{ $i + 1 }}" required {{ $i + 1 == $s->correct ? 'checked' : '' }}>
                                        </div>
                                        <input type="text" class="form-control" name="pilihan{{ $i + 1 }}" value="{{ $pilihan[$i] }}">
                                    </div>
                                @endfor
                            </div>
                            <input type="hidden" name="id" value="{{ $s->id }}">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- Modal -->
        <div class="modal fade" id="addSoal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Add Soal</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/admin/quiz/soal/add" method="post">
                        @csrf
                        <div class="modal-body">
                            <label for="soal">Soal</label>
                            <input type="text" id="soal" name="soal" class="form-control" required>
                            <div class="input-group mt-1">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="current" value="1" required>
                                </div>
                                <input type="text" class="form-control" name="pilihan1">
                            </div>
                            <div class="input-group mt-1">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="current" value="2">
                                </div>
                                <input type="text" class="form-control" name="pilihan2">
                            </div>
                            <div class="input-group mt-1">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="current" value="3">
                                </div>
                                <input type="text" class="form-control" name="pilihan3">
                            </div>
                            <div class="input-group mt-1">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="current" value="4">
                                </div>
                                <input type="text" class="form-control" name="pilihan4">
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{ $id }}">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
