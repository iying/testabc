<?php session_start(); ?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>無標題文件</title>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
<link href="../css/tableyellow.css" rel="stylesheet" type="text/css" />
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
	$result = mysql_fetch_array($temp);
?>
<body>
    
    
    <div id="finance">
    	
        <table width="1050" border="0" cellpadding="5" class="ytable" align="center">
          <tr>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">筆記型電腦</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">平板電腦</th>
          </tr>
          <tr>
            <td>預計銷售量</td>
            <td>&nbsp;</td>
            <td>20,000元 / 每單位</td>
            <td><input id="sell_A" style="text-align:center" value="<?php echo $result['sell_A']?>" width="10" onBlur="count_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>&nbsp;</td>
            <td>15,000元 / 每單位</td>
            <td><input id="sell_B" style="text-align:center" value="<?php echo $result['sell_B']?>" width="10" onBlur="count_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>預計收入</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td id="revenue_A">0</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td id="revenue_B">0</td>
          </tr>
          <tr>
            <td>行銷策略</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>網路(小)</td>
            <td>2,000元 / 每單位</td>
            <td><input id="internet_A" style="text-align:center" value="<?php echo $result['internet_A']?>" width="10" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>網路(小)</td>
            <td>2,000元 / 每單位</td>
            <td><input id="internet_B" style="text-align:center" value="<?php echo $result['internet_B']?>" width="10" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>電視(中)</td>
            <td>4,000元 / 每單位</td>
            <td><input id="TV_A" style="text-align:center" value="<?php echo $result['TV_A']?>" width="10" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>電視(中)</td>
            <td>4,000元 / 每單位</td>
            <td><input id="TV_B" style="text-align:center" value="<?php echo $result['TV_B']?>" width="10" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>雜誌(大)</td>
            <td>10,000元 / 每單位</td>
            <td><input id="mag_A" style="text-align:center" value="<?php echo $result['magazine_A']?>" width="10" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>雜誌(大)</td>
            <td>10,000元 / 每單位</td>
            <td><input id="mag_B" style="text-align:center" value="<?php echo $result['magazine_B']?>" width="10" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>產品功能定位</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>半導體晶圓</td>
            <td>100,000元 / 每單位</td>
            <td><input id="func1_A" style="text-align:center" value="<?php echo $result['func1_A']?>" width="10" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>觸控螢幕</td>
            <td>100,000元 / 每單位</td>
            <td><input id="func1_B" style="text-align:center" value="<?php echo $result['func1_B']?>" width="10" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>多核心處理器</td>
            <td>100,000元 / 每單位</td>
            <td><input id="func2_A" style="text-align:center" value="<?php echo $result['func2_A']?>" width="10" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>記憶體</td>
            <td>100,000元 / 每單位</td>
            <td><input id="func2_B" style="text-align:center" value="<?php echo $result['func2_B']?>" width="10" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>顯示器</td>
            <td>100,000元 / 每單位</td>
            <td><input id="func3_A" style="text-align:center" value="<?php echo $result['func3_A']?>" width="10" onBlur="count2_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>多核心處理器</td>
            <td>100,000元 / 每單位</td>
            <td><input id="func3_B" style="text-align:center" value="<?php echo $result['func3_B']?>" width="10" onBlur="count2_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>預計銷管費用</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td id="man_A">0</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td id="man_B">0</td>
          </tr>
        </table>

    </div>
    <div align="center" style="height:150" >
    	<input id="sub" type="image" src="../images/submit.png" />
    </div>
    
    
    <script type="text/javascript">
		var sell_A = 0 , sell_B = 0;
		var revenue_A = 0 , revenue_B = 0;
		var internet_A = 0 , TV_A = 0 , mag_A = 0;
		var func1_A = 0 , func2_A = 0 , func3_A = 0;
		var internet_B = 0 , TV_B = 0 , mag_B = 0;
		var func1_B = 0 , func2_B = 0 , func3_B = 0;
		var money_A = 0 , money_B = 0;
			
        $(document).ready(function() {
			
			sell_A = document.getElementById("sell_A").value;
			revenue_A = sell_A * 20000;
			document.getElementById("revenue_A").innerHTML = addCommas(parseInt(revenue_A));
			
			sell_B = document.getElementById("sell_B").value;
			revenue_B = sell_B * 15000;
			document.getElementById("revenue_B").innerHTML = addCommas(parseInt(revenue_B));
			
			internet_A = document.getElementById("internet_A").value;
			TV_A = document.getElementById("TV_A").value;
			mag_A = document.getElementById("mag_A").value;
			func1_A = document.getElementById("func1_A").value;
			func2_A = document.getElementById("func2_A").value;
			func3_A = document.getElementById("func3_A").value;
			money_A =(internet_A*4000)+(TV_A*6000)+(mag_A*12000)+((parseInt(func1_A)+parseInt(func2_A)+parseInt(func3_A))*100000);
			document.getElementById("man_A").innerHTML = addCommas(parseInt(money_A));
					
			internet_B = document.getElementById("internet_B").value;
			TV_B = document.getElementById("TV_B").value;
			mag_B = document.getElementById("mag_B").value;
			func1_B = document.getElementById("func1_B").value;
			func2_B = document.getElementById("func2_B").value;
			func3_B = document.getElementById("func3_B").value;
			money_B =(internet_B*4000)+(TV_B*6000)+(mag_B*12000)+((parseInt(func1_B)+parseInt(func2_B)+parseInt(func3_B))*100000);
			document.getElementById("man_B").innerHTML = addCommas(parseInt(money_B));
			
			
            $("#sub").click(function(){
				if(<?php echo $month ?> == 1){
					sell_A = document.getElementById("sell_A").value;
					sell_B = document.getElementById("sell_B").value;
					
					internet_A = document.getElementById("internet_A").value;
					TV_A = document.getElementById("TV_A").value;
					mag_A = document.getElementById("mag_A").value;
					func1_A = document.getElementById("func1_A").value;
					func2_A = document.getElementById("func2_A").value;
					func3_A = document.getElementById("func3_A").value;
					
					internet_B = document.getElementById("internet_B").value;
					TV_B = document.getElementById("TV_B").value;
					mag_B = document.getElementById("mag_B").value;
					func1_B = document.getElementById("func1_B").value;
					func2_B = document.getElementById("func2_B").value;
					func3_B = document.getElementById("func3_B").value;
					
					
					
					
					
					$.ajax({
						url:"Budget_DB.php",
						type:"GET",
						dataType:"html",
						data:"type=finance&sell_A="+sell_A+"&sell_B="+sell_B+"&internet_A="+internet_A+"&TV_A="+TV_A+"&mag_A="+mag_A+"&func1_A="+func1_A+"&func2_A="+func2_A+"&func3_A="+func3_A+"&internet_B="+internet_B+"&TV_B="+TV_B+"&mag_B="+mag_B+"&func1_B="+func1_B+"&func2_B="+func2_B+"&func3_B="+func3_B
						,
						error: function(){
							alert("fail");
						},
						success: function(){
							alert("success");
						}
					});
				}
				else{
					alert("每年一月才能進行編製");
				}
			});
        });//end of ready
		
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
		function count_A(){
			sell_A = document.getElementById("sell_A").value;
			revenue_A = sell_A * 20000;
			document.getElementById("revenue_A").innerHTML = addCommas(parseInt(revenue_A));
		}
		
		function count_B(){
			sell_B = document.getElementById("sell_B").value;
			revenue_B = sell_B * 15000;
			document.getElementById("revenue_B").innerHTML = addCommas(parseInt(revenue_B));
		}
		
		function count2_A(){
			
			internet_A = document.getElementById("internet_A").value;
			TV_A = document.getElementById("TV_A").value;
			mag_A = document.getElementById("mag_A").value;
			func1_A = document.getElementById("func1_A").value;
			func2_A = document.getElementById("func2_A").value;
			func3_A = document.getElementById("func3_A").value;
			money_A =(internet_A*4000)+(TV_A*6000)+(mag_A*12000)+((parseInt(func1_A)+parseInt(func2_A)+parseInt(func3_A))*100000);
			document.getElementById("man_A").innerHTML = addCommas(parseInt(money_A));
		}
		
		function count2_B(){
			
			internet_B = document.getElementById("internet_B").value;
			TV_B = document.getElementById("TV_B").value;
			mag_B = document.getElementById("mag_B").value;
			func1_B = document.getElementById("func1_B").value;
			func2_B = document.getElementById("func2_B").value;
			func3_B = document.getElementById("func3_B").value;
			money_B =(internet_B*4000)+(TV_B*6000)+(mag_B*12000)+((parseInt(func1_B)+parseInt(func2_B)+parseInt(func3_B))*100000);
			document.getElementById("man_B").innerHTML = addCommas(parseInt(money_B));
		}
		
    </script>
</body>
</html>