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
        //var_dump($merge_data);die;
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

    /**
     * order_query 订单查询
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function order_query(array $data)
    {   
        $this->params['service'] = 'orderQuery';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'orderQuery');
    }

    /**
     * refund 零售退款
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function refund(array $data)
    {   
        $this->params['service'] = 'refund';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'refund');
    }

    /**
     * register_user 注册个人用户
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function register_user(array $data)
    {   
        $this->params['service'] = 'registerUserAndValidate';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'registerUserAndValidate');
    }

    /**
     * register_enterprise_user 注册企业用户
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function register_enterprise_user(array $data)
    {   
        $this->params['service'] = 'registerEnterpriseUserAndValidate';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'registerEnterpriseUserAndValidate');
    }

    /**
     * binding_bank_card 绑定银行卡
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function binding_bank_card(array $data)
    {   
        $this->params['service'] = 'bindingBankCard';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'bindingBankCard');
    }

    /**
     * query_bank_card 查询绑定银行卡
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function query_bank_card(array $data)
    {   
        $this->params['service'] = 'queryDefaultBankCard';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'queryDefaultBankCard');
    }

    /**
     * user_withdraw_amount 查询可提现余额
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function user_withdraw_amount(array $data)
    {   
        $this->params['service'] = 'queryUserWithdrawAmount';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'queryUserWithdrawAmount');
    }

    /**
     * query_user_balance 查询用户账户余额
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function query_user_balance(array $data)
    {   
        $this->params['service'] = 'queryUserBalance';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'queryUserBalance');
    }

    /**
     * immediate_withdraw 提现
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function immediate_withdraw(array $data)
    {   
        $this->params['service'] = 'immediateWithdraw';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'immediateWithdraw');
    }

    /**
     * electronicReceiptCreate 下载电子回单
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function electronic_receipt_create(array $data)
    {   
        $this->params['service'] = 'electronicReceiptCreate';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'electronicReceiptCreate');
    }

    /**
     * channel_ransfer 渠道转账
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function channel_ransfer(array $data)
    {   
        $this->params['service'] = 'channelTransfer';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'channelTransfer');
    }

    /**
     * only_transfer 单笔转账
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function only_transfer(array $data)
    {   
        $this->params['service'] = 'onlyTransfer';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'onlyTransfer');
    }

    /**
     * upload_file 图片上传
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function upload_file(array $data)
    {   
        $this->params['service'] = 'uploadFile';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'uploadFile');
    }

    /**
     * enterprise_open_account 企业会员进件
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function enterprise_open_account(array $data)
    {   
        $this->params['service'] = 'enterpriseOpenAccount';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'enterpriseOpenAccount');
    }

    /**
     * query_open_account 查询开户结果
     *
     * @author xiachao <25261639@qq.com>
     *
     * @param array $data
     */
    public function query_open_account(array $data)
    {   
        $this->params['service'] = 'queryOpenAccount';
        $merge_data = array_merge($this->params,$data);
        $merge_data['sign'] = ShenMa::generate_sign($merge_data, $this->config['secretKey']);
        return ShenMa::request_api($merge_data, $this->config, 'queryOpenAccount');
    }

}