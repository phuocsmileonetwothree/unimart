<?php

namespace App\Http\Middleware;

use App\Module;
use App\Permission;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module, $action)
    {
        $module = strtoupper($module);
        $action = strtoupper($action);
        $user_permissions = User::find(Auth::id())->user_permissions->toArray();
        $licensed = [];
        if (empty($user_permissions)) {
            return redirect()->route('admin.dashboard')->with('warning', 'Vui lòng liên hệ quản lý để đăng ký quyền');
        } else {
            foreach ($user_permissions as $value) {
                $user_module = Module::where('id', $value['module_id'])->first('title');
                $user_actions = Permission::find($value['permission_id'])->permission_details->toArray();
                foreach ($user_actions as $user_action) {
                    if ($user_action['check_action'] == 1) {
                        $licensed[strtoupper($user_module->title)][] = $user_action['action_code'];
                    }
                }
            }
        }
        // Check Module
        if(array_key_exists('ALL', $licensed)){
            if(in_array("ALL", $licensed['ALL'])){
                return $next($request);
            }elseif(in_array($action, $licensed['ALL'])){
                return $next($request);
            }else{
                return redirect()->route('admin.dashboard')->with('warning', 'Bạn chưa được đăng ký quyền cho Action này . Vui lòng liên hệ quản lý để biết thêm chi tiết');
            }
        }elseif(array_key_exists($module, $licensed)){
            if(in_array("ALL", $licensed[$module])){
                return $next($request);
            }elseif(in_array($action, $licensed[$module])){
                return $next($request);
            }else{
                return redirect()->route('admin.dashboard')->with('warning', 'Bạn chưa được đăng ký quyền cho Action này . Vui lòng liên hệ quản lý để biết thêm chi tiết');
            }
        }else{
            return redirect()->route('admin.dashboard')->with('warning', 'Bạn chưa được đăng ký quyền cho Action này . Vui lòng liên hệ quản lý để biết thêm chi tiết');
        }





    }
}
