<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <title>Marksheet</title>
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
            border-spacing: 0;
        }

        .table-border th,.table-border td{
            border: 1px solid #000;
        }

        .table-border th{
            font-weight: bold;
        }

        .border-b{
            border-bottom: 1px solid #ddd;
        }

        .certifecket{
            height: 100%;
            padding: 10px;
            border: 5px double black;
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
                </div>
            </td>
            <td width="15%"></td>
            {{-- <td width="15%"><img width="100" class="img-thumbnail" src="{{public_path('/storage/'.$student->photo)}}" alt=""></td> --}}
        </tr>
    </table>    
</div>
    <h1 class="text-center">{{__('Marksheet')}}</h1>

    <table class="table">
        <tr>
            <td width="60%">
                <table class="table" style="font-size: 20px">
                    <tr><td>নাম: {{$student->name}}</td></tr>
                    <tr><td>পিতার নাম: {{$student->fathersName}}</td></tr>
                    <tr><td>মাতার নাম: {{$student->mothersName}}</td></tr>
                    <tr><td>আইডি নং: {{CustomHelper::engtobn($student->reg_no)}}</td></tr>
                    <tr><td>অর্জিত মান: {{$result}}</td></tr>
                    {{-- <tr><td>গড় নম্বর: </td></tr> --}}
                    
                </table>
            </td>
            <td>
                <table class="table table-border">
                    <thead>
                        <tr>
                            <th colspan="2" align="center">মান বন্টন</th>
                        </tr>
                        <tr>
                            <th align="center">নম্বর</th>
                            <th align="center">মান</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center">১০০-৮০</td>
                            <td align="center">অতি উত্তম</td>
                        </tr>
                        <tr>
                            <td align="center">৭৯-৬০</td>
                            <td align="center">উত্তম</td>
                        </tr>
                        <tr>
                            <td align="center">৫৯-৫০</td>
                            <td align="center">মধ্যম</td>
                        </tr>
                        <tr>
                            <td align="center">৪৯-৪০</td>
                            <td align="center">শোভন</td>
                        </tr>
                        <tr>
                            <td align="center">৩৯-০</td>
                            <td align="center">অকৃতকার্য</td>
                        </tr>
                    </tbody>
                </table>
<br>
                <table class="table table-border">
                    <thead>
                        <tr>
                            <th colspan="2" align="center">প্রাপ্ত নম্বর বন্টন</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center">উপস্থিতি</td>
                            <td align="center">৫০%</td>
                        </tr>
                        <tr>
                            <td align="center">লিখিত</td>
                            <td align="center">২৫%</td>
                        </tr>
                        <tr>
                            <td align="center">মৌখিক</td>
                            <td align="center">২৫%</td>
                        </tr>
                        <tr>
                            <td align="center">সর্বমোট	</td>
                            <td align="center">১০০%</td>
                        </tr>
                    </tbody>                    
                </table>
            </td>
        </tr>
    </table>
    <br>
    <h2 class="text-center">বর্ষ অনুযায়ি প্রাপ্ত নম্বর</h2>
    <table class="table table-border">
        <thead>
            <tr>
                <th align="center">বর্ষ</th>
                <th align="center">উপস্থিতি(%)</th>
                <th align="center">লিখিত</th>
                <th align="center">মৌখিক</th>
                <th align="center">মোট</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_marks = 0;
            @endphp
            @foreach ($marks as $mark)
                <tr>
                    <td>{{CustomHelper::engtobn($mark->semester->title)}}</td>
                    <td>{{CustomHelper::engtobn($mark->attendance)}}</td>
                    <td>{{CustomHelper::engtobn($mark->written_marks)}}</td>
                    <td>{{CustomHelper::engtobn($mark->oral_marks)}}</td>
                    @php
                        $markst = $mark->attendance+$mark->written_marks+$mark->oral_marks;
                        $total_marks += $markst;
                    @endphp
                    <td>{{CustomHelper::engtobn($markst)}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">সর্বমোট প্রাপ্ত নম্বর</td>
                <td>{{CustomHelper::engtobn($total_marks)}}</td>
            </tr>
            <tr>
                <td colspan="4">গড় নম্বর</td>
                <td>{{CustomHelper::engtobn($marks->sum('total_marks')/$student->department->durationYear)}}</td>
            </tr>
            <tr>
                <td colspan="4">অর্জিত মান</td>
                <td>{{$result}}</td>
            </tr>
        </tbody>
    </table>
    <br><br><br><br>
    <table class="table">
        <tr>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td align="center">&nbsp;&nbsp;&nbsp;</td>
            <td>&nbsp;&nbsp;&nbsp;</td>
            <td width="40%" align="center" style="border-top: 1px solid #000">
                ({{config('settings.cultural_officer')}}) <br>
                জেলা কালচারাল অফিসার <br>
                জেলা শিল্পকলা একাডেমি, নাটোর
            </td>
            <td width="5%">&nbsp;&nbsp;</td>
        </tr>
    </table>
</div>
</body>
</html>