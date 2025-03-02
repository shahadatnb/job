@extends('admin.layouts.layout')
@section('title',"Contacts Edit")
@section('css')
@endsection
@section('content')
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Contact Edit</h3>
        <div class="card-tools">
          <a href="{{ route('contact.index')}}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
    <div class="card-body">
      @if (request()->routeIs('contact.edit'))
        {!! Form::model($contact, array('route'=>['contact.update',$contact],'method'=>'PUT','files' => true)) !!}
      @else
        {!! Form::open(array('route'=>['contact.store'],'files' => true)) !!}          
      @endif
        @include('admin.layouts._message')
        <div class="form-group">
            {!! Form::label('name', __('Name'),['class'=>'']) !!}
            {!! Form::text('name',null,['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Name')]) !!}
        </div>      
        <div class="form-group">
            {!! Form::label('mobile', __('Mobile'),['class'=>'']) !!}
            {!! Form::text('mobile',null,['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Mobile')]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('category_id', __('Category'),['class'=>'']) !!}
            <div class="input-group">
              {!! Form::select('category_id',$categories,null,['class'=>'form-control select2','requerd'=>false,'placeholder'=> __('Category')]) !!}
              <div class="input-group-append">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoryModal">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
        </div> 
        <div class="form-group">
            {!! Form::label('note', __('Note'),['class'=>'']) !!}
            {!! Form::text('note',null,['class'=>'form-control','requerd'=>'requerd','placeholder'=> __('Note')]) !!}
        </div>         
        {{ Form::submit('Save',array('class'=>'btn btn-primary')) }}
      {!! Form::close() !!}
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        
    </div>
    <!-- /.card-footer-->
</div>
<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCategoryLabel">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['route' => 'add.contact.category', 'method' => 'POST', 'id' => 'addCategoryForm']) !!}
      <div class="modal-body">
          <div id="errorMsg">

          </div>
          <div class="input-group mb-2">
              {!! Form::label('category_name', __('Category Name'),['class'=>'col-3']) !!}
              {!! Form::text('name',null,['class'=>'form-control col-9', 'id'=>'category_name','placeholder'=> __('Category Name')]) !!}
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="addCategoryBtn" class="btn btn-primary">Save</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
<!-- /.card -->
@endsection
@section('js')
<script>
  $(function () {
      $('#addCategoryBtn').click(function(){
        let URL = $("#addCategoryForm").attr("action");
        $("#errorMsg").empty();
        fetch(URL, {
            method: 'post',
            credentials: "same-origin",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "X-Requested-With":'XMLHttpRequest'
            },
            body: new FormData(document.getElementById('addCategoryForm'))
        }).then(function(response){
            return response.json();
        }).then(function(json){
            if(json.status == false){
                json.errors.forEach(function(element){
                    $("#errorMsg").append(`<div class="alert alert-danger"><strong>Warning: </strong>${element}</div>`);
                });
            }else{
                console.log(json);
                $('#category_id').append(`<option value="${json.category.id}">${json.category.name}</option>`);
                $('#addCategoryForm').trigger("reset");
                $('#categoryModal').modal('hide');
            }

        })
         .catch(function(error){


         });
    });
  });
</script>
@endsection