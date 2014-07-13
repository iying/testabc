<?php
    $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
    mysql_select_db("testabc_main", $connect);
    mysql_query("set names 'utf8'");
    $temp=mysql_query("SELECT MAX(`year`) FROM `state`",$connect);
        $result_temp=mysql_fetch_array($temp);
        $year=$result_temp[0];
        $temp=mysql_query("SELECT MAX(`month`) FROM `state` WHERE `year`=$year",$connect);
        $result_temp=mysql_fetch_array($temp);
        $month=$result_temp[0]-1;
        if($month==0){
            $month=12;
            $year-=1;
        }
    $para=mysql_query("SELECT * FROM `parameter_description`;",$connect);
    
    while($para_result=mysql_fetch_array($para)){
        if($para_result['name']=='price_ratio_A')
            $price_ratio_A=$para_result['value'];
        else if($para_result['name']=='quality_ratio_A')
            $quality_ratio_A=$para_result['value'];
        else if($para_result['name']=='company_image_ratio_A')
            $company_image_ratio_A=$para_result['value'];
        else if($para_result['name']=='customer_satisfaction_ratio_A')
            $customer_satisfaction_ratio_A=$para_result['value'];
        else if($para_result['name']=='price_ratio_B')
            $price_ratio_B=$para_result['value'];
        else if($para_result['name']=='quality_ratio_B')
            $quality_ratio_B=$para_result['value'];
        else if($para_result['name']=='company_image_ratio_B')
            $company_image_ratio_B=$para_result['value'];
        else if($para_result['name']=='customer_satisfaction_ratio_B')
            $customer_satisfaction_ratio_B=$para_result['value'];
    }

    $temp=mysql_query("SELECT DISTINCT(`order_no`) FROM `order_accept` WHERE `year`=$year AND `month`=$month",$connect);
    $temp_1=mysql_fetch_array($temp);
    if(!empty($temp_1)){
        $temp=mysql_query("SELECT DISTINCT(`order_no`) FROM `order_accept` WHERE `year`=$year AND `month`=$month",$connect);
        while($temp_1=mysql_fetch_array($temp)){
            $result_temp=mysql_query("SELECT * FROM `order_accept` WHERE `order_no`='$temp_1[0]'",$connect);
            $correspond=array('1'=>'0.92','2'=>'0.87','3'=>'0.79','4'=>'0.66','5'=>'0');
            $max=0;
            $company_name="";
            $order_no="";
            $customer_name="";
            $rank=0;
			$temp_rank=0;
            $quantity_global=0;
            while($result=mysql_fetch_array($result_temp)){
                $order_no=$result['order_no'];
                $company=$result['cid'];
                $arr=array();
                $quality=0;
                $quality_temp=0;
                $satisfaction_tmp=0;
                $service=0;
                $quantity_temp=$result['quantity'];
                $quantity_global=$result['quantity'];
                $type=explode("_",$order_no);
                $temp_1=mysql_query("SELECT `company_image` FROM `state` WHERE `cid`='$company' AND `year`=$year AND `month`=$month",$connect);
                $result_1=mysql_fetch_array($temp_1); // company_image => value

                $temp_1=mysql_query("SELECT `satisfaction` FROM `customer_satisfaction` WHERE `cid`='$company' AND `customer`='{$result['customer']}'",$connect);
                $result_tmp=mysql_fetch_array($temp_1); // satisfaction => value , according to customer`s name...
                if($result_tmp[0]!=NULL)
                    $satisfaction_tmp=$result_tmp[0];
                else
                    $satisfaction_tmp=0;
                $name=$result['customer'];
                $temp_1=mysql_query("SELECT `emphasis` FROM `customer_state` WHERE `name`='$name'",$connect);
                $result_2=mysql_fetch_array($temp_1);
                list($quality_focus,$service_focus)=split(':',$result_2[0]);

                $temp_rank=$result['quality'];
                $temp_1=mysql_query("SELECT `batch`,`quality` FROM `product_quality` WHERE `cid`='$company' AND `product`='$type[1]' AND `rank`>=$temp_rank ORDER BY `rank` DESC",$connect);
                while($result_3=mysql_fetch_array($temp_1)){
                    print_r($result_3);
                    if($result_3['batch']>=$quantity_temp){//產品較多
                        array_push($arr,($quantity_temp/$quantity_global).':'.$result_3['quality']);
                        break;
                    }
                    else{
                        array_push($arr,($result_3['batch']/$quantity_global).':'.$result_3['quality']);
                        $quantity_temp-=$result_3['batch'];
                    }
                }
                print_r($arr);
                for($i=0;$i<sizeof($arr);$i++){
                    list($temp_1,$temp_2)=split(":",$arr[$i]);
                    echo "temp_1".$temp_1;
                    echo "temp_2".$temp_2;
                    $quality+=$temp_1*$temp_2;
                }
                $quality_temp=$quality;
                $quality=$quality*100*$quality_focus;
                $service=(6-$result['service'])*10*$service_focus;
                if($type[1]=="A")
                    $max_temp=((40000-$result['price'])/1000)*$price_ratio_A*3.5+$quality*$quality_ratio_A+$result_1['company_image']*$company_image_ratio_A+(0.6*$service+0.4*$satisfaction_tmp)*$customer_satisfaction_ratio_A;
                else if($type[1]=="B")
                    $max_temp=((20000-$result['price'])/1000)*$price_ratio_B*3.5+$quality*$quality_ratio_B+$result_1['company_image']*$company_image_ratio_B+(0.6*$service+0.4*$satisfaction_tmp)*$customer_satisfaction_ratio_B;
                if($max_temp>$max){
                    $max=$max_temp;
                    $company_name=$company;
                    $customer_name=$result['customer'];
					$rank=$temp_rank;
                }
            }
            echo "BID RESULT => ".$company_name."CUSTOMER => ".$customer_name;
            mysql_query("UPDATE `order_accept` SET `accept` = 1 WHERE `cid`='$company_name' AND `order_no` = '$order_no' AND `year`=$year AND `month`=$month",$connect) or die(mysql_error());
            mysql_query("DELETE FROM `order_detail` WHERE `order_no`='$order_no'",$connect);
            $customer_temp=mysql_query("SELECT * FROM `customer_satisfaction` WHERE `cid`='$company_name' AND `customer`='$customer_name'",$connect);
            $customer_result=mysql_fetch_array($customer_temp);
            if(empty($customer_result))
                mysql_query("INSERT INTO `customer_satisfaction` VALUES ('$customer_name','$company_name',0)",$connect);
            $customer_temp=mysql_query("SELECT * FROM `customer_satisfaction` WHERE `cid`='$company_name' AND `customer`='$customer_name'",$connect);
            $customer_result=mysql_fetch_array($customer_temp);
            $customer_result=$customer_result['satisfaction'];
            $temp_final=mysql_query("SELECT * FROM `product_quality` WHERE `cid`='$company_name' AND `product`='$type[1]' AND `rank`>=$rank ORDER BY `rank` DESC",$connect);
			echo "SELECT * FROM `product_quality` WHERE `cid`='$company_name' AND `product`='$type[1]' AND `rank`>=$rank ORDER BY `rank` DESC;<br/>";

            while($result_final=mysql_fetch_array($temp_final)){
                $index=$result_final['index'];
				$type1=$result_final['product'];
                $COGS=0;
                $COGS_type='product_'.$type1.'_COGS';
                $now_COGS = mysql_query("SELECT `$COGS_type` FROM `production_cost` WHERE `cid`='{$result_final['cid']}' AND `year`= $year AND `month` = $month",$connect);
                echo "SELECT `$COGS_type` FROM `production_cost` WHERE `cid`='{$result_final['cid']}' AND `year`= $year AND `month` = $month";
				$COGS_arr = mysql_fetch_array($now_COGS);
                if($result_final['batch']<=$quantity_global){
                    mysql_query("DELETE FROM `product_quality` WHERE `index`=$index;",$connect) or die(mysql_error());
                    $quantity_global-=$result_final['batch'];
					echo "SELECT * FROM `production_cost` WHERE `cid`='{$result_final['cid']}'AND`year`= '{$result_final['year']}'AND`month`='{$result_final['month']}'<br/>";
                    $cost_result=mysql_query("SELECT * FROM `production_cost` WHERE `cid`='{$result_final['cid']}'AND`year`= '{$result_final['year']}'AND`month`='{$result_final['month']}'",$connect);
                    $cost=mysql_fetch_array($cost_result);
                    $type1=$result_final['product'];
                    $total_cost=$cost['product_'.$type1.'_material_total']+$cost['product_'.$type1.'_direct_labor']+$cost['product_'.$type1.'_overhead'];
                    $history_result=mysql_query("SELECT `batch` FROM `product_history` WHERE `index` = $index",$connect);
                    $history_product=mysql_fetch_array($history_result);
                    $COGS=$total_cost*$result_final['batch']/$history_product[0]+$COGS_arr[$COGS_type];
                }
                else{
                    $remain=$result_final['batch']-$quantity_global;
                    //echo "remain".$remain;
                    mysql_query("UPDATE `product_quality` SET `batch` = $remain WHERE `index` = $index;",$connect) or die(mysql_error());
					echo "SELECT * FROM `production_cost` WHERE `cid`='{$result_final['cid']}'AND`year`= '{$result_final['year']}'AND`month`='{$result_final['month']}'<br/>";
                    $cost_result=mysql_query("SELECT * FROM `production_cost` WHERE `cid`='{$result_final['cid']}'AND`year`= '{$result_final['year']}'AND`month`='{$result_final['month']}'",$connect);
                    $cost=mysql_fetch_array($cost_result);
                    $type1=$result_final['product'];
                    $total_cost=$cost['product_'.$type1.'_material_total']+$cost['product_'.$type1.'_direct_labor']+$cost['product_'.$type1.'_overhead'];
                    $history_result=mysql_query("SELECT `batch` FROM `product_history` WHERE `index` = $index",$connect);
                    $history_product=mysql_fetch_array($history_result);
                    $COGS=$total_cost*$quantity_global/$history_product[0]+$COGS_arr[$COGS_type];
                    $quantity_global=0;
                }
				echo "<br/>UPDATE `production_cost` SET `$COGS_type` = $COGS  WHERE `cid`='{$result_final['cid']}' AND `year`= $year AND `month` = $month<br/>";
                mysql_query("UPDATE `production_cost` SET `$COGS_type` = $COGS  WHERE `cid`='{$result_final['cid']}' AND `year`= $year AND `month` = $month",$connect);
                if($quantity_global==0)
                    break;
            }
            //顧客滿意度計算
            if($rank==1)
                $customer_result+=7*($quality_temp-$correspond[$rank]);
            else if($rank==2)
                $customer_result+=5*($quality_temp-$correspond[$rank]);
            else if($rank==3)
                $customer_result+=3*($quality_temp-$correspond[$rank]);
            else if($rank==4)
                $customer_result+=1.1*($quality_temp-$correspond[$rank]);
            else if($rank==5)
                $customer_result+=0.5*($quality_temp-$correspond[$rank]);

            mysql_query("UPDATE `customer_satisfaction` SET `satisfaction` = $customer_result WHERE `cid` = '$company_name' AND `customer`='$customer_name'",$connect);

        }
        //營收計算
        /*$temp_result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='bad_debt_A'",$connect);     //壞帳機率_等級一
        $A_num=mysql_fetch_array($temp_result);
        $A_num=$A_num[0];

        $temp_result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='bad_debt_B'",$connect);     //壞帳機率_等級二
        $B_num=mysql_fetch_array($temp_result);
        $B_num=$B_num[0];

        $temp_result=mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='bad_debt_C'",$connect);     //壞帳機率_等級三
        $C_num=mysql_fetch_array($temp_result);
        $C_num=$C_num[0];

        $bad_debt_A=array();
        for($i=0;$i<$A_num;$i++){
            while(true){
                $temp=rand()%100;
                if(!in_array($temp,$bad_debt_A)){
                    array_unshift($bad_debt_A,$temp);
                    break;
                }
            }
        }

        echo "<br>";
        print_r($bad_debt_A);

        $bad_debt_B=array();
        for($i=0;$i<$B_num;$i++){
            while(true){
                $temp=rand()%100;
                if(!in_array($temp,$bad_debt_B)){
                    array_unshift($bad_debt_B,$temp);
                    break;
                }
            }
        }

        echo "<br>";
        print_r($bad_debt_B);

        $bad_debt_C=array();
        for($i=0;$i<$C_num;$i++){
            while(true){
                $temp=rand()%100;
                if(!in_array($temp,$bad_debt_C)){
                    array_unshift($bad_debt_C,$temp);
                    break;
                }
            }
        }

        echo "<br>";
        print_r($bad_debt_C);

        $temp_result=mysql_query("SELECT * FROM `state` WHERE `year`=$year AND `month`=$month",$connect);
        $company_reference=array();
        while($temp=mysql_fetch_array($temp_result)){
            array_unshift($company_reference,$temp['cid']);
        }

        print_r($company_reference);

        $temp_result=mysql_query("SELECT * FROM `order_accept` WHERE `accept`=1",$connect);
        while($result=mysql_fetch_array($temp_result)){
            if($result['b_or_c']=='1'){
                $temp=array_search($result['cid'],$company_reference);
                if($result['type']=="A"){
                    if(in_array($temp,$bad_debt_A))
                        echo $result['cid']."經由訂單編號為".$result['order_no']."產生壞帳~!!<br>";
                    else
                        echo $result['cid']."經由訂單編號為".$result['order_no']."所獲得的總營收為 => ".$result['price']*$result['quantity']."元"."<br>";
                }
                if($result['type']=="B"){
                    if(in_array($temp,$bad_debt_B))
                        echo $result['cid']."經由訂單編號為".$result['order_no']."產生壞帳~!!<br>";
                    else
                        echo $result['cid']."經由訂單編號為".$result['order_no']."所獲得的總營收為 => ".$result['price']*$result['quantity']."元"."<br>";
                }
                if($result['type']=="C"){
                    if(in_array($temp,$bad_debt_C))
                        echo $result['cid']."經由訂單編號為".$result['order_no']."產生壞帳~!!<br>";
                    else
                        echo $result['cid']."經由訂單編號為".$result['order_no']."所獲得的總營收為 => ".$result['price']*$result['quantity']."元"."<br>";
                }
            }
            else{
                echo $result['cid']."經由訂單編號為".$result['order_no']."所獲得的總營收為 => ".$result['price']*$result['quantity']."元"."<br>";
            }
        }*/
    }
    $temp=mysql_query("SELECT `customer`,`cid` FROM `order_accept` WHERE `accept`=0 AND $year AND `month`=$month",$connect);
    while($result=  mysql_fetch_array($temp)){
        $temp_result=mysql_query("SELECT `satisfaction` FROM `customer_satisfaction` WHERE `customer`='{$result['customer']}' AND `cid` ='{$result['cid']}'",$connect);
        $result_temp=mysql_fetch_array($temp_result);
        $num=$result_temp[0]-0.3;
        mysql_query("UPDATE `customer_satisfaction` SET `satisfaction` = $num WHERE `cid` = '{$result['cid']}' AND `customer`='{$result['customer']}'",$connect);
    }
?>
