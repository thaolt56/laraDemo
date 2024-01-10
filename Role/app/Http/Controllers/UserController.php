<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Role;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsErrors;
class UserController extends Controller
{   

    //import CSV
    function importUsers(){
        return view('admin.importUsers');
    }

    function importStore(Request $request){
        $request->validate(
            [
                'file' =>'required|mimes:xls,csv,xlsx,txt',
            ]
        );
       if( $file = $request->file('file')){

        try{
            $import = new UsersImport();
            $import->import($file);
                return back()->with('status', 'import thành công file danh sách!!');
              
            // dd($import->errors());
        } catch(\Maatwebsite\Excel\Validators\ValidationException $e){
            $msg = '';
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $msg = 'Ry '.$failure->row(); // row that went wrong
                $msg = $msg.' vir hoof '.$failure->attribute(); // either heading key (if using heading row concern) or column index
                $msg = $msg.'. '.$failure->errors()[0]; // Actual error messages from Laravel validator
                // $msg = $msg.' : met waarde '.$failure->values(); // The values of the row that has failed: not available in version
            }
            return back()->with('status', $msg);
        }
      
        return back()->with('status', 'Lêer nie gevind nie');
       }
      
        
        
        
    }



    function edit(User $user){
        $roles = Role::all();
        return view('admin.editUser',compact('user','roles'));
    }

    function update(Request $request, User $user){
    //    dd($request->input('roles'));
        $request->validate(
        [
            'name' =>'required|unique:users,name,' .$user->id,
            'roles' =>'nullable|array',
            // 'permission_id.*' =>'exists:permissons, id',

        ],
        [
            'required' => ' :attribute không để trống',
            'max' => 'Trường :attribute không quá 255 ký tự',
            'unique' => 'Tên đã tồn tại trong hệ thống'
        ],
        [
            'name' =>'User',            
        ],

        );
        try {
            DB::beginTransaction();
            $user ->update([
                'name'=>$request->input('name'),
            ]);
          
            $user->roles()->sync($request->input('roles'));
            DB::commit();
            return redirect()->route('user.list')->with('status', 'Chỉnh sửa user thành công!');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Message:'. $e->getMessage().'...Line'. $e->getLine());
        }

    }

    function list(){
        $users = User::paginate(5);
        return view('admin.listUser',compact('users'));
    }

   function delete(User $user){
       $user->delete();
        return redirect()->route('user.list')->with('status', 'Bạn đã xóa thành công!');
   }

    
}
