@extends('frontend.layouts.master')
@section('title','Admission Form')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
<div class="container-xxl py-5">
    <div class="container">

<section class="_inner_page_banner" {{--style="background-image: url()"--}}>
  <div class="container">
      <div class="_in_title_text">
          <h3 class="text-center">ভর্তির আবেদন- ২০২৫</h3>
          <ul>
            <li>ইচ্ছাকৃতভাবে জন্ম নিবন্ধন নম্বর অথবা অন্য কোন ভুল তথ্য প্রদান করলে অথবা একাধিক ভূয়া জন্ম নিবন্ধন নম্বর ব্যবহার করে আবেদন করে ডিজিটাল লটারিতে নির্বাচিত হলে তা বাতিল বলে গণ্য হবে।</li>
            <li>সমস্ত তথ্য অবশ্যই ইংরেজিতে পূরণ করতে হবে। লাল তারকা (*) চিহ্ণিত তথ্যগুলো অবশ্যই প্রদান করতে হবে।</li>
            <li>এই প্রতিষ্ঠানের যে সকল ছাত্র/ছাত্রী নবম শ্রেণিতে ভর্তি হতে ইচ্ছুক তাদেরকে 'নিজ প্রতিষ্ঠান' এ চেক মার্ক দিতে হবে এবং অষ্টম শ্রেণির ক্লাস রোল লিখতে হবে</li>
          </ul>
      </div>
  </div>
</section>

<!--    Our Product -->
<section class="_store_by_team">
  <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-sm-12 col-lg-9">
            @include('admin.layouts._message')
            {!! Form::open( array('route'=>['admission.save'],'method'=>'POST','files' => true)) !!}
            <div class="form-group mb-1">
                {!! Form::label('name', __('নাম লিখুন *'),['class'=>'mb-1']) !!}
                {!! Form::text('name',null,['class'=>'form-control form-control-sm','required'=>'required','placeholder'=> __('Name Of Student')]) !!}
              </div>
              <div class="row">
                <div class="col-4">
                  <div class="form-group mb-1">
                    {!! Form::label('dateOfBirth', __('Date of Birth * (জন্ম তারিখ)'),['class'=>'mb-1']) !!}
                    <div class="input-group" id="dateOfBirth2" data-target-input="nearest">
                      {!! Form::text('dateOfBirth',null,['class'=>'form-control form-control-sm datetimepicker-input','placeholder'=>__('Ex: 1999-01-30'),
                      'data-target'=>'#dateOfBirth2', 'data-inputmask-alias'=>'datetime','data-inputmask-inputformat'=>'yyyy/mm/dd','data-mask'=>'data-mask']) !!}
                      <div class="input-group-append" data-target="#dateOfBirth2" data-toggle="datetimepicker">
                          <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group mb-1">
                    {!! Form::label('studentBirthRegNo', __('জন্ম নিবন্ধনের নম্বর *'),['class'=>'mb-0']) !!}
                    {!! Form::text('studentBirthRegNo',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Birth Registration No')]) !!}
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group mb-1">
                    {!! Form::label('sex', __('Sex *'),['class'=>'mb-1']) !!}
                    {!! Form::select('sex',['Male'=>'Male','Female'=>'Female','Others'=>'Others'],null,['class'=>'form-control form-control-sm','required'=>'required','placeholder'=> __('শিক্ষার্থীর ধরণ/জেন্ডার')]) !!}
                  </div>
                </div>
                {{-- <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('religion', __('Religion *'),['class'=>'mb-1']) !!}
                    {!! Form::select('religion',['Islam'=>'Islam','Hindu'=>'Hindu','Christian'=>'Christian','Others'=>'Others'],null,['class'=>'form-control form-control-sm','required'=>'required','placeholder'=> __('Religion')]) !!}
                  </div>
                </div> --}}
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('mobile', __('মোবাইল নম্বর *'),['class'=>'mb-1']) !!}
                    {!! Form::text('mobile',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Mobile')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('mobile_confirmation', __('মোবাইল নম্বরটি আবার লিখুন'),['class'=>'mb-1']) !!}
                    {!! Form::text('mobile_confirmation',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Mobile Confirm')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group mb-1">
                  {!! Form::label('class_id', __('যে শ্রেণিতে ভর্তি হতে ইচ্ছুক *'),['class'=>'mb-1']) !!}
                  {!! Form::select('class_id',$admission_class,'',['class'=>'form-control form-control-sm select2','required'=>true,'placeholder'=> __('শ্রেণি')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('shift_id', __('শিফট *'),['class'=>'mb-1']) !!}
                    {{-- {!! Form::select('shift_id',[1=>'1st Shift',2=>'2nd Shift'],null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Shift')]) !!} --}}
                    {!! Form::select('shift_id',[2=>'2nd Shift'],null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Shift')]) !!}
                  </div>
                  <ol class="list-group list-group-flush" id="admission_subjects">
                  </ol>
                </div>
              </div>
              <div class="row d-none" id="admission_trades">
                {{-- <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('trade_id[1]', __('First Choice *'),['class'=>'mb-1']) !!}
                    {!! Form::select('trade_id[1]',$admission_trades,null,['class'=>'form-control form-control-sm admission_trades','required'=>false,'placeholder'=> __('Trade Name')]) !!} 
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('trade_id[2]', __('Second Choice *'),['class'=>'mb-1']) !!}
                    {!! Form::select('trade_id[2]',$admission_trades,null,['class'=>'form-control form-control-sm admission_trades','required'=>false,'placeholder'=> __('Trade Name')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('trade_id[3]', __('Third Choice *'),['class'=>'mb-1']) !!}
                    {!! Form::select('trade_id[3]',$admission_trades,null,['class'=>'form-control form-control-sm admission_trades','required'=>false,'placeholder'=> __('Trade Name')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('trade_id[4]', __('Fourth Choice *'),['class'=>'mb-1']) !!}
                    {!! Form::select('trade_id[4]',$admission_trades,null,['class'=>'form-control form-control-sm admission_trades','required'=>false,'placeholder'=> __('Trade Name')]) !!}
                  </div>
                </div> --}}
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group mb-1">
                  {!! Form::label('quota_id', __('Quota'),['class'=>'mb-1']) !!}
                  {!! Form::select('quota_id',$quotas,null,['class'=>'form-control form-control-sm select2','required'=>false,'placeholder'=> __('সংরক্ষিত আসন')]) !!}
                  </div>
                </div>
                <div class="col-2">
                  <div class="form-group mb-1 mt-4">
                    {!! Form::label('self_institute', __('নিজ প্রতিষ্ঠান'),['class'=>'mb-1']) !!}
                    {!! Form::checkbox('self_institute',1,null) !!}
                  </div>
                </div>
                <div class="col-4">
                  <div class="form-group mb-1 d-none" id="calss_roll_field">
                    {!! Form::label('class_roll', __('ক্লাস রোল *'),['class'=>'mb-0']) !!}
                    {!! Form::text('class_roll',null,['class'=>'form-control form-control-sm','required'=>false,'placeholder'=> __('Class Roll')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('fathersName', __('পিতার নাম *'),['class'=>'mb-0']) !!}
                    {!! Form::text('fathersName',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Father`s Name')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('nidFather', __('পিতার এনআইডি/জন্ম নিবন্ধন/পাসপোর্ট নম্বর *'),['class'=>'mb-0']) !!}
                    {!! Form::text('nidFather',null,['class'=>'form-control form-control-sm','placeholder'=> __('NID/Birth/Passport Father')]) !!}
                  </div>
                </div>
                
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('mothersName', __('মাতার নাম *'),['class'=>'mb-0']) !!}
                  {!! Form::text('mothersName',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Mother`s Name')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('nidMother', __('মাতার এনআইডি/জন্ম নিবন্ধন/পাসপোর্ট নম্বর *'),['class'=>'mb-0']) !!}
                  {!! Form::text('nidMother',null,['class'=>'form-control form-control-sm','placeholder'=> __('NID/Birth/Passport Mother')]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('guardianName', __('অভিভাবকের নাম *'),['class'=>'mb-0']) !!}
                    {!! Form::text('guardianName',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Guardian Name')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('nidGuardian', __('অভিভাবকের এনআইডি/জন্ম নিবন্ধন/পাসপোর্ট নম্বর'),['class'=>'mb-0']) !!}
                  {!! Form::text('nidGuardian',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('NID/Birth/Passport Guardian')]) !!}
                  </div>
                </div>
                {{-- <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('guardianRelation', __('Guardian Relation *'),['class'=>'mb-0']) !!}
                  {!! Form::text('guardianRelation',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Guardian Relation')]) !!}
                  </div>
                </div> --}}
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="form-group mb-1">
                    {!! Form::label('lastQualification', __('সর্বশেষ শ্রেণি *'),['class'=>'mb-0']) !!}
                    {!! Form::text('lastQualification',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Last Qualification')]) !!}
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group mb-1">
                  {!! Form::label('previous_school', __('পূর্বের শিক্ষা প্রতিষ্ঠানের নাম *'),['class'=>'mb-0']) !!}
                  {!! Form::text('previous_school',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('Previous School')]) !!}
                  </div>
                </div>
              </div>
              <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('বর্তমান ঠিকানা *')}}</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group mb-1">
                        {!! Form::label('presentVillage', __('Village'),['class'=>'mb-0']) !!}
                        {!! Form::text('presentVillage',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('বিস্তারিত ঠিকানা এখানে জেলা এবং থানা লেখার প্রয়োজন নাই। *')]) !!}
                      </div>
                    </div>                    
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group mb-1">
                      {!! Form::label('presentDistrict', __('District'),['class'=>'mb-0']) !!}
                      {!! Form::select('presentDistrict',$locations,null,['class'=>'form-control form-control-sm select2','required'=>true,'data-url'=> route('childLocation'),'placeholder'=> __('জেলা *')]) !!}
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group mb-1">
                        {!! Form::label('presentUpazila', __('Upazila'),['class'=>'mb-0']) !!}
                        {!! Form::select('presentUpazila',$presentUpazila,null,['class'=>'form-control form-control-sm select2','required'=>true,'placeholder'=> __('থানা/উপজেলা *')]) !!}
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group mb-1">
                      {!! Form::label('presentPost', __('Post'),['class'=>'mb-0']) !!}
                      {!! Form::text('presentPost',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('পোস্ট কোড *')]) !!}
                      </div>
                    </div>
                  </div>        
                </div>
              </div>
              <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">{{__('স্থায়ী ঠিকানা *')}}</h3>
                    <div class="card-tools">
                      <div class="custom-control custom-checkbox">
                        {{ Form::checkbox('sameAsPresent', 1, null, ['class' => 'custom-control-input', 'id' => 'sameAsPresent']) }}
                        {!! Form::label('sameAsPresent', __('Same As Present'),['class'=>'custom-control-label']) !!}
                      </div>
                    </div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group mb-1">
                        {!! Form::label('permanentVillage', __('Villege'),['class'=>'mb-0']) !!}
                        {!! Form::text('permanentVillage',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('বিস্তারিত ঠিকানা এখানে জেলা এবং থানা লেখার প্রয়োজন নাই। *')]) !!}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group mb-1">
                      {!! Form::label('permanentDistrict', __('District'),['class'=>'mb-0']) !!}
                      {!! Form::select('permanentDistrict',$locations,null,['class'=>'form-control form-control-sm select2','required'=>true,'data-url'=> route('childLocation'),'placeholder'=> __('জেলা *')]) !!}
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group mb-1">
                        {!! Form::label('permanentUpazila', __('Upazila'),['class'=>'mb-0']) !!}
                        {!! Form::select('permanentUpazila',$permanentUpazila,null,['class'=>'form-control form-control-sm select2','required'=>true,'placeholder'=> __('থানা/উপজেলা *')]) !!}
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group mb-1">
                      {!! Form::label('permanentPost', __('Post'),['class'=>'mb-0']) !!}
                      {!! Form::text('permanentPost',null,['class'=>'form-control form-control-sm','required'=>true,'placeholder'=> __('পোস্ট কোড *')]) !!}
                      </div>
                    </div>
                  </div>        
                </div>
              </div>
              <div class="row">
                <div class="col-9">
                  <div class="form-group mb-1">
                    <p>ছবির দৈর্ঘ্য ও প্রস্থ্য অবশ্যই 300X300 পিক্সেল এবং সাইজ 100 কিলোবাইটের নিচে হতে হবে।</p>
                    {!! Form::label('photo', __('Select Photo (Max photo size 100KB)'),['class'=>'mb-1']) !!}
                    {!! Form::file('photo',null,['class'=>'form-control form-control-sm']) !!}
                  </div>
                </div>
                <div class="col-12">
                    {!! Form::submit(__('Submit'),['class'=>'btn btn-block mt-2 btn-danger']) !!}
                </div>
              </div>
          {!! Form::close() !!}
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

        $( document ).ready(function() {
          if($("#class_id").val() == 4){
            $("#admission_trades").removeClass("d-none");
            $(".admission_trades").attr('required', true);
            $("#shift_id").parent().removeClass('d-none');
          }else{
            $("#admission_trades").addClass("d-none");
            $(".admission_trades").attr('required', false);
            $("#shift_id").val(1);
            $("#shishift_idft").parent().addClass('d-none');
          }

          if($('#presentDistrict').val() != ''){
            $.get($('#presentDistrict').data('url'), {
                  option: $('#presentDistrict').val()
              },
              function(data) {
                  var subcat = $('#presentUpazila');
                  subcat.empty();
                  subcat.append("<option value=''>-----</option>");
                  $.each(data, function(index, element) {
                      subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                  });
              });
          }

          if($('#permanentDistrict').val() != ''){
            $.get($('#permanentDistrict').data('url'), {
                  option: $('#permanentDistrict').val()
              },
              function(data) {
                  var subcat = $('#permanentUpazila');
                  subcat.empty();
                  subcat.append("<option value=''>-----</option>");
                  $.each(data, function(index, element) {
                      subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
                  });
              });
          }
        });

        /*
        $("#class_id").change(function(){
          if($(this).val() == 4){
            $("#admission_trades").removeClass("d-none");
            $(".admission_trades").attr('required', true);
            $("#shift_id").parent().removeClass('d-none');
          }else{
            $("#admission_trades").addClass("d-none");
            $(".admission_trades").attr('required', false);
            $("#shift_id").val(1);
            $("#shift_id").parent().addClass('d-none');
          }
        });
*/
        //$("#shift_id").change(function(){
        $("body").on('change', '#shift_id, #class_id', function(){
          if($("#shift_id").val() != '' && $("#class_id").val() == 4){
            trades();
          }
        });

        $( document ).ready(function() {
          if($("#shift_id").val() != '' && $("#class_id").val() == 4){
            trades();
          }
        });

        function trades(){
          let url = "{{route('admission_trades')}}?class_id="+$("#class_id").val()+"&shift_id="+$("#shift_id").val();
            $.get(url, {
                
              },
              function(data) {
                console.log(data);
                if(data.status == true){                  
                  $("#admission_trades").removeClass("d-none");
                  $("#admission_trades").empty();
                  let htmlData = '';
                  const choice = ['First Choice', 'Second Choice', 'Third Choice', 'Fourth Choice'];
                  data.trades.forEach(function(element, index){
                    htmlData += `
                      <div class="col-6">
                        <div class="form-group mb-1">
                          <label for="trade_id[${index+1}]" class="">${choice[index]}</label>
                          <select id="trade_id[${index+1}]" class="form-control form-control-sm admission_trades" required="required" name="trade_id[${index+1}]">
                            <option selected="selected" value="">Select Trade</option>`;
                            data.trades.forEach(function(trade){
                              htmlData += `<option value='${trade.id}'>${trade.name}</option>`;
                            });
                          htmlData += `</select>
                        </div>
                      </div>
                    `;
                  });
                  $("#admission_trades").append(htmlData);
                }
              }
            );
        }

        $("#admission_trades").on('change', '.admission_trades', function(){
          //console.log($(this).val());
          if($(this).val() != ''){
            let admission_trades = $(".admission_trades");
            //console.log(admission_trades);
            for(let i = 0; i < admission_trades.length; i++){
              if($(".admission_trades")[i].value == $(this).val() && $(".admission_trades")[i].id != $(this)[0].id){
                //if($(this)[0].id == $(".admission_trades")[i].id){
                //  console.log('You have already selected this trade');
                //}
                $(this).val('');
                alert('You have already selected this trade');
              }
            }
          }
        });
/*
        $("input[name='trade_id[]']").change(function(){
          console.log($(this).val());
          if($(this).val() != ''){
            console.log($(this).val());
          }
        });
*/
        /*
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
        */
        /*
        $("#admission_trades").change(function(){
          $("#admission_subjects").append(`            
            <li class="list-group-item d-flex justify-content-between align-items-center">
              ${$(this).find(":selected").text()}
              <input type="hidden" name="trade_ids[]" value="${$(this).find(":selected").val()}">
              <span class="badge text-bg-primary rounded-pill text-primary">X</span>
            </li>
          `);
          console.log($(this).find(":selected").val());
        });

        $("#admission_subjects").on('click','.badge',function(){
          $(this).parent().remove();
        });
        */

        $("#self_institute").change(function(){
          if(this.checked) {
            $("#calss_roll_field").removeClass("d-none");
            $("#class_roll").attr('required',true);
            //console.log('checked');
          }else{
            $("#calss_roll_field").addClass("d-none");
            $("#class_roll").attr('required',false);
            //console.log('unchecked');
          }
        });

    } );
    })(jQuery);
</script>
@endsection