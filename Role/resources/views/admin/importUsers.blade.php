@extends('layouts.admin')

@section('content')

<div class="card">
    <div class="card-header">
      Users import buy file CSV, excel
    </div>
    @error('file')
        <small class="text-danger">{{ $message }}</small>
    @enderror
    @if (!empty(session('status')))
        <div class="p-3 mb-2 bg-success text-white">{{session('status')}}</div>
    @endif
    @if (isset($errors) && $errors->any())
        @foreach ($errors->all() as $error)
            <div class="p-3 mb-2 bg-warning text-dark">{{$error}}</div>
        @endforeach
        
    @endif
    <div class="card-body">
        {!! Form::open(['method' => 'POST', 'route' => 'import.store', 'enctype'=>'multipart/form-data']) !!}
        
       <div class="form-group">
        {!! Form::label('file', 'Import CSV') !!}
        {!! Form::file('file', ['id' => 'file']) !!}
       </div>
       
       <div class="form-group">
        {!! Form::submit('Thêm file', ['class' => 'btn btn-success']) !!}
       </div>
              
        {!! Form::close() !!}
    </div>
  </div>
@endsection