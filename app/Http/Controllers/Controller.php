<?php

namespace App\Http\Controllers;

use App\Constants\ErrorCode;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 验证规则
     *
     * @var array
     */
    public $rules = [
        'store'  => [],
        'update' => []
    ];

    /**
     * 错误提示消息
     *
     * @var array
     */
    public $messages = [
        'required'        => ':attribute字段必填.',
        'app_key.unique'  => '应用key已存在',
        'app_name.unique' => '应用名称已存在',
    ];

    /**
     * 错误字段名
     *
     * @var array
     */
    public $customAttributes = [
        "email" => "邮箱",
    ];


    /**
     * 校验实例
     *
     * @var null|\Illuminate\Validation\Validator
     */
    private $validator = null;


    /**
     * 获取指定参数
     *
     * @param null $key
     * @param null $default
     * @param bool $trim
     *
     * @return array|null|string
     */
    public function getParam($key = null, $default = null, $trim = true)
    {
        $param = request()->input($key, $default);
        if ($param && is_string($param) && $trim) {
            $param = trim($param);
        }
        return $param;
    }

    /**
     * 获取所有参数
     *
     * @param bool $trim
     *
     * @return array|null|string
     */
    public function getParams($trim = true)
    {
        $params = request()->input();

        unset($params['_method']);
        unset($params['_token']);
        if ($params) {
            if ($trim) {
                foreach ($params as $key => &$param) {
                    if (is_string($param)) {
                        $param = trim($param);
                    }
                }
            }
        }
        return $params;
    }

    /**
     * response返回
     *
     * @param array $array
     *
     * @return array
     */
    public function ajax($array = [])
    {
        return $array;
    }

    /**
     * 成功返回
     *
     * @param null|string  $message
     * @param array|string $data
     * @param array        $code 取值于ErrorCode
     *
     * @return array
     */
    public function ajaxSuccess($data = [], $message = null, $code = ErrorCode::NO_ERROR)
    {
        if (empty($message) && isset($code['message'])) {
            $message = $code['message'];
        }

        if (empty($message)) {
            $message = ErrorCode::NO_ERROR['message'];
        }

        return $this->ajax([
            'code'    => $code['code'],
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * 错误返回
     *
     * @param null|string  $message
     * @param array|string $data
     * @param array        $code 取值于ErrorCode
     *
     * @return array
     */
    public function ajaxError($code = ErrorCode::ERROR, $message = null, $data = [])
    {
        if (isset($code['message'])) {
            $message = $code['message'] . ":" . $message;
        }

        if (empty($message)) {
            $message = ErrorCode::ERROR['message'];
        }

        return $this->ajax([
            'code'    => $code['code'],
            'message' => $message,
            'data'    => $data,
        ]);
    }


    /**
     * 验证
     *
     * @param        $data
     * @param string $scope
     *
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    public function validate($data, $scope = 'store')
    {
        //创建静态规则validator实例
        $this->validator = Validator::make($data, $this->rules[$scope], $this->messages, $this->customAttributes);

        return $this->validator;
    }

    /**
     * 验证是否验证错误
     *
     * @return bool
     */
    public function isFails()
    {
        return $this->validator->fails();
    }

    /**
     * 跳转页面，并携带成功提示
     *
     * @param string      $url
     * @param string|null $message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function success($url, $message = '')
    {
        $message = null === $message ? ErrorCode::NO_ERROR['message'] : $message;
        return redirect($url)->with("message", $message);
    }

    /**
     * 返回原页面，并携带错误信息
     *
     * @param array $error_code
     * @param null  $message
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function error($error_code = [], $message = null)
    {
        $back = back()->withInput();

        //将View的全局共享errorBag实例放入session，避免重新生成新实例
        //以确保将要写入的errors信息能正确被view模板获取
        if($sharedErrorBag = View::shared('errors')){
            session()->put('errors', $sharedErrorBag);
        }

        if (!empty($error_code)) {
            $error_code = empty($error_code) ? ErrorCode::ERROR : $error_code;
            $message    = empty($message) ? $error_code['message'] : $error_code['message'] . " " . $message;
            $attr_name  = empty($attr_name) ? "error_code_" . $error_code['code'] : $attr_name;
            $back->withErrors([$attr_name => $message]);
        } else {
            $back->withErrors($this->validator);
        }
        return $back;
    }
}
