<?php

namespace App\Http\Controllers\Adminstrator;

use App\Http\Controllers\Controller;
use App\Module;
use App\Permission;
use App\Role;
use App\User;
use App\User_Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'user']);

            return $next($request);
        });
    }
    
    public function profile(){
        $info = User::find(Auth::id());
        $result = $info->user_permissions->pluck('permission_id', 'module_id')->toArray();
        $permissions = [];
        foreach($result as $key => $value){
            $permissions[] = convert_permission($key, $value);
        }
        // dd($result);

        return view('admin.user.profile', compact('info', 'permissions'));
    }

    public function edit_info(){
        $user = User::find(Auth::id());
        return view('admin.user.edit_info', compact('user'));
    }

    public function update_info(Request $request, $id){
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'old_password' => ['nullable'],
                'password' => ['nullable', 'string', 'min:8'],
                'password_confirm' => ['nullable', 'same:password'],
            ],
            [
                'required' => ":attribute không được để trống",
                'string' => ":attribute phải là 1 chuỗi ký tự",
                'max' => ":attribute tối đa có  255 ký tự",
                'min' => ":attribute tối thiểu có 8 ký tự",
                'same' => 'Mật khẩu và xác nhận mật không trùng nhau',
            ],
            [
                'name' => 'Họ và tên',
                'old_password' => 'Mật khẩu cũ',
                'password' => 'Mật khẩu',
                'password_confirm' => 'Xác nhận mật khẩu',
            ]
        );

        $data = ['name' => $request->input('name')];
        if(!empty($request->input('password'))){
            if(Hash::check($request->input('old_password'), Auth::user()->password)){
                $data['password'] = Hash::make($request->input('password'));
            }else{
                return redirect()->back()->with('error', "Mật khẩu cũ không trùng khớp");
            }
        }

        User::find($id)->update($data);
        return redirect()->route('admin.user.profile')->with('success', 'Đã cập nhật thông tin');

    }
}
