<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <title>Admission Form</title>
    <style>
        @font-face {
            font-family: 'nikosh';
            /* src: url({{ storage_path('fonts\\kalpurush.ttf') }}) format('truetype'); */
            src: url({{ asset('/assets/admin/fonts/nikosh.ttf') }}) format('truetype');
            font-weight: 400; /* use the matching font-weight here ( 100, 200, 300, 400, etc). */
            font-style: normal; /* use the matching font-style here */
        }
        body {
            font-family: 'nikosh', sans-serif;
            font-size: 18px;
        }
        .text-center{
            text-align: center;
        }
        .m-0{margin: 0}

        .img-thumbnail{
            border: 2px solid #ddd;
            max-width: 100%;
        }

        .heading{
            position: relative;
        }
        .table{
            width: 100%;
        }

        .border-b{
            border-bottom: 1px solid #ddd;
        }

        .student_photo{
            position:absolute;
            top: 0;
            right: 0;
            width: 120px;
        }

    </style>
</head>
<body>
<div class="text-center">
    <img width="80" class="attachment-img" src="{{public_path('/upload/site_file/'.config('settings.siteLogo',''))}}" alt="{{ config('settings.siteTitle','') }}">
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
            <td width="15%"><img width="100" class="img-thumbnail" src="{{public_path('/storage/'.$student->photo)}}" alt=""></td>
        </tr>
    </table>
    
</div>
<p style="margin-top:0;">
    বরাবর <br>
    জেলা কালচারাল অফিসার <br>
    জেলা শিল্পকলা একাডেমী, নাটোর
</p>
<table class="table">
    <tr>
        <td>১) {{__('Department')}}</td>
        <td colspan="3" class="border-b">: @if($student->department){{$student->department->title}}@endif</td>
    </tr>
    <tr>
        <td>২) {{__('Name Of Student')}}</td>
        <td colspan="3" class="border-b">: {{$student->name}}</td>
    </tr>
    <tr>
        <td>৩) {{__('Father`s Name')}}</td>
        <td colspan="3" class="border-b">: {{$student->fathersName}}</td>
    </tr>
    <tr>
        <td>৪) {{__('Mother`s Name')}}</td>
        <td colspan="3" class="border-b">: {{$student->mothersName}}</td>
    </tr>
    <tr>
        <td colspan="4">৫) {{__('Present Address')}}</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;{{__('Village')}}</td>
        <td class="border-b">: {{$student->presentVillage}}</td>
        <td>&nbsp;&nbsp;&nbsp;{{__('Post Office')}}</td>
        <td class="border-b">: {{$student->presentPost}}</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;{{__('Upazila')}}</td>
        <td class="border-b">: @if($student->presentUpazilaName){{$student->presentUpazilaName->name}}@endif</td>
        <td>&nbsp;&nbsp;&nbsp;{{__('Zila')}}</td>
        <td class="border-b">: @if($student->presentZilaName){{$student->presentZilaName->name}}@endif</td>
    </tr>
    <tr>
        <td colspan="4">৬) {{__('Permanent Address')}}</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;{{__('Village')}}</td>
        <td class="border-b">: {{$student->permanentVillage}}</td>
        <td>&nbsp;&nbsp;&nbsp;{{__('Post Office')}}</td>
        <td class="border-b">: {{$student->permanentPost}}</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;{{__('Upazila')}}</td>
        <td class="border-b">: @if($student->permanentUpazilaName){{$student->permanentUpazilaName->name}}@endif</td>
        <td>&nbsp;&nbsp;&nbsp;{{__('Zila')}}</td>
        <td class="border-b">@if($student->permanentZilaName){{$student->permanentZilaName->name}}@endif</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;&nbsp;{{__('Educational Qualification')}}</td>
        <td colspan="3" class="border-b">: {{$student->shift}}</td>
    </tr>
    <tr>
        <td>৭) {{__('Date of Birth')}}</td>
        <td colspan="3" class="border-b">: {{shortDate($student->dateOfBirth)}}</td>
    </tr>    
    <tr>
        <td>৮) {{__('Educational Qualification')}}</td>
        <td colspan="3" class="border-b">: {{$student->shift}}</td>
    </tr>
    <tr>
        <td>৯) {{__('gardian_student_mobile')}}</td>
        <td colspan="3" class="border-b">: {{$student->gardian_student_mobile}}</td>
    </tr>
    <tr>
        <td>১০) {{__('student_group')}}</td>
        <td colspan="3" class="border-b">: {{$student->student_group}}</td>
    </tr>
    <tr>
        <td>১১) {{__('student_mobile')}}</td>
        <td colspan="3" class="border-b">: {{$student->student_mobile}}</td>
    </tr>
</table>
    
    <p>উপরোক্ত তথ্য সঠিক। ভর্তি করা হলে আমি জেলা শিল্প একাডেমি, নাটোরের সকল নিয়ম কানুন মেনে চলতে বাধ্য থাকব।</p>
<br> <br>
    <table class="table">
        <tr>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td align="center" style="border-top: 1px solid #000">অভিভাবকের স্বাক্ষর ও তারিখ</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td align="center" style="border-top: 1px solid #000">আবেদনকারীর স্বাক্ষর ও তারিখ</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
        </tr>
    </table>
    <p style="border-top: 1px solid #000; width:100%"></p>
    <p>জেলা শিল্প একাডেমি নাটোরের @if($student->department){{$student->department->title}}@endif প্রশিক্ষণ বিভাগে ভর্তির অনুমতি দেয়া হলো। <br>
        তারিখ: ............................... রশিদ নম্বর: ................................... রোল নম্বর: {{$student->reg_no}}
    </p>
    <br>
    <p style="text-align: right"><span style="border-top: 1px solid #000">জেলা কালচারাল অফিসার এর স্বাক্ষর ও তারিখ</p>
</body>
</html>