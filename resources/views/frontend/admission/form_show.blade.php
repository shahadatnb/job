@extends('frontend.layouts.master')
@section('title','Admission Form')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<style>
  @media print {
    .container-xxl, .container, .container-fluid {
      width: 100% !important;
      max-width: 100% !important;
      padding-right: 0 !important;
      padding-left: 0 !important;
      margin-right: 0 !important;
      margin-left: 0 !important;
    }
    .back-to-top {
      display: none !important;
    }
  }
</style>
@endsection
@section('content')
<div class="container-xxl py-5">
    <div class="container">
<!--    Our Product -->
<section class="_store_by_team">
  <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-sm-12 col-lg-9 d-print-block"> 
            <div class="text-center">
              {{-- <img width="80" class="attachment-img" src="{{public_path('\upload\site_file\\'.config('settings.siteLogo',''))}}" alt="{{ config('settings.siteTitle','') }}"> --}}
              <img width="80" class="attachment-img" src="{{asset('/upload/site_file/'.config('settings.siteLogo',''))}}" alt="{{ config('settings.siteTitle','') }}">
              {{-- <div class="heading">
                  <h2 class="text-center m-0">{{ config('settings.siteTitle','') }}</h2>
                  <p class="text-center m-0">{{ config('settings.tagLine') }}</p>
                  <p class="text-center m-0">({{ config('settings.siteWeb') }})</p>
                  
                  <div class="student_photo">
                      <img style="max-width: 100%" class="img-thumbnail" src="{{public_path('/storage/'.$student->photo)}}" alt="">
                  </div>
              </div> --}}
              <table class="table">
                  <tr>
                      <td width="15%"></td>
                      <td width="70%" align="center">
                          <div class="heading text-center">
                              <h2 class="text-center m-0">{{ config('settings.siteTitle','') }}</h2>
                              <p class="text-center m-0">{{ config('settings.tagLine') }}</p>
                              <p class="text-center m-0">({{ config('settings.siteWeb') }})</p>
                          </div>
                      </td>
                      {{-- <td width="15%"><img width="100" class="img-thumbnail" src="{{public_path('/storage/'.$student->photo)}}" alt=""></td> --}}
                      <td width="15%"><img width="100" class="img-thumbnail" src="{{asset('/storage/'.$student->photo)}}" alt=""></td>
                  </tr>
              </table>              
            </div>
            <h3 class="text-center">Application Form {{ $student->year->year }}</h3>
            <button class="btn btn-primary d-print-none" onclick="window.print()">Print</button>
            <p>Student ID: {{$student->id}}</p>
            <table class="table">
                <tr>
                    <td>Name:</td>
                    <td>{{$student->name}}</td>
                </tr>
                <tr>
                    <td>Father's Name:</td>
                    <td>{{$student->fathersName}}</td>
                </tr>
                <tr>
                    <td>Mother's Name:</td>
                    <td>{{$student->mothersName}}</td>
                </tr>
                <tr>
                    <td>Sex</td>
                    <td>{{$student->sex}}</td>
                </tr>
                <tr>
                    <td>Class</td>
                    <td>{{$student->semester? $student->semester->name : ''}}</td>
                </tr>
                @if($student->class_id==4)
                <tr>
                    <td>Shift</td>
                    <td>{{$student->shift}}</td>
                </tr>
                @endif
                <tr>
                    <td>Trades</td>
                    <td>
                        @foreach($student->selectedTrade as $trade)
                            <p>{{$trade->priority}}. {{$trade->trade->name}}</p>
                        @endforeach
                    </td>
                </tr>
                {{-- @if($student->trade)
                <tr>
                    <td>Trade</td>
                    <td>{{$student->trade->name}}</td>
                </tr>
                @endif --}}
                <tr>
                    <td>Present Address:</td>
                    <td>{{$student->presentVillage}}, PS/Upazila: {{$student->presentUpazilaName ? $student->presentUpazilaName->name : ''}}, Dist: {{$student->presentZilaName ? $student->presentZilaName->name : ''}}-{{$student->presentPost}}</td>
                </tr>
                <tr>
                    <td>Permanent Address:</td>
                    <td>{{$student->permanentVillage}}, PS/Upazila: {{$student->permanentUpazilaName ? $student->permanentUpazilaName->name : ''}}, Dist: {{$student->permanentZilaName ? $student->permanentZilaName->name : ''}}-{{$student->permanentPost}}</td>
                </tr>
                <tr>
                    <td>Payment Status:</td>
                    <td>{{$student->paymentStatus == 1 ? 'Paid' : 'Unpaid'}}</td>
                </tr>
            </table>
            <button class="btn btn-primary d-print-none" onclick="window.print()">Print</button>
          </div>
      </div>
  </div>
</section>
<!--    Our Product -->
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
<!-- Tempusdominus -->
<script src="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"> </script>
<script>
  (function ($) {
    $(document).ready(function() {
        $('#dateOfBirth2').datetimepicker({
            //format: 'DD/MM/YYYY'
            format: 'YYYY-MM-DD'
        });


        $('.select2').select2();
        $('.select2-multi').select2();

        $('#presentDistrict').change(function(){
          $.get($(this).data('url'), {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#presentUpazila');
                subcat.empty();
                subcat.append("<option value=''>-----</option>");
                $.each(data, function(index, element) {
                    subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            });
        });

        $('#permanentDistrict').change(function(){
          $.get($(this).data('url'), {
                option: $(this).val()
            },
            function(data) {
                var subcat = $('#permanentUpazila');
                subcat.empty();
                subcat.append("<option value=''>-----</option>");
                $.each(data, function(index, element) {
                    subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                });
            });
        });

        $("#sameAsPresent").change(function(){
            if($(this).is(":checked")) {
                $("#permanentVillage").val($("#presentVillage").val());
                $("#permanentPost").val($("#presentPost").val());
                $("#permanentDistrict").empty();
                $("#permanentDistrict").append(`<option value='${$("#presentDistrict").val()}'>${$("#presentDistrict").find(':selected').text()}</option>`);
                $("#permanentDistrict").val($("#presentDistrict").val());
                $("#permanentUpazila").append(`<option value='${$("#presentUpazila").val()}'>${$("#presentUpazila").find(':selected').text()}</option>`);
                $("#permanentUpazila").val($("#presentUpazila").val());
            }
        });

        $("#class_id").change(function(){
          $("#admission_trades").empty();
          let url = "{{route('admission_trades')}}?class_id="+$(this).val();
          $.get(url, {
              
            },
            function(data) {
              console.log(data);
              if(data.status == true){
                $("#admission_trades").append(`
                  <label for="trade_id" class="">Trade Name</label>
                  <select class="form-control form-control-sm" required="" id="trade_id" name="trade_id"><option selected="selected" value="">Select Trade</option></select>
                `);
                  data.trades.forEach(function(element){
                    $("#trade_id").append("<option value='"+ element.id +"'>" + element.name + "</option>");
                  });
              }
            });
          
        });

    } );
    })(jQuery);
</script>
@endsection