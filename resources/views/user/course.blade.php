@extends('user.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-3 m-0 p-0">
                @include('user.sidebar')
            </div>
            <div class="col-9 mt-4">
                <div class="container">
                    <div class="p-5">
                        <textarea id="editor" class="p-5">
                            {{ $content }}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        ClassicEditor.create(document.querySelector("#editor"), {
            toolbar: [],
        }).then(editor => {
            editor.enableReadOnlyMode("editor");
        }).catch(error => {
            console.error(error);
        });
    </script>
@endsection
