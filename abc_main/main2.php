<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="css/all-examples.css">
<title>ABC Decision</title>
<?php
	include("./connMysql.php");
	$cname=$_SESSION['CompanyName'];
	$cid=$_SESSION['cid'];
	$acc=$_SESSION['user'];
	if($acc=="")
		echo "<script language=\"JavaScript\"> alert('登入已過期，請從新登入!'); location.href=('../abc_login/player_login.php')</script>";
	
	mysql_select_db("testabc_main");
	$sql_year = "SELECT MAX(`year`) FROM `state`";
	$result = mysql_query($sql_year) or die("Query failed@month");	
	$rowy=mysql_fetch_array($result);
	$year=$rowy[0];
	
	$sql_month = "SELECT MAX(`month`) FROM `state` WHERE `year`=$rowy[0];";
	$result = mysql_query($sql_month) or die("Query failed@month");	
	$rowm=mysql_fetch_array($result);
	$month=$rowm[0];
	
	$_SESSION['year']=$year;
	$_SESSION['month']=$month;
	
	//error_reporting(0);
if($month==1&$year==1)
	{
	$temp = mysql_query("SELECT `cash` FROM `cash` WHERE `cid`='$cid' AND `year`='$year' AND `month`='$month'");
    $money = mysql_fetch_array($temp);
    $cash = $money[0];
	}
	else 
	{
		$monthtest=$month-1;
		if($monthtest==0)
		{
			$monthtest=12;
			$year-=1;
			$temp = mysql_query("SELECT `cash` FROM `cash` WHERE `cid`='$cid' AND `year`='$year' AND `month`='$monthtest'");
		
			$money = mysql_fetch_array($temp);
			$cash = $money[0];	
			$year+=1;	
		}
		else{
		$temp = mysql_query("SELECT `cash` FROM `cash` WHERE `cid`='$cid' AND `year`='$year' AND `month`='$monthtest'");
		
		$money = mysql_fetch_array($temp);
		$cash = $money[0];
		}
	}

	//echo $year."|".$month."|".$cid;
	mysql_select_db("testabc_login"); //get cid
	$sql_cid = mysql_query("SELECT `cid` FROM `authority` WHERE `account`='".$acc."'");
	$cid = mysql_fetch_array($sql_cid);
	$_SESSION['cid']=$cid[0];
	
	$sql_decision = mysql_query("SELECT `decision` FROM `authority` WHERE `account`='".$acc."'");
	$decision = mysql_fetch_array($sql_decision);
	
	$sql_gettime = mysql_query("SELECT * FROM `time` WHERE `id`='".(12*($year-1)+$month)."'");
	$gettime = mysql_fetch_array($sql_gettime);
	$endtime=$gettime['endtime'];
	//echo $endtime;
	
	$sql_gamestate = mysql_query("SELECT * FROM `timer` WHERE `id`=1");
	$gamestate = mysql_fetch_array($sql_gamestate);
	$gameyear=$gamestate['gameyear'];
	$gamestatus=$gamestate['status'];
	//echo $gamestatus;
	
	//decision
	$sql_infod= mysql_query("SELECT * FROM `info_decision`");
	$info_d=mysql_fetch_array($sql_infod);
?>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
  <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.min.js"></script>
  
  

    </head>

    <script type="text/javascript">

        $(function(){

            $("#divShow").hide();

             

            $('body').click(function(evt) {

                if($(evt.target).parents("#divShow").length==0 &&

                    evt.target.id != "aaa" && evt.target.id != "divShow") {

                    $('#divShow').hide();

                }

            });

        });

    </script>
<script type=text/javascript>
$(function(){
	clock();
	$('#webmenu li').hover(function(){
		$(this).children('ul').stop(true,true).show('slow');
	},function(){
		$(this).children('ul').stop(true,true).hide('slow');
	});
	
	$('#webmenu li').hover(function(){
		$(this).children('div').stop(true,true).show('slow');
	},function(){
		$(this).children('div').stop(true,true).hide('slow');
	});
});
</script>

<noscript>
		<style type="text/css">
			#dock { top: 0; left: 100px; }
			a.dock-item { position: relative; float: left; margin-right: 10px; }
			.dock-item span { display: block; }
			.stack { top: 0; }
			.stack ul li { position: relative; }
		</style>
</noscript>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/fisheye-iutil.min.js"></script>
	<script type="text/javascript" src="js/dock-example1.js"></script>
	<script type="text/javascript" src="js/jquery.jqDock.min.js"></script>
	<script type="text/javascript">
	  
		$(function(){
			var jqDockOpts = {align: 'left', duration: 200, labels: 'tc', size: 50, distance: 90};
			$('#jqDock').jqDock(jqDockOpts);
		});
		
		function clock(){
			if('<?php echo $gamestatus; ?>' == '競賽暫停中')
				document.getElementById("lefttime").innerHTML = "競賽暫停中";
			else if("<?php echo $gamestatus; ?>" == '競賽結束')
				document.getElementById("lefttime").innerHTML = "競賽結束";
			else if("<?php echo $gamestatus; ?>" == '競賽未啟動')
				document.getElementById("lefttime").innerHTML = "競賽未啟動";
			else{
				var roundEndTime=<?php echo $endtime; ?>;
				//此回合剩餘秒數
				var TimeLeft=(roundEndTime*1000-(new Date().getTime()))/1000;
				if(TimeLeft>0){

			var hour = Math.floor((TimeLeft/3600));
			document.getElementById("lefttime").innerHTML = hour + ' 時  \t'+ Math.floor((TimeLeft%3600)/60)+' 分  \t'+' '+Math.floor(TimeLeft%60)+' 秒';
			setTimeout("clock()",1000);
					
			    }
			else{
					location.href="./main.php";
					//location.href="./main.php";					
					
}

			
			}
		}//end clock
		
		function check_authority(dnum, order){
			var isvalid=false;
//   		alert(dnum+":"+order);
			var dec="<?php echo $decision[0];?>";
			var d=dec.split(",");
			
			for(var i=0;i< d.length;i++){
				
				if(dnum == d[i]){
					isvalid=true;
					break;		
				}
				else
					isvalid=false;
			}//end for
			
			if(isvalid){
				if(dnum==1)
					document.getElementById('contentiframe').src='./ProfitModel/selling_cost_analyzing.php';
				else if(dnum==2){
					document.getElementById('contentiframe').src='./ProfitModel/revenue_model.php';
				}
				else if(dnum==3)
					document.getElementById('contentiframe').src='./ResourceIntegration/fund_raising.php';
				else if(dnum==4)
					checkrd_emp();
				else if(dnum==5)
					document.getElementById('contentiframe').src='./ResourceIntegration/purchase_machine.php';
				else if(dnum==6)
					document.getElementById('contentiframe').src='./ResourceIntegration/sell_machine.php';
				else if(dnum==7)
					checkm_rd();
				else if(dnum==8)
					document.getElementById('contentiframe').src='./ValueWork/process.php';
				else if(dnum==9)
					document.getElementById('contentiframe').src='./ValueRelationship/donate_share.php';//!!!
				else if(dnum==10)
					document.getElementById('contentiframe').src='./ValueWork/product_plan.html';
				else if(dnum==11)
					document.getElementById('contentiframe').src='./GroupLearning/hire_fire.php';
				else if(dnum==12)
					document.getElementById('contentiframe').src='./GroupLearning/employee_training.php';
				else if(dnum==13)
					document.getElementById('contentiframe').src='./GroupLearning/efficiency_evaluate.html';
				else if(dnum==14)
					document.getElementById('contentiframe').src='./MarketFocus/advertisement.php';
				else if(dnum==15)
					document.getElementById('contentiframe').src='./MarketFocus/taiwan_order.php';
				else if(dnum==16)
					alert("從缺中");
				else if(dnum==17){
					if(order==1)
						document.getElementById('contentiframe').src='./MarketFocus/market_occupy.html';
					else
						document.getElementById('contentiframe').src='./MarketFocus/market_trend.html';
				}
				else if(dnum==18)
					document.getElementById('contentiframe').src='./ValueProposition/order_result.html';
				else if(dnum==19)
					document.getElementById('contentiframe').src='./ValueProposition/customer_satisfaction.php';
				else if(dnum==20){
					if(order==1)
						document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=1';
					else if(order==2)
						document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=2';
					else if(order==3)
						document.getElementById('contentiframe').src='./ValueRelationship/customer_relationship.php';
					else if(order==4)
						document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=4';
					else if(order==5)
						document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=5';
				}
						
				//end 判斷dnum
															
			document.getElementById('contentiframe').width='100%';		
			}//end isvalid
			else{
				alert("您沒有此決策的權限!");
				//document.location.href="./main.php";
			}//end notvalid
		}//end function check authority
		
		//有研發才可購買原料
		function checkm_rd(){
			 $.ajax({
                    url: './check_decision.php',
					type:'GET',
					async:false,
					data: {type:'rd'},
					error:
					function(xhr) {alert('Ajax request 發生錯誤');},
					success:
						function(str){
							//alert(str);		
							//if(A或B都沒有研發過)
							var s=str.split("|");
							if(str === 'undone')
								alert('請先至研發處研發產品!');
							else if(str === 'notyet')
								alert('研發一產品為期一個月，請等候產品研發完成!');
							else	
								document.getElementById('contentiframe').src='./ResourceIntegration/purchase_material.php';	
						}	
			 });
		}
		//有聘僱研發人員才可研發
		function checkrd_emp(){
			 $.ajax({
                    url: './check_decision.php',
					type:'GET',
					async:false,
					data: {type:'e_rd'},
					error:
					function(xhr) {alert('Ajax request 發生錯誤');},
					success:
						function(str){
							//alert(str);		
							//if(沒有聘僱研發人員)
							if(str === 'NO')
								alert('請先聘僱研發人員!');
							else
								document.getElementById('contentiframe').src='./ResourceIntegration/research_and_develop.php';	
						}	
			 });
		}
		
		 function logout(){
			 document.location.href="./logout.php";
			 }	
		 	function transfer(url){
                frames[1].location.href=url;
            }
           //驗證
		   function pre_report(){
				jQuery.ajax({
					   url: './check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								jQuery.ajax({
									url: './check_decision.php',
									type:'GET',
									async:false,
									data: {type:'4',key:'month'},
									error:
										function(xhr) {alert('Ajax request 發生錯誤');},
									success:
										function(str){
										if(str=="1|1")
											alert("第1個月尚未有報表!")//(′．ω．‵)
										else {
											document.getElementById('contentiframe').width="100%";
											document.getElementById('contentiframe').src='./LeftFeatures/each_report2.php';
										}
									}
								});
							}
							else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
				});
                
            }
            function dupont(){
				jQuery.ajax({
					   url: 'check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								jQuery.ajax({
									url: 'check_decision.php',
									type:'GET',
									async:false,
									data: {type:'4',key:'month'},
									error:
										function(xhr) {alert('Ajax request 發生錯誤');},
									success:
										function(str){
										if(str=="1|1")
											alert("第1個月尚未有資料可以分析!");
										else{ 
											document.getElementById('contentiframe').width="100%";
											document.getElementById('contentiframe').src='./LeftFeatures/dupont.php'
										}
									}
								});
							}
							else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
					});
            }
            function rank(){
				jQuery.ajax({
					   url: 'check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								jQuery.ajax({
									url: 'check_decision.php',
									type:'GET',
									async:false,
									data: {type:'4',key:'month'},
									error:
										function(xhr) {alert('Ajax request 發生錯誤');},
									success:
										function(str){
										if(str=="1|1")
											alert("第1個月尚未有資料可以分析!");
										else{ 
											document.getElementById('contentiframe').width="100%"; 
											document.getElementById('contentiframe').src='./LeftFeatures/rank2.php';
										}
									}
								});
							}
							else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
				   });
            }
            function home(){
				jQuery.ajax({
					   url: 'check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
				                frames[0].location.href="anime.html";
							}else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
					});
            }
            function decision(){
				jQuery.ajax({
					   url: './check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								document.getElementById('contentiframe').width="100%";
				                document.getElementById('contentiframe').src='./LeftFeatures/decision.php';
							}else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
								
							}
						}
					});
            }
            function information(){
				jQuery.ajax({
					   url: './check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                   	   success:
                        function(str){
							if(str === 'YES'){
								document.getElementById('contentiframe').width="100%";
								document.getElementById('contentiframe').src='./LeftFeatures/Company_info/companyinfo2.php';
							}else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
					});
            }
            function journal(){
					jQuery.ajax({
					   url: 'check_session.php',
					   type: 'GET',
					   async: false,
					   error:
                        function(xhr) {alert('Ajax request 發生錯誤');},
                    success:
                        function(str){
							if(str === 'YES'){
								document.getElementById('contentiframe').width="100%";
 				                document.getElementById('contentiframe').src='./LeftFeatures/journal.html';
							}else if(str === 'NO'){
								alert('登入已過期，請重新登入!');
								document.location.href="../abc_login/player_login.php";
							}
						}
					});				
            }//end func(journal)
			
	</script>

</head>
<body>
<table width="100%" height="12%">
      <td width="1%"></td> 
      <td width="2%" title="back"><a href="javascript:history.back()"><img src="images/1-navigation-back.png" width="32" height="34" /></a></td>
      <td width="2%" title="forward"><a href="javascript:history.forward()"><img src="images/1-navigation-forward.png" width="32" height="34" /></a></td>
      <td width="3%" title="main"><a href="main.php"><img src="images/12-hardware-dock.png" width="32" height="34" /></a></td>
      <td width="1%"></td>
      <td width="12%"> 公司帳號： <strong><font color=#ff6><?php echo $cid[0];?></font></strong></td>
      <td width="14%"> 公司名稱： <strong><font color=#ff6><?php echo $cname;?></font></strong></td>
      <td width="14%"> 個人帳號：<strong><font color=#ff6><?php echo $acc;?> </font></strong></td>
      <td width="36%">資金:<strong><font color=#ff6><?php echo $cash;?> </font></strong></td>
      <td width="14%">倒數： <strong><font color=#ff6><span id="lefttime"></span></font></strong></td>
      <td width="6%" align="right" title="logout"><img src="images/logout.png" width="32" height="32" onclick="logout()"/></td>
      <td width="1%"></td>

  </table>
<div id="header2">
<ul id="webmenu" class="first-menu"><!--check_authority(第幾號決策,同決策包含兩頁)-->
 <li style="width:9.5%"><a style="color:#ff6; background:none; border:none; font-size:13px;" target="_self"><strong><?php echo "&nbsp;&nbsp; 第 ".$year." 年 &nbsp;&nbsp;".$month."月";?></strong></a></li>
 <li><a href="#" class="arrow" target="_self">公司治理</a>
	<ul id="subMgm" class="second-menu">
    	<li><a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/organization2.php'" target="_self">組織架構與決策分配</a></li>
    	<li><a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/kpi2.php'" target="_self">KPI關鍵績效指標</a></li>
        <li><a href="#" class="arrow">預算</a><!--所有人都能看   沒設計權限門檻-->
            <ul class="third-menu">
            <li><a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/Budget_Set.php'">編製預算</a></li>
            <li><a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/Budget_Check.php'">成效檢視</a></li>
            <li><a href="#" onclick="document.getElementById('contentiframe').src='./CompanyGovern/Budget_income.php'">預算報表</a></li>
            </ul>
        </li>
   	</ul>
 </li>  
 <li><a href="#" target="_self">價值創造</a>
    <ul id="subMgm" class="second-menu">
    	<li><a href="#" class="arrow">獲利模式</a>
        	<ul class="third-menu">
      	 	<li><a href="#" onclick="check_authority(1,0)">銷貨成本分析</a></li>
     	   	<li><a href="#" onclick="check_authority(2,0)">營收來源</a> </li>
    		</ul>
  		</li>
    	<!--<li><a href="#" onclick="check_authority(1,0)" target="_self">資本結構</a></li>-->
   	</ul>
 </li> 
 <li><a href="#" class="arrow" target="_self">資源整合</a>
    <ul id="subMgm" class="second-menu">
    	<li><a href="#" onclick="check_authority(3,0)" >資金募集</a></li>
      	<li><a href="#" onclick="check_authority(4,0)">研究 / 開發</a></li>
      	<li><a href="#" class="arrow" target="_self">資產購置 / 處分</a>
        	<ul class="third-menu">
          	<li><a href="#" onclick="check_authority(5,0)">購買資產</a></li>
            <li><a href="#" onclick="check_authority(6,0)">處分資產</a></li>
        	</ul>
      	</li>
      	<li><a href="#" onclick="check_authority(7,0)">購買 / 分配原料</a></li>
    </ul>
 </li> 
 <li><a href="#" class="arrow" target="_self">價值作業</a>
    <ul id="subMgm" class="second-menu">
		<li><a href="#" onclick="check_authority(8,0)">流程改良</a></li>
        <li><a href="#" onclick="check_authority(9,0)">產品功能</a></li>
        <li><a href="#" onclick="check_authority(10,0)">生產規劃</a></li>
    </ul>
 </li> 
 <li><a href="#" class="arrow" target="_self">團隊學習</a>
    <ul id="subMgm" class="second-menu">
      	<li><a href="#" onclick="check_authority(11,0)">招 / 解聘員工</a></li>
        <li><a href="#" onclick="check_authority(12,0)">在職訓練</a></li>
        <li><a href="#" onclick="check_authority(13,0)">人員效率評估</a></li> 
    </ul>
 </li>
 <li><a href="#" class="arrow" target="_self">市場聚焦</a>
    <ul id="subMgm" class="second-menu">
      	<li><a href="#"  onclick="check_authority(14,0)">廣告促銷</a></li>
      	<li><a href="#" onclick="check_authority(15,0)">接單</a></li>
      	<!--<li><a href="#" onclick="check_authority(16,0)">通路商</a></li>-->
 	  	<li><a href="#" class="arrow" target="_self">市場狀態</a>
        	<ul class="third-menu">
          	<li><a href="#" onclick="check_authority(17,1)">市場占有率</a></li>
          	<li><a href="#" onclick="check_authority(17,2)">市場需求變化</a></li>
        	</ul>
	 	</li>
    </ul>
 </li>
 <li><a href="#" target="_self">價值主張</a>
    <ul id="subMgm" class="second-menu">
      	<li><a href="#" onclick="check_authority(18,0)">顧客訂單量</a></li>
        <li><a href="#" onclick="check_authority(19,0)">售後顧客滿意度</a></li>
    </ul>
 </li>
 <li><a href="#" class="arrow" target="_self">價值關係</a>
    <ul style="display: none;" id="subMgm" class="second-menu">
    
        <li><a href="#" class="arrow" target="_self">關係管理</a>
      		<ul class="third-menu">
      		<li><a href="#" onclick="check_authority(20,1)">投資人</a>
      		</li>
      		<li><a href="#" onclick="check_authority(20,2)">員工</a>
      		</li>
      		<li><a href="#" onclick="check_authority(20,3)">顧客</a>
      		</li>
     		<li><a href="#" onclick="check_authority(20,4)">供應商</a>
      		</li>
      		</ul>
      <!-- 
       </li>    
      <<li><a href="#" onclick="check_authority(19,5)">通路商</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/donate_share.php';
      							document.getElementById('contentiframe').width='98%';">企業社會責任</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=1';
      							document.getElementById('contentiframe').width='98%';">投資人</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=2';
      							document.getElementById('contentiframe').width='98%';">員工</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=3';
      							document.getElementById('contentiframe').width='98%';">顧客</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=4';
      							document.getElementById('contentiframe').width='98%';">供應商</a>
      </li>
      <li><a href="#" onclick="document.getElementById('contentiframe').src='./ValueRelationship/RelationshipManagement.php?select_tab=5';
      							document.getElementById('contentiframe').width='98%';">通路商</a>
      
    </ul>
  </li>-->
</ul>
</div>

<div id="blank" align="center">
  <p>    
  <p>
  <p>
  <p>
  <p>         
</div>
<!-- BEGIN DOCK 2 ============================================================ 
onclick="document.getElementById('contentiframe').src='./LeftFeatures/Company_info/companyinfo.php'"
-->
	<div id="dockContainer">
		<ul id="jqDock">
            <p><p><p>  
			<li class="content"></li>
			<li class="content"></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/5-content-paste.png" alt="Home" align="absmiddle" title="公&nbsp;司&nbsp;資&nbsp;訊" onclick="information()"/></a></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/5-content-copy.png" alt="Contact" align="absmiddle" title="報&nbsp;表" onclick="pre_report()"/></a></li>
            <li class="content"><a href="#" class="dockItem"><img src="images/4-checklist.png" alt="Contact" align="absmiddle" title="決&nbsp;策&nbsp;總&nbsp;覽"  onclick="decision()"/></a></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/4-collections-view-as-list.png" alt="portfolio" align="absmiddle" title="企&nbsp;業&nbsp;價&nbsp;值&nbsp;分&nbsp;析" onclick="dupont()"/></a></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/4-collections-go-to-today.png" alt="music" align="absmiddle" title="日&nbsp;記&nbsp;帳" onclick="journal()"/></a></li>
			<li class="content"><a href="#" class="dockItem"><img src="images/6-social-cc-bcc.png" alt="video" align="absmiddle" title="競&nbsp;賽&nbsp;排&nbsp;名" onclick="rank()"/></a></li>
			
		</ul>
</div><!-- end div #dockContainer -->
	<!-- END DOCK 2 ============================================================ -->
 

<div id="content">
       <iframe id="contentiframe" width="100%" height="93%" marginwidth="8" marginheight="0" frameborder="0" scrolling="auto" style="
    margin:0;
    padding:0;
    border:0 solid;
    <?php /*?>background-image:url(/ABC_games/testabc/abc_login/images/bg.png);<?php */?>
    "></iframe>
</div>

<!-- round 2 fight!!!!-->
   <body>

    <a id="aaa" name="aaa" onclick="$('#divShow').show();" href="#">重要提醒</a>
<div style="float:right;">
        <div id="divShow" name="divShow" style="width: 600px; height: 350px;border-width:2px;">
 <input type="button" id="btnCloseDiv" name="divCloseDiv" value="關閉" onclick="$('#divShow').hide();" />

        <p></p>

        <table>
  <tr><td align=center><font size='7' color='gold' face='標楷體'>歡迎進入ABC決策模擬系統</font></td></tr>
  <tr><td><font size='4'>競賽注意事項：</font></td></tr>
  <tr>
  <?php
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_login", $connect);  //連接資料表testabc_login
	$result=mysql_query("SELECT DISTINCT(`CompanyID`) FROM account");
	$stu_manager_num=mysql_num_rows($result);
	echo "<td><font size='4'>1. 目前共有".$stu_manager_num."家公司正在參與競賽</font></td>";
  ?></tr>
  <tr><td><font size='4'>2. 只有在每年年初才可進行現金增資，每次增資上限為20,000,000</font></td></tr>
  <tr><td><font size='4'>3. 在進行生產前，須先與原料供應商簽約，確保每個月得到的原料數及品質，也須先購買足夠機具，並進行流程改良，才可生產</font></td></tr>
  <tr><td><font size='4'>4. 每個月只能開發一種新產品</font></td></tr>
  <tr><td><font size='4'>5. 影響接單的四個因素：公司形象、產品品質、價格、顧客滿意度</font></td></tr>

  <tr><td></br></br></br><font size='5' color='gold' face='標楷體'>本月新聞：</font></td></tr>    
  <tr>
  <?php
	$connect = mysql_connect("localhost", "root", "53g4ek7abc") or die(mysql_error());
	mysql_select_db("testabc_main", $connect);  //連接資料表testabc_login
	mysql_query("set names 'utf8'");
	$month=$_SESSION['month'];
    $temp=mysql_query("SELECT `situation` FROM `situation_overview` WHERE `month`='2'");
    $result=  mysql_fetch_array($temp);
    $temp_01=mysql_query("SELECT `name`,`description` FROM `situation` WHERE `index`={$result['situation']};",$connect);
    $result=  mysql_fetch_array($temp_01);
	echo "<td><font size='4'>".$result['name'].",".$result['description']."</font></td>";
  ?>	</tr>
	</table>
</div>
        </div>

</body>