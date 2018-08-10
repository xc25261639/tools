<?php
require_once __DIR__ . '/../vendor/autoload.php';

use tools\ArrayHelper;

$arr = array(
            array('id'  =>  1, 'title'    =>  '标题1',),
            array('id'  =>  2, 'title'    =>  '标题2',),
        );
$ids = ArrayHelper::get_ids_arr($arr);
print_r($ids);die;