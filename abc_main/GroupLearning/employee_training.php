<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
      <script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
      <link rel="stylesheet" href="../css/style.css"/>
      <script type="text/javascript">
	  	   var f_tcount=0,r_tcount=0,s_tcount=0,e_tcount=0,d_tcount=0;
		   var fn_trate=0,rs_trate=0,ss_trate=0,ex_trate=0,rd_trate=0;
		   $(document).ready(function(){
               initial_get();
               function initial_get(){
                  $.ajax({
                     url:"GET_training.php",
                     type: "GET",
                     datatype: "html",
                     data: "option=get",
                     success: function(str){
                        if(str!="::"){
						   //alert(str)
                           strs=str.split(":");
                        document.getElementById("has_financial_member").innerHTML=strs[0];
						document.getElementById("finan_efc").innerHTML=strs[1];
						document.getElementById("finan_stf").innerHTML=strs[2];
					    document.getElementById("has_resourcing_member").innerHTML=strs[3];
						document.getElementById("resour_efc").innerHTML=strs[4];
						document.getElementById("resour_stf").innerHTML=strs[5];
                        document.getElementById("has_sales_member").innerHTML=strs[6];
                        document.getElementById("sales_efc").innerHTML=strs[7];
                        document.getElementById("sales_stf").innerHTML=strs[8];
                        document.getElementById("has_execute_member").innerHTML=strs[9];
						document.getElementById("execu_efc").innerHTML=strs[10];
						document.getElementById("execu_stf").innerHTML=strs[11];
                        document.getElementById("has_rd_team").innerHTML=strs[12];
						document.getElementById("rd_efc").innerHTML=strs[13];	
                        document.getElementById("rd_stf").innerHTML=strs[14];
						var fn_trate=strs[15];
						var rs_trate=strs[16];
						var ss_trate=strs[17];
						var ex_trate=strs[18];
						var rd_trate=strs[19];
						 $('#rate1').rating('./employee_training.php',{maxvalue:3, emp:"fn_tcost",curvalue:fn_trate});
						 $('#rate2').rating('./employee_training.php',{maxvalue:3, emp:"rs_tcost",curvalue:rs_trate});
					     $('#rate3').rating('./employee_training.php',{maxvalue:3, emp:"ss_tcost",curvalue:ss_trate});
						 $('#rate4').rating('./employee_training.php',{maxvalue:3, emp:"ex_tcost",curvalue:ex_trate});
					     $('#rate5').rating('./employee_training.php',{maxvalue:3, emp:"rd_tcost",curvalue:rd_trate});
						   }
                        }
                    });
                }
				
			    $("#submit").click(function(){
					//alert(fn_trate);
					f_tcount=parseInt(document.getElementById("has_financial_member").innerHTML);
					r_tcount=parseInt(document.getElementById("has_resourcing_member").innerHTML);
					s_tcount=parseInt(document.getElementById("has_sales_member").innerHTML);
					e_tcount=parseInt(document.getElementById("has_execute_member").innerHTML);
					d_tcount=parseInt(document.getElementById("has_rd_team").innerHTML);
					var p=new Array(f_tcount,r_tcount,s_tcount,e_tcount,d_tcount);
					var r=new Array(fn_trate,rs_trate,ss_trate,ex_trate,rd_trate);
					
					for(var i=0; i<5; i++){
						var isvalid=check(p[i],r[i]);
						if(isvalid==false){
							alert("請確認部門人數在有效範圍內(>0)!");
								break;
						}
			 		 }
					 if(isvalid){ 
                   		$.ajax({
                       		url:"GET_training.php",
                        	type: "GET",
                        	datatype: "html",
                        	data: "option=update&decision1="+fn_trate+"&decision2="+rs_trate+"&decision3="+ss_trate+"&decision4="+ex_trate+"&decision5="+rd_trate,
                        	error:
                            	function(xhr) {alert('Ajax request 發生錯誤');},
                        	success: function(str){
								//alert(str);
                            	alert("Success!");
								location.href=('./employee_training.php');
								//journal();
                        	}
                    	});//end ajax
					 }
				});//end submit
            });//end ready func
			
			 function check(num,rate){
				if(num<1 && rate>0)
   					return false;
				else
  					return true;
			}

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
			//alert(money);
			document.getElementById(field).innerHTML=money[(rate)];
			document.getElementById("show_cost").innerHTML=addCommas(parseInt(document.getElementById("fn_tcost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("rs_tcost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ss_tcost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("ex_tcost").innerHTML.replace(/\,/g,''))+
															parseInt(document.getElementById("rd_tcost").innerHTML.replace(/\,/g,'')));
			var f = field.replace("cost","rate");
			eval(f+"="+rate);
			}
        </script>
        <?php
        $connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
        mysql_select_db("testabc_main", $connect);
		error_reporting(0);
        $temp = mysql_query("SELECT `money`,`money2`,`money3` FROM `correspondence` WHERE `name`='training';", $connect);
        $result = mysql_fetch_array($temp);
        $training = number_format($result['money']) . "、" . number_format($result['money2']) . "、" . number_format($result['money3']);
		$cost=split('、',$training);
		echo $_GET["rate"];
		//echo $cost[0];
		echo "<script language=\"javascript\"> var money=new Array(\"0\",\"".$cost[0]."\",\"".$cost[1]."\",\"".$cost[2]."\");</script>";
		//echo $cost[0];
        ?>
    </head>
    <style>
#content{
	height:88%;
	margin-left:4%;
    margin:5px auto;
        }
    </style> 
    <body>
    <div id="content">
        <a class="back" href=""></a>
        <p class="head">
        Activity Based Costing Simulation System
        </p>
        <h1>在職訓練</h1>
        <p>
            
        <script type="text/javascript" src="../js/jquery_showstar.js"></script>
    	<script type="text/javascript" src="../star/training_jquery.rating.js"></script>
		<link href="../star/training_rating.css" rel="stylesheet"/>
        <table class="table1" width="60%">
            <thead>
                <tr>
                    <th></th>
                    <th scope="col">員工人數 </a></th>
                    <th scope="col">目前績效</th>
                    <th scope="col"> 滿意度 </th>
                    <th scope="col" colspan="2">提升等級</th>
                    <th scope="col" width="10%">費用</th>
                </tr>
            </thead>
            <tbody>
            
                <tr>
                    <th scope="row">財務人員</th>
                    <td><span id="has_financial_member"></span></td>
                    <td><span id="finan_efc"></span></td>
                    <td><span id="finan_stf"></span></td>
                    <td colspan="2"><span class="rating" id="rate1"></span>
			     	<script type="text/javascript">
						$('#rate1').rating('./employee_training.php',{maxvalue:3, emp:"fn_tcost"});
                    </script></td>  
                    <td style="text-align:right" width="10%"><span id="fn_tcost">0</span></td>
                </tr>
                
                <tr>
                    <th scope="row">運籌人員</th>
                    <td><span id="has_resourcing_member"></span></td>
                    <td><span id="resour_efc"></span></td>
                    <td><span id="resour_stf"></span></td>
                    <td colspan="2"><span class="rating" id="rate2"></span>
			        <script type="text/javascript">
						$('#rate2').rating('./employee_training.php',{maxvalue:3, emp:"rs_tcost"});
                    </script></td>
                    <td style="text-align:right" width="10%"><span id="rs_tcost">0</span></td>
                </tr>
                
                <tr>
                    <th scope="row">行銷與業務<br>人員</th>
                    <td><span id="has_sales_member"></span></td>
                    <td><span id="sales_efc"></span></td>
                    <td><span id="sales_stf"></span></td>
                    <td colspan="2"><span class="rating" id="rate3"></span>
					<script type="text/javascript">	
						$('#rate3').rating('./employee_training.php',{maxvalue:3, emp:"ss_tcost"});
                    </script></td>
                    <td style="text-align:right" width="10%"><span id="ss_tcost">0</span></td>
                </tr>
                    
                <tr>
                    <th scope="row">行政人員</th>
                    <td><span id="has_execute_member"></span></td>
                    <td><span id="execu_efc"></span></td>
                    <td><span id="execu_stf"></span></td>
                    <td colspan="2"><span class="rating" id="rate4"></span>
               		<script type="text/javascript">
						$('#rate4').rating('/employee_training.php',{maxvalue:3, emp:"ex_tcost"});
                    </script></td>
                    <td style="text-align:right" width="10%"><span id="ex_tcost">0</span></td>
                </tr>
                
                <tr>
                    <th scope="row">研發團隊</th>
                    <td><span id="has_rd_team"></span></td>
                    <td><span id="rd_efc"></span></td>
                    <td><span id="rd_stf"></span></td>
                    <td colspan="2"><span class="rating" id="rate5"></span>
		     		<script type="text/javascript">
						$('#rate5').rating('/employee_training.php',{maxvalue:3, emp:"rd_tcost"});
                    </script></td>
                    <td style="text-align:right" width="10%"><span id="rd_tcost">0</span></td>
                </tr>
     
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <td></td>
                    <td></td>
                    
                    <th scope="row" colspan="2" align="center">總訓練費用</th>
                    <td colspan="2" style="text-align:right">$<span id="show_cost">0</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="3" align="center" style="position:relative">
                   <!-- <input  type="image" src="../images/reset.png" id="resume" onclick="location.href='employee_training.php'" style="width:100px">-->
                    <input type="image" src="../images/submit6.png" id="submit" style="width:100px">
                    </td>
                    <td></td>
                    <td></td>
                    </tr>
                </tfoot>
            </table>    
        </div>
        </body>
</html>