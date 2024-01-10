<?php

namespace App\Http\Controllers;

use App\Models\Permisson;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    function index(){
        $permissions=Permisson::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
       
        return view('admin.permission',compact('permissions'));
    }
    function store(Request $request){
        // return $request->input();
        $vadidated = $request->validate(
            [
                'name' =>'required|max:255',
                'slug' =>'required'
            ],
            [
                'required' => 'Trường :attribute không để trống',
                'max' => 'Trường :attribute không quá 255 ký tự'
            ],
            [
                'name' =>'quyền',
                'slug' => 'Slug'
                
            ],

            );

        Permisson::create([
            'name'=>$request->input('name'),
            'slug'=>$request->input('slug'),
            'description'=>$request->input('description'),

        ]);

        return redirect()->route('permission.index')->with('status', 'Thêm quyền mới thành công!');
    }

    function delete($id){
        Permisson::find($id)->delete();
        return redirect()->route('permission.index')->with('status', 'Xóa quyền thành công!');
    }

    function edit($id){
        $permissions=Permisson::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });

        $editPermission = Permisson::find($id);
        return view('admin.editPermission',compact('editPermission','permissions'));
        // return redirect()->route('permission.index')->with('status', 'Xóa quyền thành công!');
    }

    function update(Request $request,$id){
        $vadidated = $request->validate(
            [
                'name' =>'required|max:255',
                'slug' =>'required'
            ],
            [
                'required' => 'Trường :attribute không để trống',
                'max' => 'Trường :attribute không quá 255 ký tự'
            ],
            [
                'name' =>'quyền',
                'slug' => 'Slug'
                
            ],

            );
       Permisson::where('id', $id)->update([
        'name'=>$request->input('name'),
        'slug'=>$request->input('slug'),
        'description'=>$request->input('description'),
       ]);

       return redirect()->route('permission.index')->with('status', 'Chỉnh sửa quyền thành công!');
    }
}
