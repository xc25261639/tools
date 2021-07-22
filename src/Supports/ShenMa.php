<?php

namespace tools\Supports;

use tools\Exceptions\InvalidConfigException;
use tools\Exceptions\InvalidSignException;
use tools\Supports\Traits\HttpRequest;

class ShenMa
{
    use HttpRequest;

    /**
     * Instance
     *
     * @var instance
     */
    private static $instance;

    /**
     * Get instance
     *
     * @author xiachao <25261639@qq.com>
     *
     * @return Client
     */
    public static function get_instance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * request api
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $array
     */
    public static function request_api(array $data, array $config, $service = '')
    {
        if (empty($data)) {
            throw new InvalidConfigException('request_api Missing -- [data]');
        }
        //发起请求
        if ($service == 'cashierPay') {//如果是调用收银台，则组装支付链接
            $bizNo = $data['bizNo'];
            $redirectUrl = urlencode($data['redirectUrl']);
            $merchantOrderNo = $data['merchantOrderNo'];
            $partnerId = $data['partnerId'];
            $service = $data['service'];
            $sign = $data['sign'];
            $version = $data['version'];
            $signType = $data['signType'];
            $url = self::get_url($config['mode']).'?bizNo='.$bizNo.'&merchantOrderNo='.$merchantOrderNo.'&partnerId='.$partnerId.'&redirectUrl='.$redirectUrl.'&service='.$service.'&sign='.$sign.'&signType='.$signType.'&version='.$version;
            return $url;
        }
        $result = self::service_post(self::get_url($config['mode']),$data,60);
        $result = json_decode($result,true);
        /*if ($result['status'] == 'FAIL' && !in_array($service,['registerUserAndValidate','registerEnterpriseUserAndValidate','bindingBankCard','queryUserWithdrawAmount','immediateWithdraw','onlyTransfer','enterpriseOpenAccount'])) {
            throw new InvalidSignException($service.$result['message']);
        }*/
        //验证签名
        if($service == 'electronicReceiptCreate'){
            return $result;
        }
        if (self::verify_sign($result, $config['secretKey'], $result['sign'])) {
            return $result;
        }
        throw new InvalidSignException($service.":Sign Verify FAILED");
    }

    // 通过curl post数据
    static public function service_post($url, $post_data = array(), $timeout = 60, $header = "") {
        $header = empty($header) ? '' : $header;
        $post_string = http_build_query($post_data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); //模拟的header头
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * verfiy sign
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array       $data
     * @param string      $public_key
     * @param string|null $sign
     *
     * @return bool
     */
    public static function verify_sign(array $data, $secretKey = null, $sign = null)
    {
        if (empty($data)) {
            throw new InvalidConfigException('verify_sign Missing -- [data]');
        }
        if (is_null($secretKey)) {
            throw new InvalidConfigException('verify_sign Missing Config -- [secretKey]');
        }
        if (is_null($sign)) {
            throw new InvalidConfigException('verify_sign Missing -- [sign]');
        }
        unset($data['sign']);
        //生成验证摘要
        $digest = self::generate_sign($data, $secretKey);
        if ($digest === $sign) {
            return true;
        }
        return false;
    }

    /**
     * generate sign
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param string $sign
     */
    public static function generate_sign(array $params, $secretKey = null)
    {
        if (is_null($secretKey)) {
            throw new InvalidConfigException('Missing Config -- [secretKey]');
        }
        //生成待签字符串
        $sign_content = self::get_sign_content($params, true, $secretKey);
        //摘要签名计算
        $sign = bin2hex(md5($sign_content,true));
        return $sign;
    }

    /**
     * Get signContent that is to be signed.
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     * @param bool  $verify
     *
     * @return string
     */
    public static function get_sign_content(array $data, $verify = false, $secretKey = null)
    {
        if (is_null($secretKey)) {
            throw new InvalidConfigException('get_sign_content :Missing Config -- [secretKey]');
        }

        ksort($data);
        $stringToBeSigned = '';
        foreach ($data as $k => $v) {
            if ($verify && $k != 'sign' && $k != 'sign_type') {
                $stringToBeSigned .= $k.'='.$v.'&';
            }
            if (!$verify && $v !== '' && !is_null($v) && $k != 'sign' && '@' != substr($v, 0, 1)) {
                $stringToBeSigned .= $k.'='.$v.'&';
            }
        }

        return trim($stringToBeSigned, '&').$secretKey;
    }

    /**
     * get url
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param string $mode
     * @param string $suffix_url
     *
     * @return string $url
     */
    private static function get_url($mode = '')
    {
        $url = 'http://api.shenmapay.com/gateway.html';
        if ($mode == 'dev'){
            $url = 'http://testapi.shenmapay.com:81/gateway.html';
        }
        return $url;
    }

}