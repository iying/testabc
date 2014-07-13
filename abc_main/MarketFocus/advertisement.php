<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
        <script type="text/javascript">
            $(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
               initial_get_A();
			   initial_get_B();
			   
               function initial_get_A(){
                  $.ajax({
                     url:"adDB.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=getA",
                     success: function(str){
                        if(str!="::"){
                              var word=str.split(":");
                              count_01=parseInt(word[0],10);
                              count_02=parseInt(word[1],10);
                              count_03=parseInt(word[2],10);
							  lnet_rate=count_01;
                              ltv_rate=count_02;
							  lnp_rate=count_03;
							  $('#rate1').rating('./advertisement.php',{maxvalue:3, emp:"lnet_cost",curvalue:count_01});
							  $('#rate2').rating('./advertisement.php',{maxvalue:3, emp:"ltv_cost",curvalue:count_02});
							  $('#rate3').rating('./advertisement.php',{maxvalue:3, emp:"lnp_cost",curvalue:count_03});
						   }
                        }
                    });
                }//end func(initial_A)
				   function initial_get_B(){
                  $.ajax({
                     url:"adDB.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=getB",
                     success: function(str){
                        if(str!="::"){
                              var word=str.split(":");
                              count_04=parseInt(word[0],10);
                              count_05=parseInt(word[1],10);
                              count_06=parseInt(word[2],10);
							  tnet_rate=count_04;
							  ttv_rate=count_05;
							  tnp_rate=count_06;
							  $('#rate4').rating('./advertisement.php',{maxvalue:3, emp:"tnet_cost",curvalue:count_04});
							  $('#rate5').rating('./advertisement.php',{maxvalue:3, emp:"ttv_cost",curvalue:count_05});
							  $('#rate6').rating('./advertisement.php',{maxvalue:3, emp:"tnp_cost",curvalue:count_06});
						   }
                        }
                    });
                }//end func(initial_s)
				
				$("#submit_l").click(function(){
                    	$.ajax({
                        	url:"adDB.php",
                        	type: "GET",
                        	datatype: "html",
                        	data: "option=updateA&decision1="+lnet_rate+"&decision2="+ltv_rate+"&decision3="+lnp_rate,
                        	success: function(str){
                            	alert("Success!");
							//journal();
                        	}
                    	});
                });//end submit(d)
				
			    $("#submit_t").click(function(){
						$.ajax({
                       		url:"adDB.php",
                       		type: "GET",
                       		datatype: "html",
                       		data: "option=updateB&decision1="+tnet_rate+"&decision2="+ttv_rate+"&decision3="+tnp_rate,
                       		success: function(str){
                            alert("Success!");
						//journal();
                        	}
                    	});
                });//end submit(s)
            });
			function addCommas(nStr)
				{	
					nStr += '';
					x = nStr.split('.');
					x1 = x[0];
					x2 = x.length > 1 ? '.' + x[1] : '';
					var rgx = /(\d+)(\d{3})/;
					while (rgx.test(x1)) {
						x1 = x1.replace(rgx, '$1' + ',' + '$2');
					}
				return x1 + x2;
				}
							
			function rate(field,rate){	
			
			//alert(money_a1);
			if(field=="lnet_cost")
				document.getElementById("lnet_cost").innerHTML=money_a1[(rate)];
			else if(field=="ltv_cost")	
				document.getElementById("ltv_cost").innerHTML=money_a2[(rate)];
			else if(field=="lnp_cost")
				document.getElementById("lnp_cost").innerHTML=money_a3[(rate)];
			else if(field=="tnet_cost")
				document.getElementById("tnet_cost").innerHTML=money_b1[(rate)];
			else if(field=="ttv_cost")
				document.getElementById("ttv_cost").innerHTML=money_b2[(rate)];
			else if(field=="tnp_cost")
				document.getElementById("tnp_cost").innerHTML=money_b3[(rate)];

			document.getElementById("lap_total").innerHTML=addCommas(parseInt(document.getElementById("lnet_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ltv_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("lnp_cost").innerHTML.replace(/\,/g,''))
															);
		    document.getElementById("tab_total").innerHTML=addCommas(parseInt(document.getElementById("tnet_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ttv_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("tnp_cost").innerHTML.replace(/\,/g,''))
			
													);
			var f = field.replace("cost","rate");
			eval(f+"="+rate);
			//eval(field+"_rate")=rate;
			//s.push(field+"："+rate);
			//alert(field+"："+rate);	
			//alert(field+":"+eval(field+"r"));
			//alert(field);
			}
						
        </script>
<?php
$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
mysql_select_db("testabc_main", $connect);
error_reporting(0);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_a1';", $connect);
$result = mysql_fetch_array($temp);
$ad_a1 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_a2';", $connect);
$result = mysql_fetch_array($temp);
$ad_a2 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_a3';", $connect);
$result = mysql_fetch_array($temp);
$ad_a3 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_b1';", $connect);
$result = mysql_fetch_array($temp);
$ad_b1 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_b2';", $connect);
$result = mysql_fetch_array($temp);
$ad_b2 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

$temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='ad_b3';", $connect);
$result = mysql_fetch_array($temp);
$ad_b3 = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);

	echo $_GET["rate"];
	$cost_a1=split('、',$ad_a1);
	//echo $ad_a1[0]."|".$ad_a1[1]."|".$ad_a1[2];
	echo "<script language=\"javascript\"> var money_a1=new Array(\"0\",\"".$cost_a1[0]."\",\"".$cost_a1[1]."\",\"".$cost_a1[2]."\");</script>";
	
	$cost_a2=split('、',$ad_a2);
	echo "<script language=\"javascript\"> var money_a2=new Array(\"0\",\"".$cost_a2[0]."\",\"".$cost_a2[1]."\",\"".$cost_a2[2]."\");</script>";
		
	$cost_a3=split('、',$ad_a3);
	echo "<script language=\"javascript\"> var money_a3=new Array(\"0\",\"".$cost_a3[0]."\",\"".$cost_a3[1]."\",\"".$cost_a3[2]."\");</script>";
		
	$cost_b1=split('、',$ad_b1);
	echo "<script language=\"javascript\"> var money_b1=new Array(\"0\",\"".$cost_b1[0]."\",\"".$cost_b1[1]."\",\"".$cost_b1[2]."\");</script>";
		
	$cost_b2=split('、',$ad_b2);
	echo "<script language=\"javascript\"> var money_b2=new Array(\"0\",\"".$cost_b2[0]."\",\"".$cost_b2[1]."\",\"".$cost_b2[2]."\");</script>";
		
	$cost_b3=split('、',$ad_b3);
	//echo $cost[0];
	echo "<script language=\"javascript\"> var money_b3=new Array(\"0\",\"".$cost_b3[0]."\",\"".$cost_b3[1]."\",\"".$cost_b3[2]."\");</script>";
?>

    </head>
    <body>
   
        <div id="content" style="height:88%">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>廣告促銷
             <font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            * 廣告促銷的效用為：知名度增加，企業形象依等級提升*</font></h1>
        <script type="text/javascript" src="../star/donate_jquery.rating.js"></script>
		<link href="../star/donate_rating.css" rel="stylesheet"/>
            
        <div id="tabs" class="stContainer">
            <ul>
                <li>
                    <a href="#tabs-1">
                        <img class='logoImage2' border="0" width="20%"  src="../images/product_A.png">
                        <font size="4">筆記型電腦</font>
   
                    </a>
                </li>
                <li>
                    <a href="#tabs-2">
                        <img class='logoImage2' border="0" width="20%" src="../images/product_B.png">
                        <font size="4">平板電腦</font>
                    </a>
                </li>
            </ul>

        <div id="tabs-1">
         <p>
			
			<table class="table1" style="width:65%">
            <thead>
                <tr>
                    <td style="width:16%"></td>
                    <th scope="col" style="width:40%;">內容</th>
                    <th scope="col" style="width:150;">等級</th>
                    <th scope="col" style="width:18%">費用</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <th scope="row">網路廣告</th>
                    <td style="text-align:left;">在各大搜尋網站刊登廣告，增加曝光率</br>
                              					 各等級花費：為$2,000、$4,000、$6,000<br></td>
					<td>
						<span class="rating" id="rate1"></span> 
						<script type="text/javascript">
							$('#rate1').rating('./advertisement.php',{maxvalue:3, emp:"lnet_cost"});
						</script>
					</td>
                    <td><span id="lnet_cost">0</span></td>
                </tr>
            
                <tr>
                    <th scope="row">電視廣告</th>
                    <td style="text-align:left;">讓您的產品上電視，成為推廣品牌的最佳利器</br>
                            					 各等級花費：$4,000、$8,000、$12,000<br></td>
                    <td>
						<span class="rating" id="rate2"></span> 
						<script type="text/javascript">
							$('#rate2').rating('./advertisement.php',{maxvalue:3, emp:"ltv_cost"});
						</script>
					</td>
                    <td><span id="ltv_cost">0</span></td>
                </tr>
              
                <tr>
                    <th scope="row">報章雜誌廣告</th>
                    <td style="text-align:left;">讓產品出現在報章雜誌上，吸引潛在消費者</br>
                              					 各等級花費：$10,000、$20,000、$30,000<br></td>
                    <td>         
					<span class="rating" id="rate3"></span> 
						<script type="text/javascript">
							$('#rate3').rating('./advertisement.php',{maxvalue:3, emp:"lnp_cost"});
						</script>
					</td>
                    <td><span id="lnp_cost">0</span></td>
                </tr>
                
                </tbody>
                <tfoot>
                <tr>
                    <td>
					</td>
                    <th scope="row" style="text-align:right">總費用</th>
                    <td>$<span id ="lap_total">0</span></td><td align="center"><input type="image" src="../images/submit6.png" id="submit_l" style="width:100px"></td>
                    </tr>
                </tfoot>    
            </table> 
            </div> 
              <div id="tabs-2">
            <p>
            <table class="table1" style="width:65%">
            <thead>
                <tr>
                    <td style="width:16%"></td>
                    <th scope="col" style="width:40%">內容</th>
                    <th scope="col" style="width:150">等級</th>
                    <th scope="col" style="width:18%">費用</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <th scope="row">網路廣告</th>
                    <td style="text-align:left;">在各大搜尋網站刊登廣告，增加曝光率</br>
                             					 各等級花費：$2,000、$4,000、$6,000<br></td>
					<td>
						<span class="rating" id="rate4"></span> 
						<script type="text/javascript">
							$('#rate4').rating('./advertisement.php',{maxvalue:3, emp:"tnet_cost"});
						</script>
					</td>
                    <td><span id="tnet_cost">0</span></td>
                </tr>
            
                <tr>
                    <th scope="row">電視廣告</th>
                    <td style="text-align:left;">讓您的產品上電視，成為推廣品牌的最佳利器</br>
                             					 各等級花費：為$4,000、$8,000、$12,000<br></td>
                    <td>
                    	<span class="rating" id="rate5"></span> 
						<script type="text/javascript">
							$('#rate5').rating('./advertisement.php',{maxvalue:3, emp:"ttv_cost"});
						</script>
					</td>
                    <td><span id="ttv_cost">0</span></td>
                </tr>
              
                <tr>
                    <th scope="row">報章雜誌廣告</th>
                    <td style="text-align:left;">讓產品出現在報章雜誌上，吸引潛在消費者</br>
                             					 各等級花費：$10,000、$20,000、$30,000<br></td>
					<td>
						<span class="rating" id="rate6"></span> 
						<script type="text/javascript">
							$('#rate6').rating('./advertisement.php',{maxvalue:3, emp:"tnp_cost"});
						</script>
					</td>
                    <td><span id="tnp_cost">0</span></td>
                </tr>
                
                </tbody>
                <tfoot>
                <tr>
                    <td></td>
                    <th scope="row" style="text-align:right">總費用</th>
                    <td>$<span id ="tab_total">0</span></td><td align="center"> <input type="image" src="../images/submit6.png" id="submit_t" style="width:100px"></td>
                    </tr>
                </tfoot>    
            </table>
            
        </div><!--end of tabs-2 -->
        </div><!--end of tabs -->
        </div><!-- end content -->
    </body>
</html>