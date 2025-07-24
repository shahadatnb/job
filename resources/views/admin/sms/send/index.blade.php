@extends('admin.layouts.layout')
@section('title',"Send SMS")
@section('css')
<link rel="stylesheet" href="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.css">
@endsection
@section('content')
{!! Form::open(array('route'=>['sms.send.post'],'method'=>'POST','files' => true)) !!}
<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body">
                @include('admin.layouts._message')
                <div class="form-group">
                    {!! Form::label('template', __('Select Template'),['class'=>'']) !!}
                    {!! Form::select('template',$templates,null,['class'=>'form-control','placeholder'=> __('Select Template')]) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('content', __('Content'),['class'=>'']) !!}
                    {!! Form::textarea('content',null,['class'=>'form-control','placeholder'=> __('Content')]) !!}
                </div>
                {{-- <div class="form-group">
                    {!! Form::label('numberType', __('Number Type'),['class'=>'']) !!}
                    <div class="custom-control custom-radio">
                        {!! Form::radio('numberType','contact',null,['class'=>'custom-control-input', 'id'=>'contact1']) !!}
                        <label for="contact1" class="custom-control-label">{{ __('Contact') }}</label>
                    </div>
                    <div class="custom-control custom-radio">
                        {!! Form::radio('numberType','excel',null,['class'=>'custom-control-input', 'id'=>'excel']) !!}
                        <label for="excel" class="custom-control-label">{{ __('Excel') }}</label>
                    </div>
                </div> --}}
                <div class="form-group">
                    <div class="text-primary">
                    <h4 id="smsbodycountdiv">1/0  : (160 Characters Per SMS)</h4>
                    </div>
                </div>
                {{-- <div class="input-group">
                    <div class="custom-file">
                      {!! Form::file('file',['class'=>'form-control','id'=>'file','required'=>false]) !!}
                    </div>
                </div> --}}
                {{ Form::submit(__('Send'),array('class'=>'btn btn-primary')) }}
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <div class="col-sm-12 col-md-9">
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                <div class="col-6 col-md-3">
                    {!! Form::select('job_id',$jobs,$data['job_id'],['class'=>'form-control form-control-sm select2','id'=>'job_id','placeholder'=> __('Job Title')]) !!}
                </div>
                <div class="col-6 col-md-2">
                    {!! Form::text('phone',$data['phone'],['class'=>'form-control form-control-sm','id'=>'phone','placeholder'=> __('Phone')]) !!}
                </div>
                <div class="col-6 col-md-2">
                    {!! Form::select('status',$applicationStatus,$data['status'],['class'=>'form-control form-control-sm select2','id'=>'status','placeholder'=> __('Status')]) !!}
                </div>
                <div class="col-6 col-md-3">
                    <div class="btn-group">
                    <button type="button" id="filter" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Filter</button>
                    </div>              
                </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm" id="applicant_table">
                    <thead>
                        <tr>
                            <th><input class="checkbox" id="selectAllApplicant" type="checkbox"> <label for="selectAllApplicant">All</label></th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applied_jobs as $key=>$item)
                            <tr>
                                <td class="">
                                    <input class="form-check-input ml-2 applicantNumber" name="contacts[]" value="{{ $item->student->phone }}" type="checkbox">
                                    <input type="hidden" name="applicant_name[]" value="{{ $item->student->name }}">
                                    <input type="hidden" name="job_title[]" value="{{ $item->job->title }}">
                                </td>
                                <td>{{ $item->student->name }}</td>
                                <td>{{ $item->student->phone }}</td>
                                <td>{{ $item->student->address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    @if($applied_jobs != [])
                    {{ $applied_jobs->appends($_GET)->links() }}
                    @endif
                </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>    
</div>
{!! Form::close() !!}
@endsection
@section('js')
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script src="{{asset('/assets/admin')}}/plugins/datatables/datatables.min.js"></script>
<script src="{{asset('/assets/admin/js/sms.counter.js')}}"></script>
<script>
$("#content").on("change keyup paste", function () {
    countSmsBody();
});
countSmsBody = function () {
        var msg = $("#content").val();
        var data = SMSCounter.count(msg, true);
        var length = data["length"];
        var remaining = data["remaining"];
        var part_count = data["part_count"];
        var text = data["text"];
        var per_message = data["per_message"];
        var encoding = data["encoding"];
        var sms_type = "";
        if (encoding == "GSM_7BIT") {
        sms_type = "Normal";
        } else if (encoding == "GSM_7BIT_EX") {
        sms_type = "Extended"; // for 7 bit GSM: ^ { } \ [ ] ~ | €
        } else if (encoding == "GSM_7BIT_EX_TR") {
        sms_type = "Turkish"; // Only for Turkish Characters "Ş ş Ğ ğ ç ı İ" encoding see https://en.wikipedia.org/wiki/GSM_03.38#Turkish_language_.28Latin_script.29
        } else if (encoding == "UTF16") {
        sms_type = "Unicode"; // for other languages "Arabic, Chinese, Russian" see http://en.wikipedia.org/wiki/GSM_03.38#UCS-2_Encoding
        }

        if (length < 1) {
        $("#smsbodycountdiv").text(" 1/0 : (160 Characters Per SMS)");
        } else {
        $("#smsbodycountdiv").text(
            part_count +
            "/" +
            length +
            "  : (" +
            per_message +
            " Characters Per SMS)"
        );
        }
    };


$(document).ready(function() {
    var arr = [];
    
    $('#template').on('change', function() {
        let template_id = $(this).val();
        if(template_id == ''){
            return false;
        }
        let url = "{{ url('sms/smsTemplate') }}/"+template_id;
        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            success: function(data){
                $('#content').val(data.content);
            }
        })
    });

    function smsType(type){
        var $radios = $('input:radio[name=numberType]');
        //if($radios.is(':checked') === false) {
            $radios.filter('[value='+type+']').prop('checked', true);
        //}
    }

    $("input[name='contacts[]']").change(function() {
        smsType('contact');
    });

    $("#file").change(function() {
        smsType('excel');
    });

    $('#selectAllApplicant').click(function(){
        if($(this).is(':checked')){
            $('input.applicantNumber').prop('checked', true);
            smsType('contact');
        }else{
            $('input.applicantNumber').prop('checked', false);
        }
    })


    $('.dselectAll').click(function(){
        $('input[name="contacts[]"]').prop('checked', false);
    })

    $(function () {
      $("#applicant_table").DataTable({
        "responsive": true,
        "autoWidth": false,
        "paging": false,
      });      
    });

    $("#filter").click(function() {
        let job_id = $("#job_id").val();
        let phone = $("#phone").val();
        let status = $("#status").val();
        let url = "{{ route('sms.send') }}?job_id="+job_id+"&phone="+phone+"&status="+status;
        window.location.href = url;
    });


});
</script>
@endsection