<?php

namespace tools;

use tools\Supports\ShenMa;

/**
 * php 神马支付扩展包
 * Class Pay
 * @author  xiachao <25261639@qq.com>
 * @package
 */
class ShenMaPay
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
     * @author xiachao <25261639@qq.com>
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
        $this->params = [
            'service'      => '',
            'version'      => '1.0.0',
            'signType'    => 'MD5',
            'partnerId'    => $this->config['partnerId'],
        ];
    }

    /**
     * create_gbmember 个体商户注册
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function create_gbmember(array $data)
    {
        $this->params['service'] = 'creategbmember_service';
        $data['platid'] = $this->params['partner'];
        $this->params['data'] = $data;
        $this->params['sign'] = ShenMa::generate_sign($this->params['data'], $this->config['private_key']);
        return ShenMa::request_api($this->params, $this->config, 'creategbmember_service');
    }

    /**
     * create_indiv 个人商户注册
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function create_indiv(array $data)
    {
        $this->params['service'] = 'Create_Indiv_Service';
        $this->params['data'] = $data;
        $this->params['sign'] = ShenMa::generate_sign($this->params['data'], $this->config['private_key']);

        return ShenMa::request_api($this->params, $this->config, 'Create_Indiv_Service');
    }

    /**
     * payChannelList 支付渠道列表接口
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function pay_channel_list(array $data)
    {
        $this->params['service'] = 'payChannelList';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data,$this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'payChannelList');
    }

    /**
     * order_pay 订单支付接口(获取支付信息)
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function order_pay(array $data)
    {   
        $this->params['service'] = 'orderPay';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'orderPay');
    }

    /**
     * cashierPay 收银台确认支付
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function cashier_pay(array $data)
    {   
        $this->params['service'] = 'cashierPay';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'cashierPay');
    }


}