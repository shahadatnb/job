@extends('admin.layouts.layout')
@section('title',"Dashboard")
@section('content')

  <!-- Stat boxes -->
  <div class="row">
    <div class="col-lg-3 col-6">
      <a href="{{ route('applicant.index') }}" class="text-decoration-none">
        <div class="small-box bg-info">
          <div class="inner">
            <h3 id="box-applicants-value"><i class="fas fa-spinner fa-spin"></i></h3>
            <p>Total Applicants</p>
          </div>
          <div class="icon"><i class="fas fa-users"></i></div>
          <div class="inner text-right" style="position:absolute;right:10px;bottom:2px;">
            <small id="box-applicants-today"></small>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-6">
      <a href="{{ route('job.index') }}" class="text-decoration-none">
        <div class="small-box bg-success">
          <div class="inner">
            <h3 id="box-jobs-value"><i class="fas fa-spinner fa-spin"></i></h3>
            <p>Published Jobs</p>
          </div>
          <div class="icon"><i class="fas fa-briefcase"></i></div>
          <div class="inner text-right" style="position:absolute;right:10px;bottom:2px;">
            <small id="box-jobs-active"></small>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-6">
      <a href="{{ route('job.application') }}" class="text-decoration-none">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3 id="box-applications-value"><i class="fas fa-spinner fa-spin"></i></h3>
            <p>Total Applications</p>
          </div>
          <div class="icon"><i class="fas fa-file-import"></i></div>
          <div class="inner text-right" style="position:absolute;right:10px;bottom:2px;">
            <small id="box-applications-today"></small>
          </div>
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-6">
      <a href="{{ route('job.application') }}" class="text-decoration-none">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3 id="box-week-value"><i class="fas fa-spinner fa-spin"></i></h3>
            <p>Applications (Last 7 Days)</p>
          </div>
          <div class="icon"><i class="fas fa-calendar-week"></i></div>
        </div>
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card card-outline card-primary">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Applications Per Month</h3>
        </div>
        <div class="card-body">
          <canvas id="chart-monthly" style="width:100%;height:55px;" hidden></canvas>
          <div id="chart-monthly-loading" class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card card-outline card-secondary">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-venus-mars mr-1"></i> Applicants by Gender</h3>
        </div>
        <div class="card-body">
          <canvas id="chart-gender" style="width:100%;height:150px;" hidden></canvas>
          <div id="chart-gender-loading" class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-4">
      <div class="card card-outline card-info">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-layer-group mr-1"></i> Applications by Status</h3>
        </div>
        <div class="card-body">
          <canvas id="chart-status" style="width:100%;height:150px;" hidden></canvas>
          <div id="chart-status-loading" class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="card card-outline card-success">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-ranking-star mr-1"></i> Top 5 Jobs by Applications</h3>
        </div>
        <div class="card-body table-responsive p-0">
          <div id="top-jobs-loading" class="text-center py-4 text-muted"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
          <table class="table table-hover text-nowrap" id="top-jobs-table" hidden>
            <thead>
              <tr><th>SL</th><th>Job Title</th><th>Vacancy</th><th>Last Date</th><th class="text-right">Applications</th></tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script src="{{ asset('assets/admin/plugins/chart.js/Chart.min.js') }}"></script>
<script>
(function ($) {
  'use strict';

  var palette = ['#0079f2', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1', '#fd7e14', '#20c997'];

  var urls = {
    jobEdit: @js(route('job.edit', ['job' => '__ID__'])),
    applicantShow: @js(route('applicant.show', ['applicant' => '__ID__']))
  };

  function esc(value) {
    return $('<span>').text(value === null || value === undefined ? '' : value).html();
  }

  function loadWidget(url, onSuccess) {
    $.getJSON(url)
      .done(onSuccess)
      .fail(function (xhr) {
        console.error('Dashboard widget failed: ' + url, xhr.status);
      });
  }

  function makeDoughnut(canvasId, loadingId, labels, data) {
    $('#' + loadingId).hide();
    new Chart($('#' + canvasId)[0].getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{ data: data, backgroundColor: palette.slice(0, labels.length), hoverBackgroundColor: palette.slice(0, labels.length) }]
      },
      options: { maintainAspectRatio: false, legend: { position: 'bottom' } }
    });
  }

  // 1. Summary boxes
  loadWidget('{{ route('dashboard.summary') }}', function (d) {
    $('#box-applicants-value').text(d.applicants);
    $('#box-applicants-today').text('+' + d.applicants_today + ' today');
    $('#box-jobs-value').text(d.active_jobs);
    $('#box-jobs-active').text(d.expired_jobs + ' expired');
    $('#box-applications-value').text(d.applications);
    $('#box-applications-today').text('+' + d.applications_today + ' today');
    $('#box-week-value').text(d.applications_week);
  });

  // 2. Monthly applications line chart
  loadWidget('{{ route('dashboard.applications.monthly') }}', function (d) {
    $('#chart-monthly-loading').hide();
    new Chart($('#chart-monthly')[0].getContext('2d'), {
      type: 'line',
      data: {
        labels: d.labels,
        datasets: [{
          label: 'Applications',
          data: d.data,
          borderColor: palette[0],
          backgroundColor: 'rgba(0,121,242,.12)',
          fill: true,
          tension: 0.35,
          pointRadius: 3
        }]
      },
      options: {
        maintainAspectRatio: false,
        scales: { yAxes: [{ ticks: { beginAtZero: true, precision: 0 } }] },
        legend: { display: false }
      }
    });
  });

  // 3. Gender doughnut
  loadWidget('{{ route('dashboard.applicants.gender') }}', function (d) {
    if (!d.labels.length) { $('#chart-gender-loading').html('<span class="text-muted">No data</span>'); return; }
    makeDoughnut('chart-gender', 'chart-gender-loading', d.labels, d.data);
  });

  // 4. Status doughnut
  loadWidget('{{ route('dashboard.applications.status') }}', function (d) {
    if (!d.labels.length) { $('#chart-status-loading').html('<span class="text-muted">No data</span>'); return; }
    makeDoughnut('chart-status', 'chart-status-loading', d.labels, d.data);
  });

  // 5. Top jobs
  loadWidget('{{ route('dashboard.top-jobs') }}', function (rows) {
    $('#top-jobs-loading').hide();
    var $body = $('#top-jobs-table tbody').empty();
    if (!rows.length) {
      $('#top-jobs-table').removeAttr('hidden');
      $body.append('<tr><td colspan="5" class="text-center text-muted py-3">No applications yet</td></tr>');
      return;
    }
    $.each(rows, function (i, row) {
      $body.append(
        '<tr>' +
        '<td>' + (i + 1) + '</td>' +
        '<td><a href="' + urls.jobEdit.replace('__ID__', row.job_id) + '">' + esc(row.title) + '</a></td>' +
        '<td>' + esc(row.vacancy) + '</td>' +
        '<td>' + esc(row.last_date) + '</td>' +
        '<td class="text-right"><span class="badge badge-primary">' + row.applications + '</span></td>' +
        '</tr>'
      );
    });
    $('#top-jobs-table').removeAttr('hidden');
  });

})(jQuery);
</script>
@endsection
