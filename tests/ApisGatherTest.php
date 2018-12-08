<?php

namespace Starrysea\Apis\Tests;

use Starrysea\Apis\Apis;
use Illuminate\Http\Request;

class ApisGatherTest
{
    public static function ordinary()
    {
//        return Apis::first()->success()->getJson(); // ['result'=>true, 'message'=>'操作成功']

//        return Apis::first()->success('', [
//            'title' => '你好, Laravel'
//        ])->getJson(); // ['result'=>true, 'message'=>'', 'data'=>['title'=>'你好, Laravel']]

//        return Apis::first()->success()->data([
//            'title' => '你好, Laravel'
//        ])->getJson(); // ['result'=>true, 'message'=>'操作成功', 'data'=>['title'=>'你好, Laravel']]

//        return Apis::first()->error()->getJson(); // ['result'=>false, 'message'=>'操作失败']

//        return Apis::first()->error('执行失败')->getJson(422); // ['result'=>false, 'message'=>'执行失败']

//        return Apis::first()->success()->attach('subsidiary', [
//            'title' => '你好, Laravel'
//        ])->getJson(); // ['result'=>true, 'message'=>'操作成功', 'subsidiary'=>['title'=>'你好, Laravel']]

        // all data will be escape, don't want escape use "->dataExcludeHtml(keyName)" cancel escape
        // attach data escape in third field open, fourth field can write cancel escape keyName
    }

    public static function jsonAndRedirect(Request $request)
    {
        return Apis::first()->success()->getRedirectJson($request); // is ajax obtain json, if not obtain back

//        return Apis::first()->success()->getRedirectJson($request,
//            'https://github.com/caixingyue/laravel-starrysea-apis'); // is ajax obtain json, if not obtain redirect

        // data and ordinary same, success obtain data way Session::all(), error obtain data way $errors->all()
    }

    public static function ajaxAndFunc(Request $request)
    {
        return Apis::first()->success()->getAjaxJson($request, '你好, laravel'); // if not ajax show: 你好, laravel

//        return Apis::first()->success()->getAjaxJson($request, view('index')); // if not ajax then show index view

//        return Apis::first()->success()->getAjaxJson($request, abort(404)); // if not ajax throw 404 error

//        return Apis::first()->success()->getAjaxJson($request, function ($request, $code){
//            dd($request, $code);
//        }); // if not ajax then show $request and $code 200

//        return Apis::first()->success()->getAjaxJson($request, function ($request, $code){
//            dd($request, $code);
//        }, 403); // if not ajax then show $request and $code 403
    }
}