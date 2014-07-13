<?php session_start(); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>無標題文件</title>
<link href="../css/tableyellow1.css" rel="stylesheet" type="text/css" />
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
	
	
	
	$temp = mysql_query("SELECT `sell_A`,`sell_B` FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$sell = mysql_fetch_array($temp);
	$temp = mysql_query("SELECT SUM(`batch`) FROM `product_quality` WHERE `cid`='$cid' AND `product`='A'");
	$batch_A = mysql_fetch_array($temp);
	if($batch_A[0] == ""){
		$batch_A[0] = 0;
	}
	$temp = mysql_query("SELECT SUM(`batch`) FROM `product_quality` WHERE `cid`='$cid' AND `product`='B'");
	$batch_B = mysql_fetch_array($temp);
	if($batch_B[0] == ""){
		$batch_B[0] = 0;
	}
	
	$temp = mysql_query("SELECT * FROM `budget` WHERE `cid`='$cid' AND `year`='$year'");
	$result = mysql_fetch_array($temp);
	
	$pro_A = $result['produce_A'] + $batch_A[0] - $sell['sell_A'];
	$pro_B = $result['produce_B'] + $batch_B[0] - $sell['sell_B'];
	
?>
<body>
	<div id="produce">
       
        <table width="750" border="0" cellpadding="5" class="ytable" align="center">
          <tr>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">筆記型電腦</th>
            <th scope="col" width="150">&nbsp;</th>
            <th scope="col" width="150">平板電腦</th>
          </tr>
          <tr>
            <td>預計銷售量</td>
            <td>&nbsp;</td>
            <td id="sell_A"><?php echo $sell['sell_A']; ?></td>
            <td>&nbsp;</td>
            <td id="sell_B"><?php echo $sell['sell_B']; ?></td>
          </tr>
          <tr>
            <td>加：期末存貨</td>
            <td>&nbsp;</td>
            <td><input id="pro_A" style="text-align:center" value="<?php echo $pro_A; ?>" width="10" onBlur="produce_A()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
            <td>&nbsp;</td>
            <td><input id="pro_B" style="text-align:center" value="<?php echo $pro_B; ?>" width="10" onBlur="produce_B()" onKeyUp="if(isNaN(value))execCommand('undo')" onafterpaste="if(isNaN(value))execCommand('undo')"></td>
          </tr>
          <tr>
            <td>減：期初存貨</td>
            <td>&nbsp;</td>
            <td id="before_A"><?php echo $batch_A[0]; ?></td>
            <td>&nbsp;</td>
            <td id="before_B"><?php echo $batch_B[0]; ?></td>
          </tr>
          <tr>
            <td>預計生產量</td>
            <td>&nbsp;</td>
            <td id="produce_A">&nbsp;</td>
            <td>&nbsp;</td>
            <td id="produce_B">&nbsp;</td>
          </tr>
        </table>

    </div>
    <div align="center">
    	<input id="sub" type="image" src="../images/submit.png" />
    </div>
    <script type="text/javascript">
		var pro_A = document.getElementById("pro_A").value;
		var pro_B = document.getElementById("pro_B").value;
		var before_A = document.getElementById("before_A").innerHTML;
		var before_B = document.getElementById("before_B").innerHTML;
		var sell_A = document.getElementById("sell_A").innerHTML;
		var sell_B = document.getElementById("sell_B").innerHTML;
		var f_pro_A = 0 , f_pro_B = 0;
		var after_A = after_B = 0;
		
        $(document).ready(function() {
			if(parseInt(pro_A) + parseInt(sell_A) > parseInt(before_A)){
				document.getElementById("produce_A").innerHTML = parseInt(pro_A) - parseInt(before_A) + parseInt(sell_A);
			}
			else{
				document.getElementById("produce_A").innerHTML = 0
			}
			if(parseInt(pro_B) + parseInt(sell_B) > parseInt(before_B)){
				document.getElementById("produce_B").innerHTML = parseInt(pro_B) - parseInt(before_B) + parseInt(sell_B);
			}
			else{
				document.getElementById("produce_B").innerHTML = 0
			}
			
            $("#sub").click(function(){
				if(<?php echo $month ?> == 1){
					f_pro_A = document.getElementById("produce_A").innerHTML;
					f_pro_B = document.getElementById("produce_B").innerHTML;
					
					after_A = document.getElementById("pro_A").value;
					after_B = document.getElementById("pro_B").value;
					
					if(after_A < 0 || after_B < 0){
						alert("期末存貨不可小於0");
					}
					else{
						$.ajax({
							url:"Budget_DB.php",
							type:"GET",
							dataType:"html",
							data:"type=produce&f_pro_A="+f_pro_A+"&f_pro_B="+f_pro_B
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
		
		function produce_A(){
			pro_A = document.getElementById("pro_A").value;
			before_A = document.getElementById("before_A").innerHTML;
			
			if(parseInt(pro_A) + parseInt(sell_A) > parseInt(before_A)){
				document.getElementById("produce_A").innerHTML = parseInt(pro_A) - parseInt(before_A) + parseInt(sell_A);
			}
			else{
				document.getElementById("produce_A").innerHTML = 0
			}
		}
		function produce_B(){
			pro_B = document.getElementById("pro_B").value;
			before_B = document.getElementById("before_B").innerHTML;
			if(parseInt(pro_B) + parseInt(sell_B) > parseInt(before_B)){
				document.getElementById("produce_B").innerHTML = parseInt(pro_B) - parseInt(before_B) + parseInt(sell_B);
			}
			else{
				document.getElementById("produce_B").innerHTML = 0
			}
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