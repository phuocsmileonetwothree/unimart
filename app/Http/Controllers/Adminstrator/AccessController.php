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

class AccessController extends Controller
{
    function __construct(Request $request)
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'access']);

            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $key = '';
        $count = [
            'active' => User::get()->count(),
            'trash' => User::onlyTrashed()->count(),
        ];
        if ($request->input('status') === 'trash') {
            $users = User::onlyTrashed()->paginate(10);
            $users->destroy_or_forceDelete = 'forceDelete';
            $users->confirm = "Bạn chắc chắn xóa vĩnh viễn tài khoản và không thể phục hồi . Những tài nguyên của hệ thống do thành viên này tạo sẽ được chuyển thành không rõ tác giả";
            $users->list_action = ['' => 'Chọn', 'restore' => 'Phục hồi tài khoản', 'force_delete' => 'Xóa vĩnh viễn'];
        } else {
            if ($request->input('key') !== null) {
                $key = $request->input('key');
            }
            $users = User::where('name', 'LIKE', "%{$key}%")->paginate(10);
            $users->destroy_or_forceDelete = 'destroy';
            $users->confirm = "Bạn chắc chắn vô hiệu hóa tài khoản . Tài khoản vô hiệu hóa sẽ tự động logout trong lần refresh tiếp theo";
            $users->list_action = ['' => 'Chọn', 'destroy' => 'Vô hiệu hóa tài khoản'];
        }

        $index = ($users->perPage() * $users->currentPage()) - $users->perPage() + 1;
        return view('admin.access.list', compact('users', 'index', 'key', 'count'));
    }

    public function action(Request $request)
    {

        $list_check = $request->input('list_check');
        $action = $request->input('action');
        if (isset($_POST['btn_action']) and !empty($action)) {
            if (!empty($list_check)) {

                if (in_array(Auth::id(), $list_check)) {
                    $list_check = array_diff($list_check, [Auth::id()]);
                    if ($action == 'destroy') {
                        User::destroy($list_check);
                    }
                    if ($action == 'restore') {
                        foreach ($list_check as $value) {
                            User::onlyTrashed()->where('id', '=', $value)->restore();
                        }
                    }
                    if ($action == 'force_delete') {
                        User::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    }
                    return redirect()->route('admin.access.list')->with('warning', "Đã áp dụng thành công thao tác cho các thành viên trừ bạn");
                } else {
                    if ($action == 'destroy') {
                        User::destroy($list_check);
                    }
                    if ($action == 'restore') {
                        foreach ($list_check as $value) {
                            User::onlyTrashed()->where('id', '=', $value)->restore();
                        }
                    }
                    if ($action == 'force_delete') {
                        User::onlyTrashed()->whereIn('id', $list_check)->forceDelete();
                    }
                    return redirect()->route('admin.access.list')->with('success', "Đã áp dụng thành công thao tác cho các thành viên");
                }
            }
            return redirect()->route('admin.access.list')->with('warning', 'Vui lòng chọn thành viên');
        }
        return redirect()->route('admin.access.list')->with('warning', 'Vui lòng chọn thao tác áp dụng');
    }

    public function create()
    {
        $roles = Role::where([['id', "!=", 1], ['title', "!=", 'Quản lý']])->pluck('title', 'id');
        $modules = Module::where([['id', "!=", 1], ['title', "!=", 'All']])->get();
        $permissions = Permission::where([['id', "!=", 1], ['title', "!=", 'All']])->get();
        return view('admin.access.create', compact('roles', 'modules', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'password_confirm' => ['required', 'same:password'],
                'role_id' => ['required'],
                'check_permission' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'string' => ":attribute phải là 1 chuỗi ký tự",
                'role_id.required' => "Chọn :attribute cho thành viên",
                'check_permission.required' => "Đăng ký :attribute cho thành viên",
                'max' => ":attribute tối đa có  255 ký tự",
                'min' => ":attribute tối thiểu có 8 ký tự",
                'email' => ":attribute phải có định dạng như sau : your_email@email.com",
                'unique' => ":attribute đã tồn tại trong hệ thống",
                'same' => 'Mật khẩu và xác nhận mật không trùng nhau',
            ],
            [
                'name' => 'Họ và tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'password_confirm' => 'Xác nhận mật khẩu',
                'role_id' => 'vai trò',
                'check_permission' => 'quyền',
            ]
        );
        // dd($request->all());
        $data = $request->all('name', 'email', 'password', 'role_id');
        $user_instance = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['role_id']
        ]);
        if (!empty($user_instance)) {
            foreach ($request->input('check_permission') as $key => $permission) {
                if (is_array($permission)) {
                    foreach ($permission as $key_permission => $value_permission) {
                        $data_permission = [
                            'permission_id' => $value_permission,
                            'user_id' => $user_instance->id,
                            'module_id' => $key,
                            'licensed' => '1',
                        ];
                        User_Permission::create($data_permission);
                    }
                } else {
                    $data_permission = [
                        'permission_id' => 1,
                        'user_id' => $user_instance->id,
                        'module_id' => $key,
                        'licensed' => '1',
                    ];
                    User_Permission::create($data_permission);
                }
            }
        }



        return redirect()->route('admin.access.list')->with('success', 'Đã thêm thành viên');
    }

    public function destroy($id)
    {
        if (Auth::id() != $id) {
            $result = User::destroy($id);
            return redirect()->route('admin.access.list')->with('success', 'Đã vô hiệu hóa thành viên');
        } else {
            return redirect()->route('admin.access.list')->with('error', 'Bạn không thể vô hiệu hóa chính mình');
        }
    }

    public function forceDelete($id)
    {
        User::onlyTrashed()->where('id', '=', $id)->forceDelete();
        return redirect()->route('admin.access.list')->with('success', "Đã xóa vĩnh viễn thành viên");
    }

    public function edit($id)
    {
        $user_permissions = [];
        $user = User::withTrashed()->find($id);

        foreach ($user->user_permissions->toArray() as $item) {
            if (array_key_exists($item['module_id'], $user_permissions)) {
                $tmp = $user_permissions[$item['module_id']];
                $user_permissions[$item['module_id']] = [];
                if (is_array($tmp)) {
                    foreach ($tmp as $value_tmp) {
                        $user_permissions[$item['module_id']][] = $value_tmp;
                    }
                } else {
                    $user_permissions[$item['module_id']][] = $tmp;
                }
                $user_permissions[$item['module_id']][] = $item['permission_id'];
            } else {
                $user_permissions[$item['module_id']] = $item['permission_id'];
            }
        }

        $roles = Role::where([['id', "!=", 1], ['title', "!=", 'Quản lý']])->pluck('title', 'id');
        $modules = Module::where([['id', "!=", 1], ['title', "!=", 'All']])->get();
        $permissions = Permission::where([['id', "!=", 1], ['title', "!=", 'All']])->get();
        return view('admin.access.edit', compact('user', 'roles', 'modules', 'permissions', 'user_permissions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'password' => ['nullable', 'string', 'min:8'],
                'role_id' => ['required'],
                'check_permission' => ['required'],
            ],
            [
                'required' => ":attribute không được để trống",
                'string' => ":attribute phải là 1 chuỗi ký tự",
                'role_id.required' => "Chọn :attribute cho thành viên",
                'check_permission.required' => "Đăng ký :attribute cho thành viên",
                'max' => ":attribute tối đa có  255 ký tự",
                'min' => ":attribute tối thiểu có 8 ký tự",
            ],
            [
                'name' => 'Họ và tên',
                'password' => 'Mật khẩu',
                'role_id' => 'vai trò',
                'check_permission' => 'quyền',
            ]
        );


        $data = [
            'name' => $request->input('name'),
            'role_id' => $request->input('role_id'),
        ];
        if(!empty($request->input('password'))){
            $data['password'] = Hash::make($request->input('password'));
        }
        User::find($id)->update($data);
        $old_permission = User_Permission::where('user_id', $id)->pluck('id')->toArray();
        User_Permission::destroy($old_permission);
        foreach ($request->input('check_permission') as $key => $permission) {
            if (is_array($permission)) {
                foreach ($permission as $key_permission => $value_permission) {
                    $data_permission = [
                        'permission_id' => $value_permission,
                        'user_id' => $id,
                        'module_id' => $key,
                        'licensed' => '1',
                    ];
                    User_Permission::create($data_permission);
                }
            } else {
                $data_permission = [
                    'permission_id' => 1,
                    'user_id' => $id,
                    'module_id' => $key,
                    'licensed' => '1',
                ];
                User_Permission::create($data_permission);
            }
        }
        return redirect()->route('admin.access.list', $id)->with('success', 'Đã cập nhật thông tin thành viên');
    }
}
