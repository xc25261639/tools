<?php

namespace tools;

use tools\Supports\Support;

/**
 * php 三峡付支付扩展包
 * Class Pay
 * @author  liyong <458878932@qq.com>
 * @package
 */
class Pay
{
    /**
     * config
     *
     * @var config
     */
    protected $config;

    /**
     * params
     *
     * @var array
     */
    protected $params;

    /**
     * config
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->params = [
            'service'         => '',
            'service_version' => '1.0',
            'input_charset'   => 'UTF-8',
            'sign_type'       => 'SHA1WithRSA',
            'sign'            => '',
            'partner'         => $this->config['partner'],
            'data'            => '',
        ];
    }

    /**
     * create_gbmember 个体商户注册
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function create_gbmember(array $data)
    {
        $this->params['service'] = 'creategbmember_service';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'CreateGBMemberServlet');
    }

    /**
     * create_indiv 个人商户注册
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function create_indiv(array $data)
    {
        $this->params['service'] = 'Create_Indiv_Service';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'CreateIndivServlet');
    }

    /**
     * get_token 获取token接口
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function get_token(array $data)
    {
        $this->params['service'] = 'get_token';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);
        return Support::request_api($this->params, $this->config, 'getPayToken');
    }

    /**
     * pay 支付接口
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function pay(array $data)
    {
        $this->params['service'] = 'pay_service';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'pay');
    }

    /**
     * wechatPaymentApi 微信支付预下单请求
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function wechat_payment_api(array $data)
    {
        $this->params['service'] = 'wechat_payment_api';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'wechatPaymentApi');
    }

    /**
     * refund 退款接口
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function refund(array $data)
    {
        $this->params['service'] = 'refund_service';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'refund');
    }

    /**
     * member_balance 待清算金额查询接口
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function member_balance(array $data)
    {
        $this->params['service'] = 'query_member_balance';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'memPlatAccBal');
    }

    /**
     * trans_detail 交易明细查询接口
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function trans_detail(array $data)
    {
        $this->params['service'] = 'query_plat_trans_detail';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'platTransDetail');
    }

    /**
     * order_detail 订单查询接口
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function order_detail(array $data)
    {
        $this->params['service'] = 'query_order_service';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'query_order');
    }

    /**
     * unifiedorder 移动端(SDK)申请支付流水号接口
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function unifiedorder(array $data)
    {
        $this->params['service_version'] = '1.1';
        $this->params['service'] = 'unifiedorder_service';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'unifiedorder');
    }

    /**
     * account_download 对账单下载接口
     *
     * @author liyong <458878932@qq.com>
     *
     * @param array $data
     */
    public function account_download(array $data)
    {
        $this->params['service'] = 'account_download_service';
        $this->params['data'] = $data;
        $this->params['sign'] = Support::generate_sign($this->params['data'], $this->config['private_key']);

        return Support::request_api($this->params, $this->config, 'account_download');
    }
}