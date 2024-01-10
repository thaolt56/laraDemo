<?php

namespace App\Http\Controllers;
use App\Models\Permisson;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    function index(){
        $roles = Role::all();
        return view('admin.Role',compact('roles'));
    }

    function add(){
        $permissions=Permisson::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
        return view('admin.roleAdd',compact('permissions'));
    }
   
    function store(Request $request){
        // dd($request->input('permission_id'));
        $vadidated = $request->validate(
            [
                'name' =>'required|unique:roles,name',
                'description' =>'required',
                'permission_id' =>'nullable|array',
                // 'permission_id.*' =>'exists:permissons, id',

            ],
            [
                'required' => ' :attribute không để trống',
                'max' => 'Trường :attribute không quá 255 ký tự',
                'unique' => 'Tên đã tồn tại trong hệ thống'
            ],
            [
                'name' =>'Vai trò',
                'description' => 'Mô tả'                
            ],

            );
        try {
            DB::beginTransaction();
            $role = Role::create([
                'name'=>$request->input('name'),
                'description'=>$request->input('description')
            ]);
            $ids = $request->input('permission_id');
            $role->permission()->attach($ids);
            DB::commit();
            return redirect()->route('role.index')->with('status', 'Thêm vai trò mới thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Message:'. $e->getMessage().'...Line'. $e->getLine());
        }
       
    }

    function edit(Role $role){
        $permissions=Permisson::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
      
        return view('admin.roleEdit', compact('role', 'permissions'));
    }
    function update(Request $request, Role $role){
    //    dd($request->input('permission_id',[]));
       $request->validate(
            [
                'name' =>'required|unique:roles,name,' .$role->id,
                'permission_id' =>'nullable|array',
                // 'permission_id.*' =>'exists:permissons, id',

            ],
            [
                'required' => ' :attribute không để trống',
                'max' => 'Trường :attribute không quá 255 ký tự',
                'unique' => 'Tên đã tồn tại trong hệ thống'
            ],
            [
                'name' =>'Vai trò',
                'description' => 'Mô tả'
                
            ],

            );


        try {
            DB::beginTransaction();
            $role ->update([
                'name'=>$request->input('name'),
                'description'=>$request->input('description')
            ]);
          
            $role->permission()->sync($request->input('permission_id',[]));
            DB::commit();
            return redirect()->route('role.index')->with('status', 'Chỉnh sửa vai trò thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Message:'. $e->getMessage().'...Line'. $e->getLine());
        }
    }

    function delete(Role $role){
        $role->delete();
        return redirect()->route('role.index')->with('status', 'Bạn đã xóa vai trò thành công!');
    }
}
