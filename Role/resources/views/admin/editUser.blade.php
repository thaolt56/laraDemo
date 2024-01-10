@extends('layouts.admin')

@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa người dùng
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'route' => ['user.update', $user]]) !!}

               
              <div class="form-group">
                {!! Form::label('name', 'Họ và tên') !!}
                {!! Form::text('name', $user->name, ['class' => 'form-control', 'id'=>'name']) !!}
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
             
              <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email',$user->email, ['class' => 'form-control', 'id'=>'email', 'readonly'=>'readonly']) !!}
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            
           <div class="form-group">
            {!! Form::label('role', 'Vai trò') !!}
           @php
               $selectedRoles = $user->roles->pluck('id')->toArray();
                $options = $roles->pluck('name','id')->toArray();

           @endphp
           {{-- {{dd($selectedRoles);}} --}}
            {!! Form::select('roles[]', $options, $selectedRoles, ['id' => 'role', 'class' => 'form-control', 'multiple'=>true]) !!}
           </div>
           
            {!! Form::submit('Chỉnh sửa', ['class' => 'btn btn-primary']) !!}
           
            {!! Form::close() !!}
           
        </div>
    </div>
</div>
@endsection