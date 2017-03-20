<?php
/**
 * Created by PhpStorm.
 * User: Pich
 * Date: 2017/3/8
 * Time: 15:31
 */
header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set("Asia/Shanghai");

$t=microtime(true);
// set_time_limit(1000);
// 
function getRand($position,$number){

    $right = $number;
    $number = $number+200; // 容错率1/200

    for($i=0;$i<$number;$i++){
        $n[$i] = $position.strtoupper(substr(md5(microtime(true)+$i), 0, 7));
    }

    echo  "生成：".count($n)."个(含重复)<br>";

    $unique =array_values(array_unique($n)) ;

    if( count($unique) >= $right  ){
        echo "生成：".count($unique)."个(唯一值)<br>";
        return $unique;
    }else{
        echo "生成：".count($unique)."个(唯一值)<br>";
        getRand($position,$right);
    }
}

//
function createSql($position,$number){
    $myFile="d:/insert.sql";
    $fhandler=fopen($myFile,'wb');
    if($fhandler){


        $codes =getRand($position,$number);
        $time =time();

        $i=0;
        while($i<$number){

            $code = $codes[$i];

            $sql = "$code\t0\t\t$time\t";

            fwrite($fhandler,$sql."\r\n");
            
            $i++;
        }

        echo "写入:".$i."个(唯一值)<br>";
    }
}

createSql("SH",180000);

echo"写入成功,耗时：",microtime(true)-$t,"秒";
// LOAD DATA local INFILE 'd:/insert.sql' INTO TABLE `coupon` (`code`, `status`, `geolocation`, `create_time`, `receive_time`);
// ALTER TABLE `coupon` ADD unique(`code`);

?>
