@extends('admin.layouts.layout')
@section('title',"Dashboard")
@section('css')
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')
  {{-- @livewire('dashboard') --}}
@endsection
@section('js')
<script src="{{ asset('assets/admin/plugins/moment/moment.min.js') }}"> </script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script>
    (function ($) {

      $('#reportrange').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
          },
          startDate: moment(),
          endDate  : moment()
        },
        function (startDate, endDate) {
          startDate = startDate.format('D-MM-YYYY');
          endDate = endDate.format('D-MM-YYYY');
          $('#reportrange span').html( startDate + ' - ' + endDate);
          Livewire.emit('dateChange', [startDate,endDate]);
        }
      );

      $('#reportrange span').html(moment().format('D-MM-YYYY') + ' - ' + moment().format('D-MM-YYYY'));

    })(jQuery)
  </script>
@endsection
