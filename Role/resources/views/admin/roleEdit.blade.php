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
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Chỉnh sửa vai trò</h5>
            <div class="form-search form-inline">
                <form action="#">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST','route'=>['role.update', $role->id],'enctype'=>'multipart/form-data']) !!}
             
                <div class="form-group">
                    {!! Form::label('name', 'Tên vai trò') !!}
                    {!! Form::text('name', $role->name, ['class' => 'form-control','id'=>'name']) !!}
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    {{-- <label class="text-strong" for="name">Tên vai trò</label>
                    <input class="form-control" type="text" name="name" id="name"> --}}
                </div>
                <div class="form-group">
                    
                    {!! Form::label('description', 'Mô tả') !!}
                    {!! Form::textarea('description', $role->description, ['class' => 'form-control', 'id'=>'description','rows'=>3]) !!}
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    {{-- <label class="text-strong" for="description">Mô tả</label>
                    <textarea class="form-control" type="text" name="description" id="description"></textarea> --}}
                </div>
                <strong>Vai trò này có quyền gì?</strong>
                <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn quyền.</small>
                <!-- List Permission  -->
                @if (!empty($permissions))
                    @foreach ($permissions as $NameModule => $permissionModule)
                    <div class="card my-4 border">                  
                        <div class="card-header">                       
                            <label for="{{$NameModule}}">
                            {!! Form::checkbox('', '', null, ['id' => '$NameModule', 'class'=>'check-all']) !!} {{$NameModule}}
                            </label>                                              
                          

                            {{-- <input type="checkbox" class="check-all" name="" id="post">
                            <label for="post" class="m-0">Module Post</label> --}}
                        </div>
                      
                        <div class="card-body">                           
                            <div class="row">  
                                @foreach ($permissionModule as $permission)                           
                               <div class="col-md-3">                                                                                            
                                  <label for="{{$permission->name}}">
                                  {!! Form::checkbox('permission_id[]', $permission->id,in_array($permission->id, $role->permission->pluck('id')->toArray()), ['id' =>$permission->name,'class'=>'permission' ]) !!} {{$permission->slug}}
                                  </label>
                                                               
                                    {{-- <input type="checkbox" class="permission" value="2" name="permission_id[]" id="post.add">
                                    <label for="post.add">Add Post</label> --}}
                                </div>          
                                @endforeach                    
                            </div>                                                
                        </div>                                              
                  
                </div>
                    @endforeach
                    
                @else
                    <p>không có dữ liệu về quyền!!</p>
                @endif
              {!! Form::submit('Chỉnh sửa', ['class' => 'btn btn-primary']) !!}
                {{-- <input type="submit" name="btn-add" class="btn btn-primary" value="Thêm mới">
            --}}
            {!! Form::close() !!}
            
          
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $('.check-all').click(function () {
        $(this).closest('.card').find('.permission').prop('checked', this.checked)
      })
</script>
@endsection