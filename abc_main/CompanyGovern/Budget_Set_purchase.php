<?php session_start(); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/tableyellow.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<?php
	include("../connMysql.php");
	if (!@mysql_select_db("testabc_main")) die("資料庫選擇失敗!");
    mysql_query("set names 'utf8'");
	$cid=$_SESSION['cid'];
	$year=$_SESSION['year'];
	$month=$_SESSION['month'];
	$round=$month+($year-1)*12;
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$budget = mysql_fetch_array($temp);
	$require_p = $budget['produce_A'] + $budget['produce_B'];
	$require_k = $budget['produce_A'] + $budget['produce_B'];
	$require_kb = $budget['produce_A'];
	
	//計算期初存料(p)
	$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result1 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result2 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result3 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `product_a` WHERE `cid`='$cid'");
	$result4 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `product_a` WHERE `cid`='$cid'");
	$result5 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `product_a` WHERE `cid`='$cid'");
	$result6 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`ma_supplier_a`) FROM `product_b` WHERE `cid`='$cid'");
	$result7 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_b`) FROM `product_b` WHERE `cid`='$cid'");
	$result8 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`ma_supplier_c`) FROM `product_b` WHERE `cid`='$cid'");
	$result9 = mysql_fetch_array($temp);
	
	$before_p = $result1[0]+$result2[0]+$result3[0]-$result4[0]-$result5[0]-$result6[0]-$result7[0]-$result8[0]-$result9[0];
	
	//計算期初存料(k)
	$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result1 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result2 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result3 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `product_a` WHERE `cid`='$cid'");
	$result4 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `product_a` WHERE `cid`='$cid'");
	$result5 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `product_a` WHERE `cid`='$cid'");
	$result6 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`mb_supplier_a`) FROM `product_b` WHERE `cid`='$cid'");
	$result7 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_b`) FROM `product_b` WHERE `cid`='$cid'");
	$result8 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mb_supplier_c`) FROM `product_b` WHERE `cid`='$cid'");
	$result9 = mysql_fetch_array($temp);
	
	$before_k = $result1[0]+$result2[0]+$result3[0]-$result4[0]-$result5[0]-$result6[0]-$result7[0]-$result8[0]-$result9[0];
	
	//計算期初存料(kb)
	$temp = mysql_query("SELECT SUM(`mc_supplier_a`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result1 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mc_supplier_b`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result2 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mc_supplier_c`) FROM `purchase_materials` WHERE `cid`='$cid'");
	$result3 = mysql_fetch_array($temp);
	
	$temp = mysql_query("SELECT SUM(`mc_supplier_a`) FROM `product_a` WHERE `cid`='$cid'");
	$result4 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mc_supplier_b`) FROM `product_a` WHERE `cid`='$cid'");
	$result5 = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`mc_supplier_c`) FROM `product_a` WHERE `cid`='$cid'");
	$result6 = mysql_fetch_array($temp);
	
	$before_kb = $result1[0]+$result2[0]+$result3[0]-$result4[0]-$result5[0]-$result6[0];
	//-----------------------------------------------------------------------------------------------------------------
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	
	$after_panel = $result['purchase_p'] + $before_p - $require_p;
	$after_kernel = $result['purchase_k'] + $before_k - $require_k;
	$after_keyboard = $result['purchase_kb'] + $before_kb - $require_kb;
?>
<body>

	<div id="purchase">
        
        <table width="1050" border="1" cellpadding="5" class="ytable" align="center">
          <!--
          <tr>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
          </tr>
          -->
          <tr>
            <th width="150">&nbsp;</th>
            <th width="150">&nbsp;</th>
            <th width="150">螢幕與面板</th>
            <th width="150">&nbsp;</th>
            <th width="150">主機板與核心電路</th>
            <th width="150">&nbsp;</th>
            <th width="150">鍵盤基座</th>
          </tr>
          <tr>
            <td>耗用原料數量</td>
            <td>&nbsp;</td>
            <td id="require_p"><?php echo $require_p; ?></td>
            <td>&nbsp;</td>
            <td id="require_k"><?php echo $require_k; ?></td>
            <td>&nbsp;</td>
            <td id="require_kb"><?php echo $require_kb; ?></td>
          </tr>
          <tr>
            <td>加：期末原料</td>
            <td>&nbsp;</td>
            <td><input id="after_panel" style="text-align:center" value="<?php echo $after_panel; ?>" width="10" onBlur="panel()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>&nbsp;</td>
            <td><input id="after_kernel" style="text-align:center" value="<?php echo $after_kernel; ?>" width="10" onBlur="kernel()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>&nbsp;</td>
            <td><input id="after_keyboard" style="text-align:center" value="<?php echo $after_keyboard; ?>" width="10" onBlur="keyboard()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>減：期初原料</td>
            <td>&nbsp;</td>
            <td id="before_p"><?php echo $before_p; ?></td>
            <td>&nbsp;</td>
            <td id="before_k"><?php echo $before_k; ?></td>
            <td>&nbsp;</td>
            <td id="before_kb"><?php echo $before_kb ?></td>
          </tr>
          <tr>
            <td>預計購料數量</td>
            <td>1100元 / 每單位</td>
            <td id="p_panel">&nbsp;</td>
            <td>1500元 / 每單位</td>
            <td id="p_kernel">&nbsp;</td>
            <td>1000元 / 每單位</td>
            <td id="p_keyboard">&nbsp;</td>
          </tr>
          <tr>
            <td>預計進貨金額</td>
            <td>&nbsp;</td>
            <td id="pp_panel">&nbsp;</td>
            <td>&nbsp;</td>
            <td id="pp_kernel">&nbsp;</td>
            <td>&nbsp;</td>
            <td id="pp_keyboard">&nbsp;</td>
          </tr>
        </table>

    </div>
    
    <div align="center" style="height:150">
    	<input id="sub" type="image" src="../images/submit.png" />
    </div>
    
    <script type="text/javascript">
		
		
		var require_p = document.getElementById("require_p").innerHTML;
		var require_k = document.getElementById("require_k").innerHTML;
		var require_kb = document.getElementById("require_kb").innerHTML;
		var after_panel = document.getElementById("after_panel").value;
		var after_kernel = document.getElementById("after_kernel").value;
		var after_keyboard = document.getElementById("after_keyboard").value;
		var before_panel = document.getElementById("before_p").innerHTML;
		var before_kernel = document.getElementById("before_k").innerHTML;
		var before_keyboard = document.getElementById("before_kb").innerHTML;
		var p_panel = 0 , p_kernel = 0 , p_keyboard = 0;
		var pp_panel = 0 , pp_kernel = 0 , pp_keyboard = 0;
		
        $(document).ready(function() {
			
			if(parseInt(after_panel) + parseInt(require_p) > parseInt(before_panel)){
				document.getElementById("p_panel").innerHTML = p_panel = parseInt(after_panel) - parseInt(before_panel) + parseInt(require_p);
			}
			else{
				document.getElementById("p_panel").innerHTML = p_panel = 0;
			}
			
			if(parseInt(after_kernel) + parseInt(require_k) > parseInt(before_kernel)){
				document.getElementById("p_kernel").innerHTML = p_kernel = parseInt(after_kernel) - parseInt(before_kernel) + parseInt(require_k);
			}
			else{
				document.getElementById("p_kernel").innerHTML = p_kernel = 0;
			}
			
			if(parseInt(after_keyboard) + parseInt(require_kb) > parseInt(before_keyboard)){
				document.getElementById("p_keyboard").innerHTML = p_keyboard = parseInt(after_keyboard) - parseInt(before_keyboard) + parseInt(require_kb);
			}
			else{
				document.getElementById("p_keyboard").innerHTML = p_keyboard = 0;
			}
			
			document.getElementById("pp_panel").innerHTML = addCommas(parseInt(p_panel) * 1100);
			document.getElementById("pp_kernel").innerHTML = addCommas(parseInt(p_kernel) * 1500);
			document.getElementById("pp_keyboard").innerHTML = addCommas(parseInt(p_keyboard) * 1000);
			
			
			$("#sub").click(function(){
				if(<?php echo $month ?> == 1){
					p_panel = document.getElementById("p_panel").innerHTML;
					p_kernel = document.getElementById("p_kernel").innerHTML;
					p_keyboard = document.getElementById("p_keyboard").innerHTML;
					
					after_panel = document.getElementById("after_panel").value;
					after_kernel = document.getElementById("after_kernel").value;
					after_keyboard = document.getElementById("after_keyboard").value;
					
					if(after_panel < 0 || after_kernel < 0 || after_keyboard < 0){
						alert("期末存料不可小於0");
					}
					else{
					
						$.ajax({
							url:"Budget_DB.php",
							type:"GET",
							dataType:"html",
							data:"type=purchase&p_panel="+p_panel+"&p_kernel="+p_kernel+"&p_keyboard="+p_keyboard
							,
							error: function(){
								alert("fail");
							},
							success: function(){
								alert("success");
							}
						});
					}
				}
				else{
					alert("每年一月才能進行編製");
				}
			});
            
        });//end of ready
		
		function panel(){
			
			after_panel = document.getElementById("after_panel").value;
			before_panel = document.getElementById("before_p").innerHTML;
			
			if(parseInt(after_panel) + parseInt(require_p) > parseInt(before_panel)){
				document.getElementById("p_panel").innerHTML = p_panel = parseInt(after_panel) - parseInt(before_panel) + parseInt(require_p);
			}
			else{
				document.getElementById("p_panel").innerHTML = p_panel = 0;
			}
			
			document.getElementById("pp_panel").innerHTML = addCommas(parseInt(p_panel) * 1100);
			
		}
		
		function kernel(){
			
			after_kernel = document.getElementById("after_kernel").value;
			before_kernel = document.getElementById("before_k").innerHTML;
			
			if(parseInt(after_kernel) + parseInt(require_k) > parseInt(before_kernel)){
				document.getElementById("p_kernel").innerHTML = p_kernel = parseInt(after_kernel) - parseInt(before_kernel) + parseInt(require_k);
			}
			else{
				document.getElementById("p_kernel").innerHTML = p_kernel = 0;
			}
			
			document.getElementById("pp_kernel").innerHTML = addCommas(parseInt(p_kernel) * 1500);
			
		}
		
		function keyboard(){
			
			after_keyboard = document.getElementById("after_keyboard").value;
			before_keyboard = document.getElementById("before_kb").innerHTML;
			
			if(parseInt(after_keyboard) + parseInt(require_kb) > parseInt(before_keyboard)){
				document.getElementById("p_keyboard").innerHTML = p_keyboard = parseInt(after_keyboard) - parseInt(before_keyboard) + parseInt(require_kb);
			}
			else{
				document.getElementById("p_keyboard").innerHTML = p_keyboard = 0;
			}
			
			document.getElementById("pp_keyboard").innerHTML = addCommas(parseInt(p_keyboard) * 1000);
			
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
		
    </script>
    
</body>
</html>