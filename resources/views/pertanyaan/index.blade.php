@extends('layout.app',[

])
@section('content')
{{-- <div class="main-content"> --}}
    <section class="section">
        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-question"></i> Questions</h4>
                </div>

                <div class="card-body">
                    <form action="" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                {{-- @can('questions.create') --}}
                                    <div class="input-group-prepend">
                                        <a href="{{ route('quest.create') }}" class="btn btn-primary" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i> TAMBAH</a>
                                    </div>
                                {{-- @endcan --}}
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan detail question">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                {{-- <th scope="col">SUBJECT</th> --}}
                                <th scope="col">PERTANYAAN</th>
                                {{-- <th scope="col">ATTACHMENT</th> --}}
                                <th scope="col">OPTION A</th>
                                <th scope="col">OPTION B</th>
                                <th scope="col">OPTION C</th>
                                <th scope="col">OPTION D</th>
                                <th scope="col">OPTION E</th>
                                <th scope="col">ANSWER</th>
                                <th scope="col">BOBOT</th>
                                <th scope="col">CREATED BY</th>
                                <th scope="col" style="width: 15%;text-align: center">AKSI</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($pertanyaan as $no => $question)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no }}</th>
                                    {{-- <td>{{ $subject->getName($question->subject_id) }}</td> --}}
                                    <td>{{ $question->pertanyaan }}</td>
                                    {{-- <td>
                                        @if ($question->video_id)
                                            <a href=" {{ Storage::url('public/videos/'.$video->getLink($question->video_id)) }}">VIDEO</a>
                                        @elseif($question->audio_id)
                                            <a href=" {{ Storage::url('public/audios/'.$audio->getLink($question->audio_id)) }}">AUDIO</a>
                                        @elseif($question->document_id)
                                            <a href=" {{ Storage::url('public/documents/'.$document->getLink($question->document_id)) }}">DOCUMENT</a>
                                        @elseif($question->image_id)
                                            <a href=" {{ Storage::url('public/images/'.$image->getLink($question->image_id)) }}">IMAGE</a>
                                        @else
                                            NO
                                        @endif
                                    </td> --}}
                                    @if ($question->PertanyanHasJawaban)
                                        @foreach ($question->PertanyanHasJawaban as $jawaban)

                                            <td>{{ $jawaban->jawaban_a }}</td>
                                            <td>{{ $jawaban->jawaban_b }}</td>
                                            <td>{{ $jawaban->jawaban_c }}</td>
                                            <td>{{ $jawaban->jawaban_d }}</td>
                                            <td>{{ $jawaban->jawaban_e }}</td>
                                        @endforeach
                                    @endif

                                    <td>{{ $question->jawaban }}</td>
                                    <td>{{ $question->bobot }}</td>
                                    <td></td>
                                    <td class="text-center">
                                        {{-- @can('questions.edit')
                                            <a href="{{ route('questions.edit', $question->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('questions.delete')
                                            <button onClick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $question->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{-- {{$questions->links("vendor.pagination.bootstrap-4")}} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
{{-- </div> --}}
@endsection
<script>
    //ajax delete

</script>
{{-- @stop --}}
