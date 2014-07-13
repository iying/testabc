<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
         <?php
        $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
        mysql_select_db("testabc_main", $connect);
		error_reporting(0);
		//donate
        $temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='donate';", $connect);
        $result = mysql_fetch_array($temp);
        $donate = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);
		$cost_d=split('、',$donate);
		echo $_GET["rate"];
		//echo $cost[0];
		echo "<script language=\"javascript\">var money_d=new Array(\"0\",\"".$cost_d[0]."\",\"".$cost_d[1]."\",\"".$cost_d[2]."\");</script>";
		
		//share1
		$sql_s1= mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='share1';", $connect);
        $s1 = mysql_fetch_array($sql_s1);
        $share1 = number_format($s1['money']) . "、" . number_format($s1['money2']) . "、" . number_format($s1['money3']);
		$cost_s1=split('、',$share1);
		echo "<script language=\"javascript\">var money_s1=new Array(\"0\",\"".$cost_s1[0]."\",\"".$cost_s1[1]."\",\"".$cost_s1[2]."\");</script>";
		//share2
		$sql_s2= mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='share2';", $connect);
        $s2 = mysql_fetch_array($sql_s2);
        $share2 = number_format($s2['money']) . "、" . number_format($s2['money2']) . "、" . number_format($s2['money3']);
		$cost_s2=split('、',$share2);
		echo "<script language=\"javascript\">var money_s2=new Array(\"0\",\"".$cost_s2[0]."\",\"".$cost_s2[1]."\",\"".$cost_s2[2]."\");</script>";
		//share3
		$sql_s3= mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='share3';", $connect);
        $s3 = mysql_fetch_array($sql_s3);
        $share3 = number_format($s3['money']) . "、" . number_format($s3['money2']) . "、" . number_format($s3['money3']);
		$cost_s3=split('、',$share3);
		echo "<script language=\"javascript\">var money_s3=new Array(\"0\",\"".$cost_s3[0]."\",\"".$cost_s3[1]."\",\"".$cost_s3[2]."\");</script>";
		
        ?>
        <script type="text/javascript">
             var count_01=0; count_02=0; count_03=0;
			 var count_04=0; count_05=0; count_06=0;
            
			$(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
			   initial_get_d();
			   initial_get_s();
			   
               function initial_get_d(){
                  $.ajax({
                     url:"GET_donate.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=get",
                     success: function(str){
                        if(str!="::"){
                              var word=str.split(":");
                              count_01=parseInt(word[0],10);
                              count_02=parseInt(word[1],10);
                              count_03=parseInt(word[2],10);
							  fa_rate=count_01;
                              op_rate=count_02;
							  ds_rate=count_03;
							  $('#rate1').rating('./donate_share.php',{maxvalue:3, emp:"fa_cost",curvalue:count_01});
							  $('#rate2').rating('./donate_share.php',{maxvalue:3, emp:"op_cost",curvalue:count_02});
							  $('#rate3').rating('./donate_share.php',{maxvalue:3, emp:"ds_cost",curvalue:count_03});
						   }
                        }
                    });
                }//end func(initial_d)
				   function initial_get_s(){
                  $.ajax({
                     url:"GET_share.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=get",
                     success: function(str){
                        if(str!="::"){
                              var word=str.split(":");
                              count_04=parseInt(word[0],10);
                              count_05=parseInt(word[1],10);
                              count_06=parseInt(word[2],10);
							  cm_rate=count_04;
							  en_rate=count_05;
							  eh_rate=count_06;
							  $('#rate4').rating('./donate_share.php',{maxvalue:3, emp:"cm_cost",curvalue:count_04});
							  $('#rate5').rating('./donate_share.php',{maxvalue:3, emp:"en_cost",curvalue:count_05});
							  $('#rate6').rating('./donate_share.php',{maxvalue:3, emp:"eh_cost",curvalue:count_06});
						   }
                        }
                    });
                }//end func(initial_s)
				
				$("#submit_d").click(function(){
                    	$.ajax({
                        	url:"GET_donate.php",
                        	type: "GET",
                        	datatype: "html",
                        	data: "option=update&decision1="+fa_rate+"&decision2="+op_rate+"&decision3="+ds_rate,
                        	success: function(str){
                            	alert("Success!");
								location.href=('./donate_share.php');
							//journal();
                        	}
                    	});
                });//end submit(d)
				
			    $("#submit_s").click(function(){
						$.ajax({
                       		url:"GET_share.php",
                       		type: "GET",
                       		datatype: "html",
                       		data: "option=update&decision4="+cm_rate+"&decision5="+en_rate+"&decision6="+eh_rate,
                       		success: function(str){
                            	alert("Success!");
								location.href=('./donate_share.php');
						//journal();
                        	}
                    	});
                });//end submit(s)
				
            });//end ready func()
			 
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
				
				if(field=="fa_cost"|| field=="op_cost"|| field=="ds_cost"){
					document.getElementById(field).innerHTML=money_d[(rate)];
					//alert(field);
				}else{
					if(field=="cm_cost"){
						document.getElementById(field).innerHTML=money_s1[(rate)];
						//alert(field);
						}else
					if(field=="en_cost"){
						document.getElementById(field).innerHTML=money_s2[(rate)];
						//alert(field);
						}else
					if(field=="eh_cost"){
						document.getElementById(field).innerHTML=money_s3[(rate)];
						//alert(field);
						}
				}
				var f = field.replace("cost","rate");
				eval(f+"="+rate);
				//eval(field+"_rate")=rate;
				//s.push(field+"："+rate);
				//alert(field+"："+rate);	
				//alert(field+":"+eval(field+"r"));
				//alert(fa_rate);
				show_cost();	
			}
						
			function show_cost(){
				document.getElementById("show_cost_d").innerHTML=addCommas(
															parseInt(document.getElementById("fa_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("op_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ds_cost").innerHTML.replace(/\,/g,''))
															);
				document.getElementById("show_cost_s").innerHTML=addCommas(
															parseInt(document.getElementById("cm_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("en_cost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("eh_cost").innerHTML.replace(/\,/g,''))
															);		
			}
        </script>
        
    </head>
    <body>
    
        <div id="content">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>產品差異化
            <font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            	* 使企業產品、服務、企業形象等與競爭對手有明顯的區別，以獲得競爭優勢 *</font></h1>
                    
    	<script type="text/javascript" src="../star/donate_jquery.rating.js"></script>
		<link href="../star/donate_rating.css" rel="stylesheet"/>
        
        <div id="tabs" class="stContainer">
            <ul>
                <li>
                    <a href="#tabs-1">
                        <img class='logoImage2' border="0" width="22%" src="../images/notebook.jpg">
                        <font size="4">筆電差異化</font>
   
                    </a>
                </li>
                <li>
                    <a href="#tabs-2">
                        <img class='logoImage2' border="0" width="24%" src="../images/pad.jpg">
                        <font size="4">平板差異化</font>
                    </a>
                </li>
            </ul>

        <div id="tabs-1">
         <p>
			
			<table class="table1">
            <thead>
                <tr>
                    <td width="12%"></td>
                    <th scope="col" style="width:50%;">內容</th>
                    <th scope="col" style="width:14%;">等級</th>
                    <th scope="col" style="width:14%">費用</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <th scope="row">半導體晶圓</th>
                    <td style="text-align:left;">晶圓越大，同一圓片上可生產的IC就越多，但對材料技術和生產技術的要求更高！<br>
                    							 各等級花費   ：$100,000、$200,000、$300,000</td> 
					
					<td><span class="rating" id="rate1"></span> 
						<script type="text/javascript">
						$('#rate1').rating('./donate_share.php',{maxvalue:3, emp:"fa_cost"});
						</script>
                        
					</td>
                    <td><span id="fa_cost">0</span></td>
                </tr>
            
                <tr>
                    <th scope="row">多核心處理器</th>
                    <td style="text-align:left;">核心可以獨立執行程式指令，利用平行計算的能力，可以加快程式的執行速度，提供多工能力。<br>
                    							 升級花費：$100,000、$200,000、$300,000</td>
					
                    <td><span class="rating" id="rate2"></span>
						<script type="text/javascript">
						$('#rate2').rating('./donate_share.php',{maxvalue:3, emp:"op_cost"});
                    	</script>
					</td>
                    <td><span id="op_cost">0</span></td>
                </tr>
              
                <tr>
                    <th scope="row">顯示器</th>
                    <td style="text-align:left;">提升螢幕品質，解析度、反應時間、對比度<br>
                    							 各等級花費：$100,000、$200,000、$300,000</td>
                    
					<td><span class="rating" id="rate3">
						<script type="text/javascript">
						$('#rate3').rating('./donate_share.php',{maxvalue:3, emp:"ds_cost"});
                    	</script>
                        </span>
					</td>
                    <td><span id="ds_cost">0</span></td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <th scope="row">總費用</th>
                    <td >$<span id ="show_cost_d">0</span></td><td align="center"></td>
                    </tr>
                     <tr>
                  
                    <td colspan="4" align="center" style="position:relative">
                    <!--<input  type="image" src="../images/reset.png" id="resume" onClick="history.go(0)" style="width:100px" title="重設決策">-->
                    <input type="image" src="../images/submit6.png" id="submit_d" style="width:100px">
                    </td>
                    <td></td>
                    </tr>
                </tfoot>    
            </table> 
            </div> 
              <div id="tabs-2">
            <p>
            <table class="table1">
            <thead>
                <tr>
                    <td width="12%"></td>
                    <th scope="col" style="width:50%">內容</th>
                    <th scope="col" style="width:14%">等級</th>
                    <th scope="col" style="width:14%">費用</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">觸控螢幕 </th>
                    <td style="text-align:left;"><p>提升觸控靈敏度，多點觸控之準確性螢幕整體的解析度<br>
           							       各等級花費：$100,000、$500,000、$300,000</p></td>
                    <td align="center"><span class="rating" id="rate4"></span>
						<script type="text/javascript">
						$('#rate4').rating('./donate_share.php',{maxvalue:3, emp:"cm_cost"});
                    	</script>
					</td>
                    <td><span id="cm_cost">0</span></td>
                </tr>
              
                <tr>
                    <th scope="row">記憶體</th>
                    <td style="text-align:left;">能同時間處理更多的工作，降低閃退、當機問題<br>
                    							 升級花費：$100,000、$500,000、$300,000</td>
                    <td align="center"><span class="rating" id="rate5"></span>
						<script type="text/javascript">
						$('#rate5').rating('./donate_share.php',{maxvalue:3, emp:"en_cost"});
                    	</script>
					</td>
                    <td><span id="en_cost">0</span></td>
                </tr>
              
                <tr>
                    <th scope="row">多核心處理器</th>
                    <td style="text-align:left;">核心可以獨立執行程式指令，利用平行計算的能力，可以加快程式的執行速度，提供多工能力！<br>
                    							 升級花費：$100,000、$200,000、$300,000</td>
                    <td align="center"><span class="rating" id="rate6"></span>
						<script type="text/javascript">
						$('#rate6').rating('./donate_share.php',{maxvalue:3, emp:"eh_cost"});
                    	</script>
					</td>
                    <td><span id="eh_cost">0</span></td>
                </tr>
                
                </tbody>
                 <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <th scope="row">總費用</th>
                    <td>$<span id ="show_cost_s">0</span></td>
                    </tr>
                     <tr>
                  
                    <td colspan="4" align="center" style="position:relative">
                   <!-- <input  type="image" src="../images/reset.png" id="resume" onClick="history.go(0)" style="width:100px">-->
                    <input type="image" src="../images/submit6.png" id="submit_s" style="width:100px">
                    </td>
                    <td></td>
                    </tr>
                </tfoot>    
            </table>
            
        </div><!--end of tabs-2 -->
        </div><!--end of tabs -->
        </div><!-- end content -->
    </body>
</html>