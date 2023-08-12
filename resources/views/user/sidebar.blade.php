@php
    $total = 0;
    $count = 0;
@endphp
<div class="position-sticky sticky-top shadow-sm border-dark">
    <h4 class="p-3 text-center">Linux System Administration</h4>
    <div class="progress m-3">
        <div class="progress-bar bg-success" role="progressbar" id="progressTotal" style="width: 0%">0%</div>
    </div>
    <hr>
    <div class="vh-100 bg-white w-100">
        <div class="accordion accordion-flush">
            @foreach ($topics as $topic)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button text-capitalize" type="button" data-bs-toggle="collapse" data-bs-target="#topic-{{ $topic->id }}" aria-expanded="true">
                            {{ $topic->name }}
                        </button>
                    </h2>
                    <div id="topic-{{ $topic->id }}" class="accordion-collapse collapse show">
                        @foreach ($subtopics as $subtopic)
                            @if ($subtopic->id_topic == $topic->id)
                                <a href="/student/course/{{ $id_course }}/{{ $subtopic->id }}"
                                    class="d-block accordion-body position-relative text-capitalize text-decoration-none text-dark {{ request()->segment(count(request()->segments())) == $subtopic->id ? 'active' : '' }}" style="margin-left: 20px">{{ $subtopic->name }}</a>
                            @endif
                        @endforeach
                        @foreach ($quiz as $q)
                            @if ($q->id_topic == $topic->id)
                                @php
                                    $total += $score->where('id_quiz', $q->id)->first()->score ?? 0;
                                    $count++;
                                @endphp
                                <a href="/student/quiz/{{ $q->id }}" class="text-capitalize text-decoration-none text-black accordion-body position-relative d-flex align-items-center justify-content-between" style="margin-left: 20px">
                                    {{ $q->name }}
                                    <div class="progress w-25 ms-5">
                                        @if (count($score) > 0)
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $score->where('id_quiz', $q->id)->first()->score ?? '0' }}%">{{ $score->where('id_quiz', $q->id)->first()->score ?? '0' }}%</div>
                                        @endif
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
            @if ($count != 0)
                @if (ceil($total / $count) >= 75)
                    @if ($certificate->url != 'temp')
                        <a href="{{ $certificate->url }}" target="blank" class="btn btn-primary w-100 mt-5">Download Certificate</a>
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>

<script>
    const progress = document.getElementById('progressTotal');
    progress.setAttribute('style', 'width: {{ $count != 0 ? ceil($total / $count) : '0' }}%');
    progress.innerText = '{{ $count != 0 ? ceil($total / $count) : '' }}%';
</script>

@php
    if ($count != 0) {
        if (ceil($total / $count) >= 75) {
            if ($certificate->url == null) {
                $api = str_replace('$nama', str_replace(' ', '+', $certificate->name), $api);
                $api = str_replace('$signature', $certificate->signature, $api);
                file_get_contents($api);
                DB::table('certificate')
                    ->where('id_course', $id_course)
                    ->where('id_user', session('account')['id'])
                    ->update([
                        'url' => 'temp',
                    ]);
            }
        }
    }
@endphp
