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
            var now_cumlia=0,sto_now=0;
            var debit_now=0.0;
            var price01=0,price02=0,price03=0,price04=0,price05=0,price06=0;
            var clickable=0;
			var isvalid=true;
			var check_lia=0;
			var test_limit=0;
			var test_debt=0;
			var short_li;
			var long_li;
			var test;
			
            $(document).ready(function(){
				
               // $('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});
                $.ajax({
                    url:"fundDB.php",
                    type: "GET",
                    async: false,
                    datatype: "html",
                    data: {type:"month"},
                    success: function(str){
                        month = parseInt(str);
                        if(month==1){
                            clickable=1;
                        }
//                    clickable=1;
                    }
                });
                $.ajax({
                    url:"fundDB.php",
                    type: "GET",
                    datatype: "html",
                    async: false,
                    data: {type:"set"},
                    success: function(str){
                        row=str.split("|");
                       // alert(str);
						test_limit=parseInt(row[12]);
						var test_candebt=test_limit*0.8;
                       	now_cumlia=parseInt(row[0]);
                        sto_now=parseInt(row[9]);
                        price06=parseInt(row[10]);
						now_fund=parseInt(row[11]);
						check_lia=parseInt(row[1]);
						document.getElementById("now_fund").innerHTML=addCommas(now_fund);
                        document.getElementById("cum_lia").innerHTML=row[0];
                        document.getElementById("has_stock").innerHTML=addCommas(sto_now);
                        document.getElementById("now_liaper").innerHTML=row[1]+"%";
                        document.getElementById("pre_liaper").innerHTML=row[8];
                        document.getElementById("ref_stockp").innerHTML=parseFloat(row[2]);
						document.getElementById("outside_stock").innerHTML=addCommas(price06);
						
						document.getElementById("buyable_stock").innerHTML=row[12];		
						document.getElementById("candebt").innerHTML=test_candebt;		
						
                        if(row[3]!="")
                            document.getElementById("get_fundraise").innerHTML=parseFloat(row[3]);
                        if(row[4]!="")
                            document.getElementById("give_dividends").innerHTML=parseFloat(row[4]);
                        if(row[5]!="")
                            document.getElementById("get_shortlia").innerHTML=parseFloat(row[5]);
                        if(row[6]!="")
                            document.getElementById("get_longlia").innerHTML=parseFloat(row[6]);
                        if(row[7]!="")
                            document.getElementById("payback_longlia").innerHTML=parseFloat(row[7]);
                    }
                });
				
				//增資判斷部分
                $("#fund_add").click(function(){
                    if(clickable==1){
                        var get_f=parseInt(document.getElementById("get_fundraise").innerHTML.replace(/\,/g,''));
						var now_f=parseInt(document.getElementById("now_fund").innerHTML.replace(/\,/g,''));
						if(get_f<20000000){
                        	get_f+=1000000;
							now_f+=1000000;
						}else
                            alert("已達上限");
                        document.getElementById("get_fundraise").innerHTML=addCommas(get_f);
						document.getElementById("now_fund").innerHTML=addCommas(now_f);
                    }
					else{
						alert("非年初，無法現金增資!!")
					}
                });
				  $("#fund_minus").click(function(){
                    if(clickable==1){
                        var not_f=parseInt(document.getElementById("get_fundraise").innerHTML.replace(/\,/g,''));
						var now_f=parseInt(document.getElementById("now_fund").innerHTML.replace(/\,/g,''));
                        if(not_f<=0){
                            alert("已達下限");
                        }else{
                            not_f-=1000000;
							now_f-=1000000;
                        }
                        text=price04.toString();
                        document.getElementById("get_fundraise").innerHTML=addCommas(not_f);
						document.getElementById("now_fund").innerHTML=addCommas(now_f);
                    }
                });
				//股利部分
                $("#divi_add").click(function(){
                    if(clickable==1){
						var now_f=parseInt(document.getElementById("now_fund").innerHTML.replace(/\,/g,''));
						var now_s=parseInt(document.getElementById("has_stock").innerHTML.replace(/\,/g,''));
                        var get_d=parseFloat(document.getElementById("give_dividends").innerHTML);
                        if(get_d<10){
                            get_d+=0.5;
							now_f-=now_s*0.5;
						}else
                            alert("已達上限");
                        document.getElementById("give_dividends").innerHTML=get_d;
						document.getElementById("now_fund").innerHTML=addCommas(now_f);
					}
					else{
						alert("非年初，無法發放股利!!")
					}
                });
              
                $("#divi_minus").click(function(){
                    if(clickable==1){
						var now_f=parseInt(document.getElementById("now_fund").innerHTML.replace(/\,/g,''));
						var now_s=parseInt(document.getElementById("has_stock").innerHTML.replace(/\,/g,''));
						var not_d=parseFloat(document.getElementById("give_dividends").innerHTML);
                        if(not_d<=0){
                            alert("已達下限");
                        }else{
                            not_d-=0.5;
							now_f+=now_s*0.5;
                        }
                        document.getElementById("give_dividends").innerHTML=not_d;
						document.getElementById("now_fund").innerHTML=addCommas(now_f);
                    }
                });
                $("#submit").click(function(){
					var get_cash1=parseInt(document.getElementById("get_fundraise").innerHTML.replace(/\,/g,''));
					var get_cash2=parseFloat(document.getElementById("give_dividends").innerHTML);
					var shortlia=document.getElementById("get_shortlia").value;
					var longlia=document.getElementById("get_longlia").value;
					var cumlia=parseInt(document.getElementById("cum_lia").innerHTML.replace(/\,/g,''));
					var payback=document.getElementById("payback_longlia").value;
					//var canbuy=parseInt(document.getElementById("buyable_stock").innerHTML.replace(/\,/g,''));
					//var buystock=document.getElementById("buyback_stock").value;
					//alert(test_limit);
					var test =document.getElementById("candebt").value;
					
					test=test_limit*0.8;
					alert(test);
					short_li=parseInt(shortlia);
					long_li=parseInt(longlia);
					//alert(long_li);
					//alert(short_li);
					var fr=new Array(get_cash1,get_cash2,short_li,long_li,payback,test);
					
					
					for(var i=0; i<fr.length; i++){
						if(fr[i]==""){
							
							fr[i]=0;
						}
						
						
						if(test>short_li)
							isvalid=true;
						else 
							isvalid=false;

						if(test>long_li)
							isvalid=true;
						else 
							isvalid=false;										

						if(isvalid==false){
							alert("請確認購買數量在有效範圍內(>0)!");
							break;
						}
			 		 }
						
					 if(isvalid){ 
                   		 $.ajax({
                       		 url:"fundDB.php",
                       		 type: "GET",
                      	 	 datatype: "html",
                        	 data: {type:"update",decision1:fr[2],decision2:fr[3],decision3:fr[4],
											      decision4:fr[0],decision5:fr[1],decision6:fr[5]},
                       		 success: function(str){
								 alert(str);
                           		 alert("Success!");
								 location.href=('./fund_raising.php');
								 //journal();
                       		 }
                   		 });
				    }
                });
  
	}); // end ready func
	function checklonglia(num,longliabi)
	{
		if(num>=0 && num>=longliabi)
			return true;
		else 
			return false;
	}
	function chechshortlia(num,shortliabi)
	{
		if(num>=0 && num>=shortliabi)
			return true;
		else 
			return false;
	}
		
	 function checkpb(num,cumlia){
		if(num>=0 && num<=cumlia)
   			return true;
		else
  			return false;
	}
	 function checkbs(num,canbuy){
		if(num>=0 && num<=canbuy)
   			return true;
		else
  			return false;
	}
	 function check(num){
		if(num>=0)
   			return true;
		else
  			return false;
	}
          
			 //錢，三位一數			
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
				
	function check_2(){
		if(check_lia >= 80){
			alert("負債比過高  無法借款");
			document.getElementById("get_shortlia").value = "";
			document.getElementById("get_longlia").value = "";
		}
		
	}

        </script>
    </head>
   
    <body>
    
        <div id="content" style="height:auto">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
            <h1>資金募集&nbsp;
            <font size="2" color="#ff3030" style="font-family:'Comic Sans MS', cursive;text-shadow:none;">
            * 同一個月內所先作的決策會被後來的決策所取代，換言之，請在submit前，一次填完所有與決策之項目，否則等於用0取代先前之決策*</font></h1>
            
            
        <div id="tabs" class="stContainer">
           
           <table style="width:99%">
           	<tr><td> 
            <p style="width:93%; height:100%;"><p>
          <table class="table1" style="float:right; width:49%;margin-right:3%">
          <thead>
                <tr>
                    <td colspan="2" style="text-align:left">增資</td>  
                    <td width="100" ></td>
                </tr>    
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px; width:30%">現金增資</th>
                    <td style="width:10%"><input type="image" src="../images/sub.png" id="fund_minus"></td>
                    <td style="width:25%"><span id="get_fundraise"></span></td>
                    <td style="width:10%"><input type="image" src="../images/add.png" id="fund_add"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">發放現金股利</th>
                    <td style="width:10%"><input type="image" src="../images/sub.png" id="divi_minus"></td>
                    <td style="width:25%"><span id="give_dividends"></span></td>
                    <td style="width:10%"><input type="image" src="../images/add.png" id="divi_add"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">加本次決策後的資金總額</th>
                    <td colspan="3"><span id="now_fund"></span></td>
                </tr>
              </tbody>
          </table>
          <p>
          <table class="table1" style="width:43%;margin-right:3%">
           <thead>
                <tr>
                    <td style="text-align:left">參考值</td>  
                    <td></td>
                </tr>  
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:44px; width:50%">目前負債比率</th>
                    <td style="text-align:center"><span id="now_liaper"></span></td>
                </tr>
                <tr>
                    <th scope="row" style="height:44px; width:50%">預估負債比率</th>
                    <td style="text-align:center"><span id="pre_liaper"></span></td>
                </tr>
                <tr>
                    <th style="height:44px; width:50%" scope="row">股票參考價格</th>
                    <td style="text-align:center"><spa id="ref_stockp"></span></td>
                </tr>
             </tbody>
          </table>
          <p><p>
          <table class="table1" style="float:right; width:51%; margin-right:2%">
          <thead>
                <tr>
                  <td colspan="2" style="text-align:left">借款</td>  
                    <td colspan="2"></td>
                </tr> 
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="height:45px">本月短期借款</th>
                    <td><input id="get_shortlia" size="8px" onBlur="check_2()" style="text-align:right"></td>
                    <td rowspan="4" style="text-align:left">說明：<br>
                   1. 長短期年利率： 2%,4%<br> 
                   2. 還款期限   <br>
   &nbsp;&nbsp;&nbsp; 短期借款： 6個月內<br>
   &nbsp;&nbsp;&nbsp; 長期借款：18個月內<br>
    			   3. 其他細節請詳閱手冊
    				</td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">本月長期借款</th>
                    <td><input id="get_longlia" size="8px" onBlur="check_2()" style="text-align:right"></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">累積長期借款</th>
                    <td style="text-align:center"><span id="cum_lia">0</span></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">償還長期借款</th>
                    <td><input id="payback_longlia" size="8px" style="text-align:right"></td>
                </tr>
             </tbody>  
              </table>
               
          <p style="height:3px; width:95%;">
          <table width="45%" class="table1" style="margin-right:3%">
           	<thead>
                <tr>
                    <td colspan="2" style="text-align:left">庫藏股</td>  
                    <td></td>
                </tr>   
            </thead>
            <tbody>
             	<tr>
                    <th scope="row" style="height:45px">公司所持股數</th>
                    <td><span id="has_stock"></span></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">在外流通股數</th>
                    <td><span id="outside_stock"></span></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">目前資產總額</th>
                    <td><span id="buyable_stock"></span></td>
                </tr>
                <tr>
                    <th scope="row" style="height:45px">可供借款上限</th>
                    <td><span id="candebt"></span></td>
                </tr>
              </tbody>
              
            </table>
            <p>
            </td>
          <tfoot>
                <tr>
                    <td style="text-align:center"><br><input type="image" src="../images/submit6.png" id="submit" style="width:100px">
                    		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
               </tr>
              </tfoot>  
          </table> 
         </div> <!--end tab -->
        </div><!-- end content -->
    </body>
</html>
