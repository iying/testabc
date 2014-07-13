<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>無標題文件</title>
        <?php 
		error_reporting(E_ALL ^ E_DEPRECATED);

			include("../connMysql.php");
			if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
			mysql_query("set names 'utf8'");
			$cid=$_SESSION['cid'];
			$year=$_SESSION['year'];
			$month=$_SESSION['month'];
			$round=$month+($year-1)*12;
		
		
			$name_arr = array("finance_salary" => 0 , "equip_salary" => 0 , "sale_salary" => 0 , "human_salary" => 0 , "research_salary" => 0);
			foreach($name_arr as $name => $value){
				$temp = mysql_query("SELECT `value` FROM `parameter_description` WHERE `name`='$name'");
				$result = mysql_fetch_array($temp);
				$salary_arr[$name] = $result[0];
			}
			
		?>
		<link href="../css/smart_tab.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <link rel="stylesheet" href="../css/style.css"/>
        <script type="text/javascript">
            var f_hcount=0,r_hcount=0,s_hcount=0,e_hcount=0,d_hcount=0;
            var f_fcount=0,r_fcount=0,s_fcount=0,e_fcount=0,d_fcount=0;
            var current_f=0,current_e=0,current_s=0,current_h=0,current_r=0;
            $(document).ready(function(){
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
				//show fire costs
				$.ajax({
					url:"human_resource.php",
					type: "GET",
					datatype: "html",
					data: {type:"fire_money"},
					success: function(str){
						if(str!="::")
							var word=str.split(":");
							document.getElementById("get_fn_member_cost1").innerHTML=parseInt(word[0],10)*3;
							document.getElementById("get_rs_member_cost1").innerHTML=parseInt(word[1],10)*3;
							document.getElementById("get_ss_member_cost1").innerHTML=parseInt(word[2],10)*3;
							document.getElementById("get_ex_member_cost1").innerHTML=parseInt(word[3],10)*3;
							document.getElementById("get_rd_team_cost1").innerHTML=parseInt(word[4],10)*3*5;
					}
				});
				//show hire costs	
				$.ajax({
					url:"human_resource.php",
					type: "GET",
					datatype: "html",
					data: {type:"hire_money"},
					success: function(str){
						var word=str.split(":");
						var hire_money=parseInt(word[0],10);
						document.getElementById("get_fn_member_cost").innerHTML=hire_money;
						document.getElementById("get_rs_member_cost").innerHTML=hire_money;
						document.getElementById("get_ss_member_cost").innerHTML=hire_money;
						document.getElementById("get_ex_member_cost").innerHTML=hire_money;
						document.getElementById("get_rd_team_cost").innerHTML=hire_money*5;
						}
				});
				//get each member's current amount 
                $.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"finan"},
                    success: function(str){
						//alert(str);
                        arr=str.split("|");
                        current_f=parseInt(arr[0]);
						//總招解聘人數
                        f_hcount=parseInt(arr[1]);
                        f_fcount=parseInt(arr[2]);
						//show current member number
						document.getElementById("has_fn_member").innerHTML=current_f;
						document.getElementById("has_fn_member1").innerHTML=current_f;
						document.getElementById("fn_thismonth").innerHTML=f_hcount;
						document.getElementById("fn_thismonth1").innerHTML=f_fcount;
						}
                });
                $.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"equip"},
                    success: function(str){
                        arr=str.split("|");
                        current_e=parseInt(arr[0]);
                        e_hcount=parseInt(arr[1]);
                        e_fcount=parseInt(arr[2]);
						//current_e=e_hcount-e_fcount;
						//show current member number
						document.getElementById("has_rs_member").innerHTML=current_e;
						document.getElementById("has_rs_member1").innerHTML=current_e;
						document.getElementById("rs_thismonth").innerHTML=e_hcount;
						document.getElementById("rs_thismonth1").innerHTML=e_fcount;
                        }
                });$.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"sale"},
                    success: function(str){
                        arr=str.split("|");
                        current_s=parseInt(arr[0]);
                        s_hcount=parseInt(arr[1]);
                        s_fcount=parseInt(arr[2]);
						//current_s=s_hcount-s_fcount;
						//show current member number
						document.getElementById("has_ss_member").innerHTML=current_s;
						document.getElementById("has_ss_member1").innerHTML=current_s;
						document.getElementById("ss_thismonth").innerHTML=s_hcount;
						document.getElementById("ss_thismonth1").innerHTML=s_fcount;
                        }
                });$.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"human"},
                    success: function(str){
                        arr=str.split("|");
                        current_h=parseInt(arr[0]);
                        h_hcount=parseInt(arr[1]);
                        h_fcount=parseInt(arr[2]);
						//current_h=h_hcount-h_fcount;
						//show current member number
						document.getElementById("has_ex_member").innerHTML=current_h;
						document.getElementById("has_ex_member1").innerHTML=current_h;
						document.getElementById("ex_thismonth").innerHTML=h_hcount;
						document.getElementById("ex_thismonth1").innerHTML=h_fcount;
						}
                });$.ajax({
                    url:"human_resource.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"research"},
                    success: function(str){
						//alert(str);
                        arr=str.split("|");
                       	current_r=parseInt(arr[0]);
                        r_hcount=parseInt(arr[1]);
                        r_fcount=parseInt(arr[2]);
						/*var year=arr[3];
						var month=arr[4];
						if(year=1 && month=1) get_rd disabled
						show current member number*/
						document.getElementById("has_rd_team").innerHTML=current_r;
						document.getElementById("has_rd_team1").innerHTML=current_r;
						document.getElementById("rd_thismonth").innerHTML=r_hcount;
						document.getElementById("rd_thismonth1").innerHTML=r_fcount;
						/*if(year==1 && month==1){
							document.getElementById("get_rd_team").disabled=true;
							document.getElementById("get_rd_team1").disabled=true;
						}*/ 
					}
                });	
				
			//hire submit button
			$("#hire").click(function(){
				f_hcount=document.getElementById("get_fn_member").value;
				e_hcount=document.getElementById("get_rs_member").value;
				s_hcount=document.getElementById("get_ss_member").value;
				h_hcount=document.getElementById("get_ex_member").value;
				r_hcount=document.getElementById("get_rd_team").value*5;
				current_f=document.getElementById("has_fn_member").innerHTML;
				current_r=document.getElementById("has_rs_member").innerHTML;
				current_s=document.getElementById("has_ss_member").innerHTML;
				current_e=document.getElementById("has_ex_member").innerHTML;
				current_d=document.getElementById("has_rd_team").innerHTML;
				
				var hc=new Array(f_hcount,e_hcount,s_hcount,h_hcount,r_hcount);
					 for(var i=0; i<hc.length; i++){	
						var isvalid=check_h(hc[i]);
						if(isvalid==false){
							alert("請確認招聘人數在有效範圍內!");
								break;
						}
			 		 }
				if(isvalid){ 
					$.ajax({
                        url:"human_resource.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"hire_submit",f:hc[0],e:hc[1],s:hc[2],h:hc[3],r:hc[4]}
					});
                	alert("Hire Success!!");
					location.href= ('./hire_fire.php'); 
			   }
			});
			
			//fire submit button
			$("#fire").click(function(){
				f_fcount=document.getElementById("get_fn_member1").value;
				e_fcount=document.getElementById("get_rs_member1").value;
				s_fcount=document.getElementById("get_ss_member1").value;
				h_fcount=document.getElementById("get_ex_member1").value;
				r_fcount=document.getElementById("get_rd_team1").value*5;
				current_f=document.getElementById("has_fn_member1").innerHTML;
				current_r=document.getElementById("has_rs_member1").innerHTML;
				current_s=document.getElementById("has_ss_member1").innerHTML;
				current_e=document.getElementById("has_ex_member1").innerHTML;
				current_d=document.getElementById("has_rd_team1").innerHTML;
				
				var fc=new Array(f_fcount,e_fcount,s_fcount,h_fcount,r_fcount);
				var cp=new Array(current_f,current_r,current_s,current_e,current_d);  
					 for(var i=0; i<fc.length; i++){
						var isvalid=check_f(fc[i],cp[i]);
						if(isvalid==false){
							alert("請確認解聘人數在有效範圍內!");
								break;
						}
			 		 }
				if(isvalid){ 
					$.ajax({
                        url:"human_resource.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"fire_submit",f:fc[0],e:fc[1],s:fc[2],h:fc[3],r:fc[4]}
                    });
                    alert("Fire Success!!");
					location.href= ('./hire_fire.php'); 	
				}
			});
				
		});//end ready func
		    
		function check_h(hnum){
			if(hnum>=0)
   				return true;
			else	
  				return false;
		} 
		function check_f(fnum,curp){
			if(fnum<=curp)
   				return true;
			else
  				return false;
		}
			
		function addCommas(nStr){	
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
			//-----------------------------------grayTips-----------------------------------
		function inputTipText(){    
    		$("input[class*=grayTips]")
	
			 //所有樣式名中含有grayTips的input  
			.each(function(){   
       			var oldVal=$(this).val();   //默認的提示性文字   
				$(this)   
				.css({"color":"#888"})
		  		//灰色
				.focus(function(){ 
		  
				if($(this).val()!=oldVal){$(this).css({"color":"#000"})}else{$(this).val("").css({"color":"#888"} )} 
			})
		
       	    .blur(function(){   
      		    if($(this).val()==""){$(this).val(oldVal).css({"color":"#888"})}
			})  
		 
			.keydown(function(){$(this).css({"color":"#000"})})   
			})   
		}   
  
		$(function(){   
		inputTipText(); //顯示   
	})	
			
			//update total hire cost
            function hire_total(){
				$.ajax({
					url:"human_resource.php",
					type: "GET",
					datatype: "html",
					data: {type:"hire_money"},
					success: function(str){
						var word=str.split(":");
						var hire_money=parseInt(word[0],10);
						var total_hcount=1*h_hcount+1*s_hcount+1*e_hcount+1*f_hcount+1*r_hcount;
						document.getElementById("hire_total").textContent=addCommas(total_hcount*hire_money);
						
					}
				});
            }
			//update total fire costs
            function fire_total(){
				$.ajax({
					url:"human_resource.php",
					type: "GET",
					datatype: "html",
					data: {type:"fire_money"},
					success: function(str){
						if(str!="::")
							var word=str.split(":");
						document.getElementById("fire_total").textContent=addCommas(f_fcount*parseInt(word[0],10)*3+e_fcount*parseInt(word[1],10)*3+s_fcount*parseInt(word[2],10)*3+h_fcount*parseInt(word[3],10)*3+r_fcount*parseInt(word[4],10)*3);
					}
				});
            }
			//by shiowgwei
			//輸入值(離開textbox or 按Enter)後，金額立即變動
			function change(){
				f_hcount=document.getElementById("get_fn_member").value;
				e_hcount=document.getElementById("get_rs_member").value;
				s_hcount=document.getElementById("get_ss_member").value;
				h_hcount=document.getElementById("get_ex_member").value;
				r_hcount=document.getElementById("get_rd_team").value*5;
				f_fcount=document.getElementById("get_fn_member1").value;
				e_fcount=document.getElementById("get_rs_member1").value;
				s_fcount=document.getElementById("get_ss_member1").value;
				h_fcount=document.getElementById("get_ex_member1").value;
				r_fcount=document.getElementById("get_rd_team1").value*5;
				hire_total();
				fire_total();
				}
			function setStyle(x){
				document.getElementById(x).value="";
			}	

        </script>
    </head>
    <body>
    
        <div id="content" style="height:88%">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
                
            <h1>招 / 解聘員工&nbsp;
            	<font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            	* 競賽初始已先幫各公司聘雇一研發團隊以便直接研發 *</font></h1>
            
        <div id="tabs" class="stContainer" style="width:102%">
            <ul>
                <li>
                    <a href="#tabs-1">
                        <img class='logoImage2' border="0" width="20%" src="../images/Step1.png">
                        <font size="5">招聘<br /></font>
                    </a>
                </li>
                <li>
                    <a href="#tabs-2">
                        <img class='logoImage2' border="0" width="20%" src="../images/Step2.png">
                        <font size="5">解聘<br /></font>
                    </a>
                </li>
            </ul>

        <div id="tabs-1">
            <p>
            <li style=" position:absolute; float:right; width:27%; height:100%; right:0%; background-image:url(../images/note01.png); background-repeat:no-repeat;"></li>
       <table class="table1" style="width:65%">
            <thead>
                <tr>
                    <td style="width:10%"></td>
                    <th scope="col" style="width:7%">各部門人數</th>
                    <th scope="col" style="width:10%">招聘費用</th>
                    <th scope="col" style="width:7%">本月招聘人數</th>
                    <th scope="col" style="width:3%">招聘</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">財務人員<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['finance_salary']); ?> / 月</font></th>
                    <td><span id="has_fn_member"></span></td>
                    <td><span id="get_fn_member_cost"> </span> / 1人</td>
                    <td><span id="fn_thismonth"></span></td>
                    <td><input id="get_fn_member" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 人</td>
                <tr>
                    <th scope="row">運籌人員<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['equip_salary']); ?> / 月</font></th>
                    <td><span id="has_rs_member"> </span></td>
                    <td><span id="get_rs_member_cost"> </span> / 1人</td>
                    <td><span id="rs_thismonth"></span></td>
                    <td><input id="get_rs_member" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 人</td>
                </tr>
                <tr>
                    <th scope="row">行銷與業務人員<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['sale_salary']); ?> / 月</font></th>
                    <td><span id="has_ss_member"> </span></td>
                    <td><span id="get_ss_member_cost"> </span> / 1人</td>
                    <td><span id="ss_thismonth"></span></td>
                    <td><input id="get_ss_member" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 人</td>
                </tr>
                <tr>
                    <th scope="row">行政人員<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['human_salary']); ?> / 月</font></th>
                    <td><span id="has_ex_member"> </span></td>
                    <td><span id="get_ex_member_cost"> </span> / 1人</td>
                    <td><span id="ex_thismonth"></span></td>
                    <td><input id="get_ex_member" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 人</td>
                </tr>
                <tr>
                    <th scope="row">研發團隊<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['equip_salary']*5); ?> / 月</font></th>
                    <td><span id="has_rd_team"> </span></td>
                    <td><span id="get_rd_team_cost"> </span> / 5人</td>
                    <td><span id="rd_thismonth"></span></td>
                    <td><input id="get_rd_team" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 隊</td>                
                </tr>
                </tbody>
                <tfoot>
                <tr>
                	<td></td>
                    <th scope="row">招聘總費用</th>
                    <td colspan="2">$<span id ="hire_total">0</span></td><td align="center"><input type="image" src="../images/submit6.png" id="hire" style="width:100px"></td>
                    </tr>
                </tfoot>    
            </table> 
            </div> 
             <div id="tabs-2">
            <p>
          		<li style="float:right; position:absolute; width:27%; height:100%; right:0%; background-image:url(../images/note02.png); background-repeat:no-repeat;"></li>
            <table class="table1" style="width:65%">
            <thead>
                <tr>
                    <td style="width:10%"></td>
                    <th scope="col" style="width:7%">各部門人數</th>
                    <th scope="col" style="width:10%">解聘費用</th>
                    <th scope="col" style="width:7%">本月解聘人數</th>
                    <th scope="col" style="width:5%">解聘</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">財務人員<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['finance_salary']); ?> / 月</font></th>
                    <td><span id="has_fn_member1"></span></td>
                    <td><span id="get_fn_member_cost1"></span> / 1人</td>
                    <td><span  id="fn_thismonth1"></span></td>
                    <td><input id="get_fn_member1" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 人</td>
                    <!--<td rowspan="5" width="30%"><a title="運籌與生產部門的人會隨著生產線的購買而配置。其他部門人數的多寡決定該部門營收的負荷量。聘僱員工太少的部門會成為瓶頸。資遣員工須支付<b><font color=#FF3030>三個月薪資</font></b>資遣費用。"><img  width="100%" src="images/guide.png"></a></td>
                </tr>-->
                <tr>
                    <th scope="row">運籌人員<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['equip_salary']); ?> / 月</font></th>
                    <td><span id="has_rs_member1"></span></td>
                    <td><span id="get_rs_member_cost1"></span> / 1人</td>
                   <td><span  id="rs_thismonth1"></span></td>
                    <td><input id="get_rs_member1" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 人</td>
                </tr>
                <tr>
                    <th scope="row">行銷與業務人員<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['sale_salary']); ?> / 月</font></th>
                    <td><span id="has_ss_member1" ></span></td>
                    <td><span id="get_ss_member_cost1"></span> / 1人</td>
                    <td><span  id="ss_thismonth1"></span></td>
                    <td><input id="get_ss_member1" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 人</td>
                </tr>
                <tr>
                    <th scope="row">行政人員<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['human_salary']); ?> / 月</font></th>
                    <td><span id="has_ex_member1"></span></td>
                    <td><span id="get_ex_member_cost1"></span> / 1人</td>
                    <td><span  id="ex_thismonth1"></span></td>
                    <td><input id="get_ex_member1" class="grayTips" onChange="change()" size="3px" style="text-align:right"> 人</td>
                </tr>
                <tr>
                    <th scope="row">研發團隊<br><font size="-1" color="#666">$<?php echo number_format($salary_arr['equip_salary']*5); ?> / 月</font></th>
                    <td><span id="has_rd_team1"></span></td>
                    <td><span id="get_rd_team_cost1"></span> / 5人</td>
                    <td><span  id="rd_thismonth1"></span></td>
                    <td><input id="get_rd_team1"  class="grayTips" onChange="change()" size="3px" style="text-align:right"> 隊</td>                
                </tr>
                </tbody>
                <tfoot>
                <tr>
                	<td></td>
                    <th scope="row">解聘總費用</th>
                    <td colspan="2">$<span id ="fire_total">0</span></td><td align="center"><input type="image" src="../images/submit6.png" id="fire" style="width:100px"></td>
                    </tr>
                </tfoot>    
            </table>
            </div>
             </div>
        </div>
    </body>

</html>