@extends('layouts.admin')
@section('content')
@if (session('status'))
<div class="alert alert-primary d-flex align-items-center" role="alert">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
      <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
    <div>
     {{session('status')}}
    </div>
  </div>
@endif
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Chỉnh sửa quyền.
                </div>
                @if (!empty($editPermission))
                <div class="card-body">
                    {!! Form::open(['route' =>['permission.update',$editPermission->id],'method'=>'post']) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Tên quyền') !!}
                        {!! Form::text('name', $editPermission->name, ['class' => 'form-control', 'id' => 'name']) !!}
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                      
                        {!! Form::label('slug', 'Slug') !!}
                        <small class="form-text text-muted pb-2">Ví dụ: posts.add</small> 
                        {!! Form::text('slug', $editPermission->slug, ['class' => 'form-control', 'id' => 'slug']) !!}
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        
                    </div>
                    <div class="form-group">
                    
                        {!! Form::label('description', 'Mô tả') !!}
                        {!! Form::textarea('description', $editPermission->description, ['class' => 'form-control', 'id' => 'description']) !!}
                    
                      
                    </div>
                    {!! Form::submit('Chỉnh sửa', ['class' => 'btn btn-primary']) !!}
                    
                    {!! Form::close() !!}
                </div>
                @endif
                
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách quyền
                </div>
                <div class="card-body">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên quyền</th>
                                <th scope="col">Slug</th>
                                <th scope="col">Tác vụ</th> 
                            </tr>
                        </thead>
                        @if (!empty($permissions))
                        <tbody>
                            @php
                               $i = 1; 
                            @endphp
                            @foreach ($permissions as $moduleName => $modulePermissions)
                            <tr>
                                <td scope="row"></td>
                                <td><strong>Module {{$moduleName}}</strong></td>
                                <td></td>
                                <td></td>
                                @foreach ( $modulePermissions as $modulePermission)
                                <tr>
                                    <td scope="row">{{$i++}}</td>
                                    <td>|---{{$modulePermission->name}}</td>
                                    <td>{{$modulePermission->slug}}</td>
                                    <td>
                                        <a href="{{route('permission.edit',$modulePermission->id)}}" class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('permission.delete',$modulePermission->id)}}"  class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                 
                                    </td>
                                </tr>
                               
                                @endforeach
                            </tr>
                            @endforeach
                           
                           
                            
                        </tbody>
                        @endif
                       
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection