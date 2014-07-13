<?php session_start();?>
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
            var cutA_count=0 ,cutB_count=0 ,cutC_count=0;
			var com1A_count=0,com1B_count=0,com1C_count=0;
            var com2A_count=0,com2B_count=0,com2C_count=0;
			var detA_count=0,detB_count=0;
			
			var cutA_price=0,cutB_price=0,cutC_price=0;
			var com1A_price=0,com1B_price=0,com1C_price=0;
			var com2A_price=0,com2B_price=0,com2C_price=0;
			var detA_price=0,detB_price=0;
			
			var p_cutA=0,p_cutB=0,p_cutC=0;
			var p_com1A=0,p_com1B=0,p_com1C=0;
			var p_com2A=0,p_com2B=0,p_com2C=0;
			var p_detA=0,p_detB=0;
			
            $(document).ready(function(){
				
				update_cut();
				update_combine1();
				update_combine2();
				update_detect();
				
                $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
					
				$("#submit_c").click(function(){
					cutA_count=document.getElementById("get_cutA_pnum").value;
					cutB_count=document.getElementById("get_cutB_pnum").value;
					cutC_count=document.getElementById("get_cutC_pnum").value;
					com1A_count=document.getElementById("get_com1A_pnum").value;
					com1B_count=document.getElementById("get_com1B_pnum").value;
					com1C_count=document.getElementById("get_com1C_pnum").value;
					com2A_count=document.getElementById("get_com2A_pnum").value;
					com2B_count=document.getElementById("get_com2B_pnum").value;
					com2C_count=document.getElementById("get_com2C_pnum").value;
					
					var c=new Array(cutA_count,cutB_count,cutC_count,com1A_count,com1B_count,com1C_count,com2A_count,com2B_count,com2C_count);
					for(var i=0; i<c.length; i++){
						var isvalid=check(c[i]);
						if(isvalid==false){
							alert("請確認購買數量在有效範圍內(>0)!");
								break;
						}
			 		 }
					 if(isvalid){ 
					//將inputs傳至DB檔
                    $.ajax({
                        url:"machineDB.php",
                        type: "GET",
                        datatype: "html",
                        data: {
							   type:"purchase",p_cutA:cutA_count,p_cutB:cutB_count,p_cutC:cutC_count,
						       				   p_com1A:com1A_count,p_com1B:com1B_count,p_com1C:com1C_count,
							   				   p_com2A:com2A_count,p_com2B:com2B_count,p_com2C:com2C_count},
                        success: function(str){
							//alert(str);
                            alert("Purchase Success!");
							location.href=('./purchase_machine.php');
                            //journal();
                        }
					});
					}
                })
				
				$("#submit_d").click(function(){
					detA_count=document.getElementById("get_detA_pnum").value;
					detB_count=document.getElementById("get_detB_pnum").value;
					var d=new Array(detA_count,detB_count);
					for(var i=0; i<d.length; i++){
						var isvalid=check(d[i]);
						if(isvalid==false){
							alert("請確認購買數量在有效範圍內(>0)!");
								break;
						}
			 		 }
					 if(isvalid){ 
					//將inputs傳至DB檔
                    $.ajax({
                        url:"machineDB.php",
                        type: "GET",
                        datatype: "html",
                        data: {type:"purchase",p_detA:detA_count,p_detB:detB_count},
                        success: function(str){
							//alert(str);
                            alert("Purchase Success!");
							location.href=('./purchase_machine.php');
                            //journal();
                        }
					});
					 }
                })

	}); // end ready func
           
		   //取得cut資訊，並顯示
           function update_cut(){
                $.ajax({
                    url:"machineDB.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"purchase_show",func:"cut"},
                    success: function(str){
                        strs=str.split("|");
                        document.getElementById("has_cutA_num").innerHTML=parseInt(strs[0])+parseInt(strs[3]);
                        document.getElementById("has_cutB_num").innerHTML=parseInt(strs[1])+parseInt(strs[4]);
                        document.getElementById("has_cutC_num").innerHTML=parseInt(strs[2])+parseInt(strs[5]);
                        document.getElementById("get_cutA_price").innerHTML=addCommas(parseInt(strs[6]));
                        document.getElementById("get_cutB_price").innerHTML=addCommas(parseInt(strs[7]));
                        document.getElementById("get_cutC_price").innerHTML=addCommas(parseInt(strs[8]));
						
                    }
                });
            }
			 function check(num){
				if(num>=0)
   					return true;
				else
  					return false;
			}
			
		   //取得combine1資訊，並顯示
           function update_combine1(){
                $.ajax({
                    url:"machineDB.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"purchase_show",func:"combine1"},
                    success: function(str){
                        strs=str.split("|");
                        document.getElementById("has_com1A_num").innerHTML=parseInt(strs[0])+parseInt(strs[3]);
                        document.getElementById("has_com1B_num").innerHTML=parseInt(strs[1])+parseInt(strs[4]);
                        document.getElementById("has_com1C_num").innerHTML=parseInt(strs[2])+parseInt(strs[5]);
                        document.getElementById("get_com1A_price").innerHTML=addCommas(parseInt(strs[6]));
                        document.getElementById("get_com1B_price").innerHTML=addCommas(parseInt(strs[7]));
                        document.getElementById("get_com1C_price").innerHTML=addCommas(parseInt(strs[8]));
                        var com1A_price=strs[6];
						var com1B_price=strs[7];
						var com1C_price=strs[8];
						
                    }
                });
            }
			
		   //取得combine2資訊，並顯示
           function update_combine2(){
                $.ajax({
                    url:"machineDB.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"purchase_show",func:"combine2"},
                    success: function(str){
                        strs=str.split("|");
                        document.getElementById("has_com2A_num").innerHTML=parseInt(strs[0])+parseInt(strs[3]);
                        document.getElementById("has_com2B_num").innerHTML=parseInt(strs[1])+parseInt(strs[4]);
                        document.getElementById("has_com2C_num").innerHTML=parseInt(strs[2])+parseInt(strs[5]);
                        document.getElementById("get_com2A_price").innerHTML=addCommas(parseInt(strs[6]));
                        document.getElementById("get_com2B_price").innerHTML=addCommas(parseInt(strs[7]));
                        document.getElementById("get_com2C_price").innerHTML=addCommas(parseInt(strs[8]));
						var com2A_price=strs[6];
						var com2B_price=strs[7];
						var com2C_price=strs[8];	
                    }
                });
            }
			
			//取得detect資訊，並顯示
			function update_detect(){
                $.ajax({
                    url:"machineDB.php",
                    type: "GET",
                    datatype: "html",
                    data: {type:"purchase_show",func:"detect"},
                    success: function(str){
						//alert(str);
                        strs=str.split("|");
                        document.getElementById("has_detA_num").innerHTML=parseInt(strs[0])+parseInt(strs[2]);
                        document.getElementById("has_detB_num").innerHTML=parseInt(strs[1])+parseInt(strs[3]);
                        document.getElementById("get_detA_price").innerHTML=addCommas(parseInt(strs[4]));
                        document.getElementById("get_detB_price").innerHTML=addCommas(parseInt(strs[5]));
						var detA_price=strs[4];
						var detB_price=strs[5];
                    }
                });
			}
			
			//計算此次決策的總費用
            function count(){
				//get price
				
				cutA_price=parseInt(document.getElementById("get_cutA_price").innerHTML.replace(/\,/g,''));
				cutB_price=parseInt(document.getElementById("get_cutB_price").innerHTML.replace(/\,/g,''));
				cutC_price=parseInt(document.getElementById("get_cutC_price").innerHTML.replace(/\,/g,''));
				com1A_price=parseInt(document.getElementById("get_com1A_price").innerHTML.replace(/\,/g,''));
				com1B_price=parseInt(document.getElementById("get_com1B_price").innerHTML.replace(/\,/g,''));
				com1C_price=parseInt(document.getElementById("get_com1C_price").innerHTML.replace(/\,/g,''));
				com2A_price=parseInt(document.getElementById("get_com2A_price").innerHTML.replace(/\,/g,''));
				com2B_price=parseInt(document.getElementById("get_com2B_price").innerHTML.replace(/\,/g,''));
				com2C_price=parseInt(document.getElementById("get_com2C_price").innerHTML.replace(/\,/g,''));
				detA_price=parseInt(document.getElementById("get_detA_price").innerHTML.replace(/\,/g,''));
				detB_price=parseInt(document.getElementById("get_detA_price").innerHTML.replace(/\,/g,''));
				var purchase_cut_total= cutA_price*cutA_count+cutB_price*cutB_count+cutC_price*cutC_count;
				var purchase_com1_total= com1A_price*com1A_count+com1B_price*com1B_count+com1C_price*com1C_count;
				var purchase_com2_total= com2A_price*com2A_count+com2B_price*com2B_count+com2C_price*com2C_count;
				var total_d= detA_price*detA_count+detB_price*detB_count;
				var total_c= purchase_cut_total + purchase_com1_total + purchase_com2_total;
			    document.getElementById("purchase_total_c").innerHTML=addCommas(total_c);
				document.getElementById("purchase_total_d").innerHTML=addCommas(total_d);
						}
			 //錢，三位一數			
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
			//by shiowgwei
			//輸入值(離開textbox or 按Enter)後，金額立即變動
			function total(){
				cutA_count=document.getElementById("get_cutA_pnum").value;
				cutB_count=document.getElementById("get_cutB_pnum").value;
				cutC_count=document.getElementById("get_cutC_pnum").value;
				com1A_count=document.getElementById("get_com1A_pnum").value;
				com1B_count=document.getElementById("get_com1B_pnum").value;
				com1C_count=document.getElementById("get_com1C_pnum").value;
				com2A_count=document.getElementById("get_com2A_pnum").value;
				com2B_count=document.getElementById("get_com2B_pnum").value;
				com2C_count=document.getElementById("get_com2C_pnum").value;
				detA_count=document.getElementById("get_detA_pnum").value;
				detB_count=document.getElementById("get_detB_pnum").value;
				count();
				}

        </script>
    </head>
   
    <body>
    
        <div id="content" style="height:auto">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>購買資產&nbsp;
            	<font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            	* 有打星號的機具請至少買一件 *</font></h1>
            
            
        <div id="tabs" class="stContainer">
            <ul>
                <li>
                    <a href="#tabs-1">
                       
                        <font size="4">切割/組裝</font>
   
                    </a>
                </li>
                <li>
                    <a href="#tabs-2">
                    
                        <font size="4">原料/在製品檢測</font>
                    </a>
                </li>
            </ul>

        <div id="tabs-1" style="height:98%">
            <li style=" position:absolute; float:right; width:36%; height:44%; right:2%; background-image:url(../images/note04.png); background-repeat:no-repeat;">
          <!--  <p style="height:8%"><p>
       <table align="center" border="0" style="width:81%; font-size:20px; font-family:'華康秀風體W3'; font-weight:bold; text-align:left;">
            <tr>
            	<td rowspan="3">&nbsp;&nbsp;</td><td colspan="3">說明：<br><br></td>
            </tr>
            <tr>
            	<td style="vertical-align:top"><font color=#ff3030>1.</font></td><td colspan="2">請依規定購買機具，否則無法順利生產<br></td>
            </tr>
            <tr>    
                <td style="vertical-align:top"><font color=#ff3030>2.</font></td><td colspan="2">同一類型的機具，當月所做的決策會被後來所做的決策取代<br></td>
            </tr>
       </table> -->
            </li>
          <table class="table1" style="width:47%">
            <thead>
                <tr>
                    <td colspan="2" style="text-align:left"><img border="0" width="26%" src="../images/cut.png">切割原料
                    	<font color=#ff3030>*</font></td>  
                    <td></td>
                </tr> 
                <tr>
                    <td style="width:20%"></td>  
                    <th style="width:25%" scope="col">現有數量</th>
                    <th style="width:25%" scope="col">機具單價</th>
                    <th style="width:25%" scope="col">購買數量</th>
                </tr>    
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px">機具A</th>
                    <td style="text-align:center"><span id="has_cutA_num"></span></td>
                    <td style="text-align:center"><span id="get_cutA_price"></span></td>
                    <td><input id="get_cutA_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">機具B</th>
                    <td style="text-align:center"><span id="has_cutB_num"></span></td>
                    <td style="text-align:center"><span id="get_cutB_price"></span></td>
                    <td><input id="get_cutB_pnum" onBlur="total()" size="5px" style="text-align:right"></td>

                   
                </tr>
                <tr>
                    <th scope="row" style="height:45px">機具C</th>
                    <td style="text-align:center"><span id="has_cutC_num"></span></td>
                    <td style="text-align:center"><span id="get_cutC_price"></span></td>
                    <td><input id="get_cutC_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                </tr>
                </tbody>
                </table>
          <p>
          <table class="table1" style="float:right; width:47%;">
          <thead>
                <tr>
                    <td colspan="2" style="text-align:left"><img border="0" width="26%" src="../images/combine2.png">第二層組裝</td>  
                    <td colspan="2" style="font-weight:100;"><br><br><br><font color=#ff3030><b>*</b> 欲生產筆記型電腦者須購買此機具</font></td>
                </tr> 
                <tr>
                    <td style="width:20%"></td>  
                    <th style="width:25%" scope="col">現有數量</th>
                    <th style="width:25%" scope="col">機具單價</th>
                    <th style="width:25%" scope="col">購買數量</th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px">機具A</th>
                    <td style="text-align:center"><span id="has_com2A_num"></span></td>
                    <td style="text-align:center"><span id="get_com2A_price"></span></td>
                    <td><input id="get_com2A_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">機具B</th>
                    <td style="text-align:center"><span id="has_com2B_num"></span></td>
                    <td style="text-align:center"><span id="get_com2B_price"></span></td>
                    <td><input id="get_com2B_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                </tr>
                <tr>
                    <th height="70" style="height:45px" scope="row">機具C</th>
                    <td style="text-align:center"><spa id="has_com2C_num"></span></td>
                    <td style="text-align:center"><span id="get_com2C_price"></span></td>
                    <td><input id="get_com2C_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                </tr>
                </tbody>
              </table>
               
          <p style="height:3px; width:98%;">
            <table width="47%" class="table1">
            <thead>
                <tr>
                  <td colspan="2" style="text-align:left"><img border="0" width="26%" src="../images/combine1.png">第一層組裝
                  	<font color=#ff3030>*</font></td>  
                    <td colspan="2"></td>
                </tr> 
                <tr>
                    <td style="width:20%"></td>  
                    <th style="width:25%" scope="col">現有數量</th>
                    <th style="width:25%" scope="col">機具單價</th>
                    <th style="width:25%" scope="col">購買數量</th>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px">機具A</th>
                    <td style="text-align:center"><span id="has_com1A_num"></span></td>
                    <td style="text-align:center"><span id="get_com1A_price"></span></td>
                    <td><input id="get_com1A_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">機具B</th>
                    <td style="text-align:center"><span id="has_com1B_num"></span></td>
                    <td style="text-align:center"><span id="get_com1B_price"></span></td>
                    <td><input id="get_com1B_pnum" onBlur="total()" size="5px" style="text-align:right"></td>

                   
                </tr>
                <tr>
                    <th height="70" style="height:45px" scope="row">機具C</th>
                    <td style="text-align:center"><span id="has_com1C_num"></span></td>
                    <td style="text-align:center"><span id="get_com1C_price"></span></td>
                    <td><input id="get_com1C_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                </tr>
              </tbody>  
               <p>
            </table>
             <table class="table1" border="0" align="center" width="98%">
             <tfoot>
                <tr>
                	<td width="20%">&nbsp;</td>
                    <th scope="row" width="10%"><br>購買總費用</th>
                    <td width="16%"><br>$<span id ="purchase_total_c">0</span></td>
                    <td width="10%" align="center"><br><input type="image" src="../images/submit6.png" id="submit_c" style="width:100px"></td>
                	<td width="20%">&nbsp;</td>
              </tr>
              </tfoot>
            </table>
            <p>
          </div> <!-- end tab-1 -->
              <div id="tabs-2" style="height:98%">
            <p>
           <table class="table1">
            <thead>
                 <tr>
                    <td colspan="3" style="text-align:left"><img border="0" width="18%" src="../images/detect1.png"> 檢測機具</td>  
                    <td width="50%"></td>
                </tr> 
                <tr>
                    <td style="width:20%"></td>  
                    <th style="width:24%" scope="col">現有數量</th>
                    <th style="width:28%" scope="col">機具單價</th>
                    <th style="width:24%" scope="col">購買數量</th>
                </tr>
            </thead>  
            <tbody>
                <tr>
                    <th scope="row" style="height:45px">合格檢測<font color=#ff3030>*</font></th>
                    <td style="text-align:center"><span id="has_detA_num"></span></td>
                    <td style="text-align:center"><span id="get_detA_price"></span></td>
                    <td><input id="get_detA_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                 </tr>
                <tr>
                    <th scope="row" style="height:45px">精密檢測<font color=#ff3030>*</font></th>
                    <td style="text-align:center"><span id="has_detB_num"></span></td>
                    <td style="text-align:center"><span id="get_detB_price"></span></td>
                    <td><input id="get_detB_pnum" onBlur="total()" size="5px" style="text-align:right"></td>
                </tr>
           </tbody>
                <tfoot>
                <tr>
                    <tr>
                    <td></td>
                    <th scope="row"><br>購買總費用</th>
                    <td><br>$<span id ="purchase_total_d">0</span></td>
                    <td style="text-align:center"><br><input type="image" src="../images/submit6.png" id="submit_d" style="width:100px"></td>
                </tr>
                </tfoot>    
            </table>
         </div> <!-- end tab-2 -->
         </div><!-- end tab -->
        </div><!-- end content -->
    </body>
</html>