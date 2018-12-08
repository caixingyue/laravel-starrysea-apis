<?php

namespace Starrysea\Apis;

use Illuminate\Http\Request;
use Starrysea\Arrays\Arrays;

class Apis
{
    private $result = '', $message = '', $data = [], $attach = [], $dataExcludeHtml = [];

    /**
     * 初始化
     * @return Apis
     */
    public static function first()
    {
        return new self;
    }

    /**
     * 成功返回信息
     * @param string $message 提示
     * @param array $data 数据
     * @return $this
     */
    public function success(string $message = '操作成功', array $data = [])
    {
        $this->result  = true;
        $this->message = $message;
        $this->data($data);
        return $this;
    }

    /**
     * 错误返回信息
     * @param string $message 提示
     * @param array $data 数据
     * @return $this
     */
    public function error(string $message = '操作失败', array $data = [])
    {
        $this->result  = false;
        $this->message = $message;
        $this->data($data);
        return $this;
    }

    /**
     * 追加data数据, 后面的覆盖前面的
     * @param array $data 数据
     * @return $this
     */
    public function data(array $data = [])
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * 追加字段
     * @param string $name 字段名
     * @param string|array|object|int $data 数据
     * @param bool $htmlspecialchars true => 开启html过滤, false => 不过滤html
     * @param string|array $htmlspecialcharsExclude 排除过滤字段,开启过滤时有效
     * @return $this
     */
    public function attach(string $name, $data = '', bool $htmlspecialchars = false, $htmlspecialcharsExclude = '')
    {
        $data = $htmlspecialchars ? (is_array($data) ? Arrays::htmlspecialchars($data,
            Arrays::toArray($htmlspecialcharsExclude)) : e($data)) : $data;

        $this->attach = array_merge($this->attach, [$name => $data]);
        return $this;
    }

    /**
     * 排除data数据过滤
     * @param string|array $dataKey 过滤的字段
     * @return $this
     */
    public function dataExcludeHtml($dataKey = [])
    {
        $this->dataExcludeHtml = Arrays::toArray($dataKey);
        return $this;
    }

    /**
     * 获取json数据并返回
     * @param int $code 状态码,默认200
     * @return array|object|\Illuminate\Http\JsonResponse|mixed
     */
    public function getJson(int $code = 200)
    {
        $data = self::combination();
        $data = response()->json($data, $code);
        return $data;
    }

    /**
     * 获取结果json数据或跳转并携带数据
     * @param Request $request 请求的数据, ajax => 获得json, 否则后退并返回数据
     * @param string $redirect 存在时跳转并携带参数
     * @param int $code 状态码,默认200
     * @return array|object|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|mixed
     */
    public function getRedirectJson(Request $request, string $redirect = '', int $code = 200)
    {
        if ($request->ajax()){
            return self::getJson($code);
        }else{
            $data = self::combination();
            if ($redirect && $this->result){
                return redirect($redirect)->with($data);
            }elseif ($redirect){
                return redirect($redirect)->withErrors($data);
            }elseif (!$this->result){
                return back()->withErrors($data);
            }else{
                return back()->with($data);
            }
        }
    }

    /**
     * 获取结果json数据或返回特定数据
     * @param Request $request 请求的数据, ajax => 获得json, 否则返回特定数据
     * @param static|array|bool|object|callable|int $regress 返回的特定数据
     * @param int $code 状态码,默认200
     * @return array|object|\Illuminate\Http\JsonResponse|mixed|$code
     */
    public function getAjaxJson(Request $request, $regress, int $code = 200)
    {
        if ($request->ajax()){
            return self::getJson($code);
        }elseif (is_callable($regress)){
            return $regress($request, $code);
        }else{
            return $regress;
        }
    }

    /**
     * 组合数据
     * @return array
     */
    private function combination()
    {
        $data = [];

        data_set($data, 'result', $this->result);
        data_set($data, 'message', $this->message);

        if ($this->data)
            data_set($data, 'data', Arrays::htmlspecialchars($this->data, $this->dataExcludeHtml));

        $data = array_merge($this->attach, $data);
        return $data;
    }
}
