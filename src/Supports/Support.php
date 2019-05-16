<?php

namespace Sanxiapay\Supports;

use Sanxiapay\Exceptions\InvalidConfigException;
use Sanxiapay\Exceptions\InvalidSignException;
use Sanxiapay\Supports\Traits\HttpRequest;

class Support
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
     * @author liyong <458878932@qq.com>
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
     * @author liyong <458878932@qq.com>
     *
     * @param array $array
     */
    public static function request_api(array $data, array $config, $suffix_url = '')
    {
        $data = array_filter($data, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });
        //报文加密
        $str = base64_encode(openssl_encrypt(json_encode($data), 'AES-256-ECB', $config['aes_key'], OPENSSL_RAW_DATA));
        //发起请求
        $result = self::get_instance()->post(self::get_url($config['mode'],$suffix_url), $str);
        //报文解密
        $result = openssl_decrypt(base64_decode($result), 'AES-256-ECB', $config['aes_key'], OPENSSL_RAW_DATA);
        //解析结果
        $result = json_decode($result,true);
        //验证签名
        if (self::verify_sign($result['data'], $config['public_key'], $result['sign'])) {
            return $result;
        }

        throw new InvalidSignException("Sign Verify FAILED", $result);
    }

    /**
     * verfiy sign
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array       $data
     * @param string      $public_key
     * @param string|null $sign
     *
     * @return bool
     */
    public static function verify_sign(array $data, $public_key = null, $sign = null)
    {
        $data = array_filter($data, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });
        
        if (is_null($public_key)) {
            throw new InvalidConfigException('Missing Config -- [ali_public_key]');
        }
        //生成摘要
        $digest = strtoupper(openssl_digest(self::get_sign_content($data, true),"sha256"));

        return openssl_verify($digest, base64_decode($sign), $public_key, 'sha1WithRSAEncryption') === 1;
    }

    /**
     * generate sign
     *
     * @author liyong <458878932@qq.com>
     *
     * @param string $sign
     */
    public static function generate_sign(array $params, $private_key = null)
    {
        if (is_null($private_key)) {
            throw new InvalidConfigException('Missing Config -- [private_key]');
        }
        //生成摘要
        $digest = strtoupper(openssl_digest(self::get_sign_content($params, true),"sha256"));

        openssl_sign($digest, $sign, $private_key, 'sha1WithRSAEncryption');

        return base64_encode($sign);
    }

    /**
     * Get signContent that is to be signed.
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     * @param bool  $verify
     *
     * @return string
     */
    public static function get_sign_content(array $data, $verify = false)
    {
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

        return trim($stringToBeSigned, '&');
    }

    /**
     * get url
     *
     * @author liyong <458878932@qq.com>
     *
     * @param string $mode
     * @param string $suffix_url
     *
     * @return string $url
     */
    private static function get_url($mode = '', $suffix_url = '')
    {
        $url = 'https://www.sanxiapay.com/epaygate/';
        if ($mode == 'dev'){
            $url = 'http://222.178.75.14:8082/epaygate/';
        }

        return $url.$suffix_url.'.htm';
    }

}