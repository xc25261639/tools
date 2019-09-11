<?php

namespace tools;

use tools\Supports\DefaultIcbcClient;
use tools\Supports\IcbcConstants;

class IcbcPay
{
    protected $config;
    protected $params;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->params = [
            'serviceUrl'      => '',// 使用api接口地址
            'method'          => 'POST',// 请求方法，只能是POST或GET
            'isNeedEncrypt'   => false,// 是否需要加密
            "extraParams" => null,//其他参数,用数组类型array
            'app_id' => $this->config['app_id'],
            'msg_id' => \fast\Random::uuid(false),
            'format' => 'json',
            'charset' => 'UTF-8',
            //'sign_typ' => 'RSA',
            'timestamp ' => '2019-09-25 12:55:43',//date("Y-m-d H:i:s",time())
        ];
    }

    private static function get_url($mode = '', $suffix_url = '')
    {
        $url = 'https://gw.open.icbc.com.cn/api/mybank/pay/cpay/';
        if ($mode == 'dev'){
            $url = 'https://apipcs3.dccnet.com.cn/api/mybank/pay/cpay/';
        }
        return $url.$suffix_url.'/V1';
    }

    /**
     * cppayapply 发起支付请求
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function cppayapply(array $data)
    {
        $this->params['serviceUrl'] = self::get_url($this->config['mode'],'cppayapply');
        $this->params['biz_content'] = $data;
        //var_dump($this->params['biz_content']['payeeList']);die;
        $client = new DefaultIcbcClient($this->config['app_id'],//APP的编号,应用在API开放平台注册时生成
            $this->config['private_key'],
            IcbcConstants::$SIGN_TYPE_RSA,//签名类型，’CA’-工行颁发的证书认证;’RSA’表示RSAWithSha1;’RSA2’表示RSAWithSha256;缺省为RSA
            '',//字符集，仅支持UTF-8,可填空‘’
            '',//请求参数格式，仅支持json，可填空‘’
            $this->config['public_key'],//网关公钥，必填
            '',//AES加密密钥，缺省为空‘’
            '',//加密类型，当前仅支持AES加密，需要按照接口类型是否需要加密来设置，缺省为空‘’
            '',//当签名类型为CA时，通过该字段上送证书公钥，缺省为空
            '');//当签名类型为CA时，通过该字段上送证书密码，缺省为空
        $resp = $client->execute($this->params,$this->params['msg_id'],''); //执行调用
        return json_decode($resp,true);
    }

    /**
     * cppreservationpay 解保留支付服务
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function cppreservationpay(array $data)
    {
        $this->params['serviceUrl'] = self::get_url($this->config['mode'],'cppreservationpay');
        $this->params['biz_content'] = $data;
        $client = new DefaultIcbcClient($this->config['app_id'],//APP的编号,应用在API开放平台注册时生成
            $this->config['private_key'],
            IcbcConstants::$SIGN_TYPE_RSA,//签名类型，’CA’-工行颁发的证书认证;’RSA’表示RSAWithSha1;’RSA2’表示RSAWithSha256;缺省为RSA
            '',//字符集，仅支持UTF-8,可填空‘’
            '',//请求参数格式，仅支持json，可填空‘’
            $this->config['public_key'],//网关公钥，必填
            '',//AES加密密钥，缺省为空‘’
            '',//加密类型，当前仅支持AES加密，需要按照接口类型是否需要加密来设置，缺省为空‘’
            '',//当签名类型为CA时，通过该字段上送证书公钥，缺省为空
            '');//当签名类型为CA时，通过该字段上送证书密码，缺省为空
        $resp = $client->execute($this->params,$this->params['msg_id'],''); //执行调用
        return json_decode($resp,true);
    }

    /**
     * cppreservationcancel 解保留撤销服务
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function cppreservationcancel(array $data)
    {
        $this->params['serviceUrl'] = self::get_url($this->config['mode'],'cppreservationcancel');
        $this->params['biz_content'] = $data;
        $client = new DefaultIcbcClient($this->config['app_id'],//APP的编号,应用在API开放平台注册时生成
            $this->config['private_key'],
            IcbcConstants::$SIGN_TYPE_RSA,//签名类型，’CA’-工行颁发的证书认证;’RSA’表示RSAWithSha1;’RSA2’表示RSAWithSha256;缺省为RSA
            '',//字符集，仅支持UTF-8,可填空‘’
            '',//请求参数格式，仅支持json，可填空‘’
            $this->config['public_key'],//网关公钥，必填
            '',//AES加密密钥，缺省为空‘’
            '',//加密类型，当前仅支持AES加密，需要按照接口类型是否需要加密来设置，缺省为空‘’
            '',//当签名类型为CA时，通过该字段上送证书公钥，缺省为空
            '');//当签名类型为CA时，通过该字段上送证书密码，缺省为空
        $resp = $client->execute($this->params,$this->params['msg_id'],''); //执行调用
        return json_decode($resp,true);
    }

    /**
     * cporderquery 支付申请查询接口
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function cporderquery(array $data)
    {
        $this->params['serviceUrl'] = self::get_url($this->config['mode'],'cporderquery');
        $this->params['biz_content'] = array(//业务数据,用数组类型array
                                        "agreeCode"=>"0310000205060220001700000000030008",//合作方编号
                                        "partnerSeq"=>$data['partnerSeq'],//交易流水号
                                        "orderCode"=>$data['orderCode'],//订单号
                                    );
        $client = new DefaultIcbcClient($this->config['app_id'],//APP的编号,应用在API开放平台注册时生成
            $this->config['private_key'],
            IcbcConstants::$SIGN_TYPE_RSA,//签名类型，’CA’-工行颁发的证书认证;’RSA’表示RSAWithSha1;’RSA2’表示RSAWithSha256;缺省为RSA
            '',//字符集，仅支持UTF-8,可填空‘’
            '',//请求参数格式，仅支持json，可填空‘’
            $this->config['public_key'],//网关公钥，必填
            '',//AES加密密钥，缺省为空‘’
            '',//加密类型，当前仅支持AES加密，需要按照接口类型是否需要加密来设置，缺省为空‘’
            '',//当签名类型为CA时，通过该字段上送证书公钥，缺省为空
            '');//当签名类型为CA时，通过该字段上送证书密码，缺省为空
        $resp = $client->execute($this->params,$this->params['msg_id'],''); //执行调用
        return json_decode($resp,true);
    }

    /**
     * cporderclose 支付申请关闭服务
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function cporderclose(array $data)
    {
        $this->params['serviceUrl'] = self::get_url($this->config['mode'],'cporderclose');
        $this->params['biz_content'] = array(//业务数据,用数组类型array
                                        "agreeCode"=>"0310000205060220001700000000030008",//合作方编号
                                        "partnerSeq"=>$data['partnerSeq'],//交易流水号
                                        "orderCode"=>$data['orderCode'],//订单号
                                    );
        $client = new DefaultIcbcClient($this->config['app_id'],//APP的编号,应用在API开放平台注册时生成
            $this->config['private_key'],
            IcbcConstants::$SIGN_TYPE_RSA,//签名类型，’CA’-工行颁发的证书认证;’RSA’表示RSAWithSha1;’RSA2’表示RSAWithSha256;缺省为RSA
            '',//字符集，仅支持UTF-8,可填空‘’
            '',//请求参数格式，仅支持json，可填空‘’
            $this->config['public_key'],//网关公钥，必填
            '',//AES加密密钥，缺省为空‘’
            '',//加密类型，当前仅支持AES加密，需要按照接口类型是否需要加密来设置，缺省为空‘’
            '',//当签名类型为CA时，通过该字段上送证书公钥，缺省为空
            '');//当签名类型为CA时，通过该字段上送证书密码，缺省为空
        $resp = $client->execute($this->params,$this->params['msg_id'],''); //执行调用
        return json_decode($resp,true);
    }
}