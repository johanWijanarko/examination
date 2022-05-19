@extends('layout.app',[

    ])
    @section('content')
    <style>
    .cek {
        min-width:40px;
        max-width:40px;
        }

    .card-header {
        background-color: #e3e3e3;
        /* border: 1px; */
    }


    .line1 {
        border-radius: 0 15px 15px 0;
    }
    .line2 {
        background-color: #f5f3f3;
    }


    .line2 {
        border-radius: 15px 0 0 15px;
    }
    #elementId{
        width: 100%;
        height: 500px;
        overflow-y: scroll;

    }
    </style>
    <div class="card">
        <div class="card-body">
            <div class="card-header mb-3" style="border-color: rgb(72, 79, 69); border= 5px;">
                <div class="row">
                    <div class="col-12">
                        <h4><i class="fas fa-exam"></i> Tes </h4>
                    </div>
                    <div class="col-12">
                        <!-- Display the countdown timer in an element -->
                        <span class="badge badge-danger" id="timer"></span>
                    </div>
                </div>
            </div>
            <div class="container">
                <form action="" id="saveExam">
                    <div class="row">
                        <div class="col-9 line1" id="elementId">
                            @foreach ($pertanyaan as $question)
                                <h5>Soal No. {{ $pertanyaan->currentPage() }}</h5><br>
                                <p>{{ $question['pertanyaan'] }}</p>
                                <input type="hidden" name="pertanyaan_id" value="{{ $question['id'] }}">
                                <input type="hidden" name="pertanyaan" value="{{ $question['pertanyaan'] }}">
                                <br>
                                    <div class="" style="margin-left: 23px;">
                                        @foreach ($question->PertanyanHasJawaban as $key=> $jawab)
                                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban2" value="{{ $jawab['jawaban_a'] }}-{{ $jawab['id'] }}"><b> A. {{ $jawab['jawaban_a'] }}</b></p><br>
                                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban2" value="{{ $jawab['jawaban_a'] }}-{{ $jawab['id'] }}"><b> A. {{ $jawab['jawaban_a'] }}</b></p><br>
                                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban2" value="{{ $jawab['jawaban_a'] }}-{{ $jawab['id'] }}"><b> A. {{ $jawab['jawaban_a'] }}</b></p><br>
                                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban2" value="{{ $jawab['jawaban_a'] }}-{{ $jawab['id'] }}"><b> A. {{ $jawab['jawaban_a'] }}</b></p><br>
                                            <input class="form-check-input" type="radio" name="jawaban" id="jawaban2" value="{{ $jawab['jawaban_a'] }}-{{ $jawab['id'] }}"><b> A. {{ $jawab['jawaban_a'] }}</b></p><br>
                                        @endforeach
                                    </div>
                                <br>
                            @endforeach
                        </div>
                            <div class="col-3 line2">
                                <div class="h4">No : </div>
                                @foreach ($pertanyaan2 as $no=> $jumlah)
                                    <a href="{{ url('pertanyan/exam')."?page=".$jumlah->id }}" class="btn btn-primary btn-sm cek active" role="button" aria-pressed="true">{{ ++$no }}</a>
                                    <button type="button" onclick="pageRedirect({{ $jumlah->id }})"></button>
                                @endforeach
                                <button class="btn btn-primary btn-sm cek active">3</button>
                                <button class="btn btn-primary btn-sm cek active">3</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                                <button class="btn btn-primary btn-sm cek active">90</button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $pertanyaan->links() }}
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            <button type="button" class="btn btn-warning" onclick="ragu()">Ragu - ragu</button>{!! "&nbsp;" !!}
                            <button type="button" class="btn btn-primary" onclick="save()">Submit</button>
                        </div>
                    </div>
                </form>
            <div class="card-footer">
                @if ($pertanyaan->currentPage() == $pertanyaan->lastPage())
                    <button class="btn btn-primary btn-lg btn-block">Finish</button>
                @endif
            </div>
        </div>
    </div>
    @endsection
    @push('page-script')

    <script>
    function save(){
        var formData = $('#saveExam').serialize();
            $.ajax({
                type: "POST",
                url:  '{{ url('pertanyan/savejawban') }}',
                dataType: "JSON",
                data: formData,
                success: function (data) {
                    console.log(data);
                }
            });
    }
     function pageRedirect(id) {
        let stateObj = id;
            window.history.replaceState(stateObj,
                        "pertanyan/exam?page=")+id;
    }
    setTimeout("pageRedirect()", 10000);
    </script>
    @endpush
