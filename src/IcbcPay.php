<?php

namespace tools;

use tools\Supports\DefaultIcbcClient;
use tools\Supports\IcbcConstants;

class IcbcPay
{
    protected $request;

    public function cppayapply(array $request)
    {
        $request = array(
            "serviceUrl" => 'https://apipcs3.dccnet.com.cn/api/mybank/pay/cpay/cppayapply/V1',// 使用api接口地址
            "method" => 'POST',// 请求方法，只能是POST或GET
            "isNeedEncrypt" => false,// 是否需要加密
            "extraParams" => null,//其他参数,用数组类型array
            'app_id' => '10000000000000114506',
            'msg_id' => '666',
            'format' => 'json',
            'charset' => 'UTF-8',
            //'sign_typ' => 'RSA',
            'timestamp ' => '2019-07-02 12:55:43',//date("Y-m-d H:i:s",time())
            "biz_content" => array(//业务数据,用数组类型array
                "agreeCode"=>"0310000205060220001700000000030008",
                "partnerSeq"=>"201907021118",
                "payChannel"=>"1",
                "internationalFlag"=>"1",
                "payMode"=>"1",
                "payEntitys"=>"10000000000000000000",
                "asynFlag"=>"0",
                "orderCode"=>"001",
                "orderAmount"=>"100",
                "orderCurr"=>"1",
                "sumPayamt"=>"100",
                "orderRemark"=>"666",
                "submitTime"=>"20190702152255",
                'payMemno'=>'3',
                "payeeList" => array(array(//收方商户信息列表,用数组类型array
                    "mallCode"=>"0310000205060220001700000000030008",//收方商户号
                    "mallName"=>"三果云",//商户名称
                    "payeeCompanyName"=>"寓赏渝肥雪控磁雪析喜吸伍野该挥傻",//收款人户名
                    "payeeSysflag"=>"1",//1-境内工行，2-境内他行，3-境外
                    "payeeAccno"=>"3100020419200318181",//收款人账号
                    "payAmount"=>"100",//收款金额（单位：分）
                )),
                "goodsList" => array(array(//商品信息列表,用数组类型array
                    "goodsSubId"=>"5",
                    "goodsName"=>"E企付发起支付测试",
                    "payeeCompanyName"=>"寓赏渝肥雪控磁雪析喜吸伍野该挥傻",
                    "goodsNumber"=>"2",
                    "goodsUnit"=>"kg",
                    "goodsAmt"=>"50",
                ))
            )
        );
        $client = new DefaultIcbcClient('10000000000000114506',//APP的编号,应用在API开放平台注册时生成
            'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC8JMPcNCqq++a8bnW5WYvDKmRkvbSzQ6BBZujUgxJFDfJljWXOshhHfbKbLANJq9GmPq9kd3Ndrr9iee6WAxnT9XVSzxlMcIeQdRKOGrbIhrxqRNX3bT6ofHcERY+GhOGMUB5G6ACt1bom54p+mXVrWjxCeXIGHLGMoQccIIKmPalCry/GuEd8eG31t3OQ0qSb3TlIktQuUwPCX3a2pCTIgtrZqybZ/yPJHums/Ry6N+soEYMCcuQLOgpibAgzuH75zB7o0rurRmDejWIPK5DnQTtUZzr6qRhuB/DhfllzObR80zCIr+GuWkRC1FlmmTs3xiyhSq90kiluZq/qzm/vAgMBAAECggEACoHTHl0bdOkUfbl9gZhqob+gU6/0g35nWL+yiQu43Xpl6x32bZCsonF2pAvVMywRTUN68BVrr/OuZIWCuYX6z0eKAdHnC8nNCFhBbQY45wH/S8AEYwkK0sYAr5Bi75RENF3VEwip4QtqlfmgVmmjkRc8/kliAM1hbQUhLIT0RuxZ/jfI6qxoIpXkCEvm0Q+UM2syF6JJ9NuXB1VMspgIf1HzJf6Y+hkc0Drl6O6sKTbuevqpnKe8pEcAgR03plk56j1Y2KP4TeEtytYtDkHrpq5ofu6KSYkc71/Rc4tbyBPSTbVCEzvmRbSu0N3fiYelsP2HVVdU1iCk4zo5f0B3gQKBgQDziGvl7FcoVTecUlLn/vNxL/E0DELm6vblqBEmtUhbc23xfoiK+mLTYeGJPo2JdqT4BsZk2pk774TRFy3UfR5oASkMQ9o1nbNLoxzNccVHixcz/6ZnJ/FM8glLMMYEja+cgVwx2VkubmrwLPmkbzdQDWvCrxGu6aSL324A4LgTsQKBgQDFxnLpb7CptzLtLwIfyWF9oj3kBgIJTQtEybS12mr1TaLeKyuiQoHPnCN8s4BJITlw5eZa6nvW1KsY1MZm8ZMTprZxEk7o9146KYk1dXZhYQ5jSRHg97DoRIuZbK0wAUP7VmyoelJl6vRT+huWgwzrZo+Mt9d8YkGeaCTWqkPFnwKBgF4RzTPkJgqTWEbO2e15YsnO7gnfzpvqGPK/B9j+33NL1CUbblzYuQHT5k2gVwXJSZHw9AOTGOu46oHlxTM2HV+pSxTMxOY/AzntSLvm/YBULuNMFhf0qtXBDGv57BNoM3Rt15H91eAEkNQzWz70ItaOSJjMDTWWVJQe+xvlsdURAoGBAI74Nnmp0/vcA2SSZuaznVZEwpjj/vTaTRsc9RXBHzDVPrd8Xb6edVivdrfeyw4ShoOmri9q8rsKYeVBa2tflwLNsXVr1r9ykxtYi2ep0jny/4OmftYyOCCv7HqspUXepFY806+3PXmPr7BFTUww0FYbfgornAq+vNDWWEsWKofhAoGBAJZuPW+mwdWr8d3fRyCj+3CUZIdZDdjtQNzjVsqcweBwsk1IMUl75eTIp0/8hwxXxERJtU7UJjmne40054XNc89Vjnz10DqF0fqpu3QA46LlBTMiG4wnfEDDR013u6HqeWSYZ051Qxujqd+viFd/Q0+HZU1VgbYLnIlL03R3D0GH',
            IcbcConstants::$SIGN_TYPE_RSA,//签名类型，’CA’-工行颁发的证书认证;’RSA’表示RSAWithSha1;’RSA2’表示RSAWithSha256;缺省为RSA
            '',//字符集，仅支持UTF-8,可填空‘’
            '',//请求参数格式，仅支持json，可填空‘’
            'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCwFgHD4kzEVPdOj03ctKM7KV+16
                bWZ5BMNgvEeuEQwfQYkRVwI9HFOGkwNTMn5hiJXHnlXYCX+zp5r6R52MY0O7BsTCL
                T7aHaxsANsvI9ABGx3OaTVlPB59M6GPbJh0uXvio0m1r/lTW3Z60RU6Q3oid/rNhP
                3CiNgg0W6O3AGqwIDAQAB',//网关公钥，必填
            '',//AES加密密钥，缺省为空‘’
            '',//加密类型，当前仅支持AES加密，需要按照接口类型是否需要加密来设置，缺省为空‘’
            '',//当签名类型为CA时，通过该字段上送证书公钥，缺省为空
            '');//当签名类型为CA时，通过该字段上送证书密码，缺省为空
        $resp = $client->execute($request,'212S3',''); //执行调用
        return json_decode($resp,true);
    }
}