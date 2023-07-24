<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if($request->route()->action['namespace'] !== "Admin\Auth") {
            if (\Auth::check()) {
                $user = \Auth::user();
                $method = $request->method();
                $browser = $request->userAgent();
                $time = Carbon::now();
                $url = $request->getUri();
                $log = new Log();
                $log->name = $user->name;
                $log->email = $user->email;
                $log->ip = $request->ip();
                $log->browser = $browser;
                $log->method = $method;
                $log->url = $url;
                $log->time = $time;
                if ($request->isMethod('PUT') || $request->isMethod('PATCH') || $request->isMethod('DELETE')  && strpos($url, '/admin')) {
                    $model = $request->route()->action['wheres'];
                    $log->module = $model;
                    $parameterName = $request->route()->parameterNames[0];
                    $oldId = intval($request->route()->parameters[$parameterName]);
                    $oldData = $model::where('id', $oldId)->first();
                    if($request->isMethod('PUT') || $request->isMethod('PATCH')) {
                        $log->action = 'Người dùng' . $user->email . 'Đã chỉnh sửa bản ghi trong module';
                    } elseif($request->isMethod('DELETE')) {
                        $log->action = 'Người dùng' . $user->email . 'Đã xóa bản ghi trong module'  ;
                    }
                    if (!$oldData) {
                        var_dump('Model not found!');
                    } else {
                        $log->data = json_encode($oldData);
                    }
                } elseif($request->isMethod('GET') && strpos($url, '/admin')) {
                    $model = $request->route()->action['wheres'];
                    $log->module = $model;  
                    $log->data = "";
                    $log->action = 'Truy cập module';
                } elseif($request->isMethod('POST')  && strpos($url, '/admin')) {
                    $model = $request->route()->action['wheres'];
                    //$log->url = $url . $request->id; 
                    $log->module = $model;  
                    $log->data = json_encode($request->all());
                    $log->action = 'Tạo mới một bản ghi trong module';
                }
                $log->save();
            }
        } else {
            if ($request->route()->action['as'] == 'login.post') {
                $method = $request->method();
                $response = $next($request);
                $browser = $request->userAgent();
                $time = $response->headers->all()['date'][0];
                $url = $request->getUri();
                $log = new Log();
                $log->name = $request->email;
                $log->email = $request->email;
                $log->ip = $request->ip();
                $log->browser = $browser;
                $log->method = $method;
                $log->url = $url;
                $log->time = $time;
                $log->data = '';
                $log->module = '';
                $log->action = 'Người dùng ' . $request->email . ' '. 'đã đăng nhập vào hệ thống quản trị' ;
            } else {
                $method = $request->method();
                $response = $next($request);
                $browser = $request->userAgent();
                $time = $response->headers->all()['date'][0];
                $url = $request->getUri();
                $log = new Log();
                $log->ip = $request->ip();
                $log->browser = $browser;
                $log->method = $method;
                $log->url = $url;
                $log->time = $time;
                $log->data = '';
                $log->module = '';
                $log->action = 'Người dùng đã đăng xuất khỏi hệ thống quản trị' ;
            }
            $log->save();
        }
        return $next($request);
    }
}
