<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <title>Certificate</title>
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
            font-size: 20px;
        }
        .certifecket{
            height: 100%;
            padding: 25px;
            border: 5px double black;
        }
        .text-center{
            text-align: center;
        }
        .m-0{margin: 0}

        .img-thumbnail{
            border: 2px solid #ddd;
            max-width: 100%;
        }

        .table{
            width: 100%;
        }

        .border-b{
            border-bottom: 1px solid #ddd;
        }

    </style>
</head>
<body>
    <div class="certifecket">
<div class="text-center">
    <img width="80" class="attachment-img" src="{{public_path('/upload/site_file/'.config('settings.siteLogo',''))}}" alt="{{ config('settings.siteTitle','') }}">
    <table class="table">
        <tr>
            <td width="15%"></td>
            <td width="70%" align="center">
                <div class="heading text-center">
                    <h2 class="text-center m-0">{{ config('settings.siteTitle','') }}</h2>
                    {{-- <p class="text-center m-0">{{ config('settings.tagLine') }}</p>
                    <p class="text-center m-0">({{ config('settings.siteWeb') }})</p> --}}
                </div>
            </td>
            <td width="15%"></td>
        </tr>
    </table>    
</div>
<h1 class="text-center">{{__('Certificate')}}</h1>
<br>  <br><br>{{-- --}}
<h1 class="m-0">{{$student->name}}</h1>
{{__('Father`s Name')}} : {{$student->fathersName}} <br>
{{__('Mother`s Name')}}: {{$student->mothersName}} <br>
{{__('Reg No')}} : {{CustomHelper::engtobn($student->reg_no)}}
<p>
    {{ config('settings.siteTitle','') }}-এর প্রশিক্ষণ বিভাগের আওতায় {{$student->department->title}} বিষয়ে {{CustomHelper::engtobn($student->department->durationYear)}} বছর মেয়াদী ফাউন্ডেশন কোর্স সম্পন্ন করেছে। <br>
    তার অর্জিত মান <b>{{$result}}</b>।
</p>
<br><br><br><br><br> <br><br><br><br>{{--   --}}
    <table class="table">
        <tr>
            <td>তারিখ: {{CustomHelper::engtobn(date("d-m-Y", strtotime($student->final_result_date)))}}</td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td width="40%" align="center" style="border-top: 1px solid #000">
                ({{config('settings.cultural_officer')}}) <br>
                জেলা কালচারাল অফিসার <br>
                জেলা শিল্পকলা একাডেমি, নাটোর
            </td>
            <td>&nbsp;</td>
        </tr>
    </table>
</div>
</body>
</html>