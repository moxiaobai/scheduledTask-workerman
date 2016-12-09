<?php

$info = array(
    'uid'       => 1024,
    'age'       => 100,
    'username'  => 'moxiaobai',
    'realname'  => '莫小白'
);
$data = array('code'=>1, 'info'=>$info);
echo json_encode($data);