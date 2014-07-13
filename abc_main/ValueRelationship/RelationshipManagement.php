<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="../css/smartTab5.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="../css/style.css"/>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/jquery.smartTab.js"></script>
        <script type="text/javascript" src="../star/training_jquery.rating.js"></script>
        <script type="text/javascript" src="../js/jquery.cookie.js"></script>
		<link href="../star/training_rating.css" rel="stylesheet"/>
       	<?php			
			include("../connMysql.php");
			if (!@mysql_select_db("testabc_login")) die("資料庫選擇失敗!");
			$sql_year=("SELECT MAX(Year) From `authority` ");
			$result=mysql_query($sql_year) or die("取年份失敗!");
			$find = mysql_num_rows($result) ;
			//echo $find;
         ?>            
       	<script type="text/javascript">
		
		///////////////////////////////////////////////////////////////////////////////////
			$(document).ready(function(){
				
				//一定要放第一
				$('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'slide'});  // Smart Tab
				
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 linx1 = new Array();
            linx1[1] = "supplier_0";
            linx1[2] = "supplier_1";
            linx1[3] = "supplier_2";
			
		 linx3 = new Array();
		   linx3[1] = "finance";
		   linx3[2] = "equip";
		   linx3[3] = "sale";
		   linx3[4] = "human";
		   linx3[5] = "research";
		var star = new Array();
		 star[1] = 0;
		 star[2] = 0; 
		 star[3] = 0;
		 star[4] = 0;
		 star[5] = 0;
		 star[6] = 0;
		 star[7] = 0;
		 star[8] = 0;
		 star[9] = 0;
		 star[10] = 0;
		 star[11] = 0;
		 star[12] = 0;
		 
		 var loop_star = 0;
			
		gross = new Array();
		have_done_array = new Array();   //percentage
		have_done_array[1] = document.getElementById("sA");
		have_done_array[2] = document.getElementById("sB");
		have_done_array[3] = document.getElementById("sC");
		
		
		 linx2 = new Array();
            linx2[1] = new Array();
            linx2[1][1] = "";
            linx2[1][2] = "";
            linx2[1][3] = "";
            linx2[2] = new Array();
            linx2[2][1] = "";
            linx2[2][2] = "";
            linx2[2][3] = "";
            linx2[3] = new Array();
            linx2[3][1] = "";
            linx2[3][2] = "";
            linx2[3][3] = "";
            linx2[4] = new Array();
            linx2[4][1] = "";
            linx2[4][2] = "";
            linx2[4][3] = "";
			
		 customerArray=new Array();
            var customerArray=["","中華電信","台灣大哥大","惠普","華航","順發科","台塑","和欣","國泰","統一","遠傳",
                "和碩","富邦","台銀","王品","中石化","鴻海","宏達電","台積電","廣達","新光金控",
                "宏碁","緯創","仁寶","華碩","聯發科","SONY","友達","奇美","聯想","浩鑫"];
				
		 $.cookie("supplier_0","");$.cookie("supplier_1","");$.cookie("supplier_2","");  //create cookie
                $.cookie("customer_11","");$.cookie("customer_12","");$.cookie("customer_13","");
                $.cookie("customer_14","");$.cookie("customer_15","");$.cookie("customer_16","");
                $.cookie("customer_21","");$.cookie("customer_22","");$.cookie("customer_23","");
                $.cookie("customer_24","");$.cookie("customer_25","");$.cookie("customer_26","");
                $.cookie("finance","");$.cookie("equip","");$.cookie("sale","");$.cookie("human","");$.cookie("research","");
                $.cookie("investor","");
				//alert($.cookie("supplier_0")); read the cookie
                var relationship="";		
			
		
		
		//sup A	
		 var values = linx1[1];
                //var have_done=0;
               
                $.ajax({
                    url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {type: "get_netin" , supplier:values},
                        success: function(str){
							
                            sub_str=str.split(";");
							document.getElementById("sA_p").textContent = sub_str[0];
                           ////////////////// document.getElementById("past_netin").textContent=sub_str[0];
						  
                            if(sub_str[1] != "" ){
								
                                (have_done_array[1]).textContent = sub_str[1] ;
								temp = parseFloat(sub_str[1]);
								change_sA_c(temp);
                                ////////////////document.getElementById("num").textContent=sub_str[1]+"%";
                                ////////////////document.getElementById("donate01").checked=1;
                               // $(".content01").slideDown("slow");
                               // $("#data1").slideDown("slow");
                               // create_slider();
                               // $("#slider01").slideDown("slow");
                            }
                        }
                });
				
				
				
				//sup B
				 var values = linx1[2];
                //var have_done=0;
              
                $.ajax({
                    url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {type: "get_netin" , supplier:values},
                        success: function(str){
							
                            sub_str=str.split(";");
							document.getElementById("sB_p").textContent = sub_str[0];
                           ////////////////// document.getElementById("past_netin").textContent=sub_str[0];
						 
                            if(sub_str[1] != "" ){
								
                                (have_done_array[2]).textContent = sub_str[1] ;
								temp = parseFloat(sub_str[1]);
								change_sB_c(temp);
                                ////////////////document.getElementById("num").textContent=sub_str[1]+"%";
                                ////////////////document.getElementById("donate01").checked=1;
                               // $(".content01").slideDown("slow");
                               // $("#data1").slideDown("slow");
                               // create_slider();
                               // $("#slider01").slideDown("slow");
                            }
                        }
                });
				
				
				//sup C
				 var values = linx1[3];
                //var have_done=0;
              
                $.ajax({
                    url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {type: "get_netin" , supplier:values},
                        success: function(str){
							
                            sub_str=str.split(";");
							
							document.getElementById("sC_p").textContent = sub_str[0];
                           ////////////////// document.getElementById("past_netin").textContent=sub_str[0];
						  
                            if(sub_str[1] != "" ){
								
                                (have_done_array[3]).textContent = sub_str[1] ;
								temp = parseFloat(sub_str[1]);
								change_sC_c(temp);
                                ////////////////document.getElementById("num").textContent=sub_str[1]+"%";
                                ////////////////document.getElementById("donate01").checked=1;
                               // $(".content01").slideDown("slow");
                               // $("#data1").slideDown("slow");
                               // create_slider();
                               // $("#slider01").slideDown("slow");
                            }
                        }
                });
				
		
		
		
		
		
		
		//have_done_array[1]).textContent = "322" ;
		//document.getElementById("sA").textContent = have_done_array[1];
		//document.getElementById("sB").textContent = have_done_array[2];
		//document.getElementById("sC").textContent = have_done_array[3];
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 var count_01=0,count_02=0,count_03=0;
		
                var each1=new Array(3);
                $.ajax({
                    url:"relationship.php",
                    type:"GET",
                    datatype:"html",
                    data: "type=customer&&type2=b2bG",
                    success: function(str){
                        each1=str.split(";");
                        changeName(each1,1);
						
                        for(i=0;i<3;i++){
                            //                            alert(each[i]);
                            if(each1[i]=="NULL"||each1[i]==undefined)
                                linx2[1][i+1] = "NULL"
                            else{
                                j=i+1;
                                linx2[1][i+1] = "1"+j+","+each1[i];
								show_info(linx2[1][i+1], 1, i+1, "#rate"+j);
                            }
                            //                            alert(linx2[1][i])
                        }
                    }
                });
          
			
			
			
           
                var each2=new Array(3);
                $.ajax({
                    url:"relationship.php",
                    type:"GET",
                    datatype:"html",
                    data: "type=customer&&type2=b2bB",
                    success: function(str){
						
                        if(str!= "NULL"){
                            each2=str.split(";");
                            changeName(each2,2);
							
                            for(i=0;i<3;i++){
                                if(each2[i]=="NULL"||each2[i]==undefined)
                                    linx2[2][i+1] = "NULL"
                                else{
                                    j=i+4;
                                    linx2[2][i+1] = "1"+j+","+each2[i];
									show_info(linx2[2][i+1], 2, i+1, "#rate"+j);
                                }
                            }
                        }
					}
                });

         
			
			
			
           
                var each3=new Array(3);
                $.ajax({
                    url:"relationship.php",
                    type:"GET",
                    datatype:"html",
                    data: "type=customer&&type2=b2cG",
                    success: function(str){
                        each3=str.split(";");
                        changeName(each3,3);
						
                        for(i=0;i<3;i++){
                            if(each3[i]=="NULL"||each3[i]==undefined)
                                linx2[3][i+1] = "NULL"
                            else{
                                j=i+1;
								w=i+7;
                                linx2[3][i+1] = "2"+j+","+each3[i];
								show_info(linx2[3][i+1], 3, i+1,"#rate"+w);
                            }
                        }
                    }
                });

          
			
			
			
          
                var each4=new Array(3);
                $.ajax({
                    url:"relationship.php",
                    type:"GET",
                    datatype:"html",
                    data: "type=customer&&type2=b2cB",
                    success: function(str){
                        if(str!= "NULL"){
                            each4=str.split(";");
                            changeName(each4,4);
							
                            for(i=0;i<3;i++){
                                if(each4[i]=="NULL"||each4[i]==undefined)
                                    linx2[4][i+1] = "NULL"
                                else{
                                    j=i+4;
									w=i+10;
                                    linx2[4][i+1] = "2"+j+","+each4[i];
									show_info(linx2[4][i+1], 4, i+1, "#rate"+w);
                                }
                            }
                        }
                    }
                });

          
		
		
		function changeName(data,num){
			
                for(i=0;i<3;i++){
                    j=i+1;
                    if(data[i]=="NULL"||data[i]==undefined)
                        document.getElementById("nav"+num+"-"+j).textContent="您還沒有服務顧客呦！";
                    else
                        document.getElementById("nav"+num+"-"+j).textContent=customerArray[data[i]];
                }
                //document.getElementById("dummy2").value = num;

            }
			
			
			
			
			function show_info(str,x,y,name)
		  {
			var values=str.split(",");
                $.ajax({
                    url:"relationship.php",
                    type:"GET",
                    datatype:"html",
                    data: "type=customer_data&name="+values[1],
                    success: function(str){
                        all_data=str.split(";");  // str = name,satifaction;have done
                        data=all_data[0].split(","); //data[0] = name
                        //document.getElementById("name").textContent=data[0];
                        document.getElementById("snav"+x+"-"+y).textContent=data[1];
						//all_data[1] = "2";
						loop_star++;
                        if(all_data[1]!=""){
                            //document.getElementById("donate01").checked=1;
                            //btn_display("detail_01_1","detail_01_2","detail_01_3","block");
                            //$(".content01").slideDown("slow");
                            //var id=document.getElementById("detail01");
                            count_01=parseInt(all_data[1]);
							star[loop_star] = count_01;
							$(name).rating('./RelationshipManagement.php',{maxvalue:3, curvalue:count_01});
							
                            //output(count_01,id);
                        }
                    }
                });
				
			}
				
               
                var result="";
				
				/*
                $(".add01").click(function(){
                    if(count_01<3)
                        count_01+=1;
                    else
                        alert("已到達上限值~!!");
                    var id=document.getElementById("detail01");
                    output(count_01,id);
                });
                $(".sub01").click(function(){
                    if(count_01>0)
                        count_01-=1;
                    else
                        alert("沒得扣了啦~!!");
                    var id=document.getElementById("detail01");
                    output(count_01,id);
                });
                $(".detail01").click(function(){
                    var num1=document.getElementById("donate01");
                    if(num1.checked){
                        btn_display("detail_01_1","detail_01_2","detail_01_3","block");
                        $(".content01").slideDown("slow");
                    }
                    else{
                        btn_display("detail_01_1","detail_01_2","detail_01_3","none");
                        $(".content01").slideUp("slow");
                    }
                });
                $(".detail02").click(function(){
                    var num2=document.getElementById("donate02");
                    if(num2.checked){
                        btn_display("detail_02_1","detail_02_2","detail_02_3","block");
                        $(".content02").slideDown("slow");
                    }
                    else{
                        btn_display("detail_02_1","detail_02_2","detail_02_3","none");
                        $(".content02").slideUp("slow");
                    }
                });
                $(".detail03").click(function(){
                    var num3=document.getElementById("donate03");
                    if(num3.checked){
                        btn_display("detail_03_1","detail_03_2","detail_03_3","block")
                        $(".content03").slideDown("slow");
                    }
                    else{
                        btn_display("detail_03_1","detail_03_2","detail_03_3","none")
                        $(".content03").slideUp("slow");
                    }
                });
				*/
				
                $("#submit_star").click(function(){
					loop_star = 1;
					for(i=1; i<=4; i++)
					{
						for(j=1; j<=3; j++)
						{
					        var values = linx2[i][j];
							values=values.split(",");
                            var result="customer_"+values[1];//顧客名稱
                            
                            result+=",d_1="+star[loop_star];
                             loop_star++;
                            $.cookie("customer_"+values[0],result);
					        alert("SUCCESS~!!");
						}
					}
				
                });
          
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	     count_01=0;
		 have_upgrade = 0;
                $.ajax({
                    url:"relationship.php",
                    type:"GET",
                    datatype:"html",
                    data: "type=investor_data",
                    success: function(str){
					//alert(str);
                        all_str=str.split(";");
                        sub_str=all_str[0].split(",");
                        //document.getElementById("detail_01").textContent="目前的RE指數為"+sub_str[0];
                        if(all_str[1]==""){
							
                            document.getElementById("invest_level").textContent = sub_str[1];
                            //var id=document.getElementById("detail01");
                            count_01=parseInt(sub_str[1]);
                            //output(count_01,id);
                        }
                        else{
							have_upgrade = 1;
                            document.getElementById("invest_level").textContent = all_str[1];
                            //document.getElementById("donate01").checked=1;
                            //$(".content01").slideDown("slow");
                            //var id=document.getElementById("detail01");
                            count_01=parseInt(all_str[1]);
                            //output(count_01,id);
                        }
                    }
                });//end ajax
				
				
                $("#submit_i").click(function(){
					if(!have_upgrade){
						if(count_01 >= 5)
						  alert("已達到最大等級");
						else{
						  count_01++;
						  have_upgrade = 1;	
						  document.getElementById("invest_level").textContent = count_01;                                    
                           $.cookie("investor","investor_0,d_1="+count_01);
                    //alert($.cookie("investor"));
					submit_all();
					
						}
					}
					else
					  alert("你已經升級過了");
                });
          
          /*  function output(count,id){
                var str="";
                for(var i=1;i<=count;i++){
                    str+="<input type=\"image\" src=\"./images/money.png\">";
                }
                id.innerHTML=str;
            } */
           
		   
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var dep = linx3[1];
		 $.ajax({
                    url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {type: "get_salary", dep: values},
                        success: function(str){
                            sub_str=str.split(";");
                            //document.getElementById("past_netin").textContent=sub_str[0];
                            if(sub_str[1] != "" ){
                                //have_done=sub_str[1];
                                document.getElementById("fb").textContent=sub_str[1];
								temp = parseFloat(sub_str[1]);
								change_fb_c(temp);
                              
                            }
                        }
                });	
				
		var dep = linx3[2];
		 $.ajax({
                    url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {type: "get_salary", dep: values},
                        success: function(str){
                            sub_str=str.split(";");
                            //document.getElementById("past_netin").textContent=sub_str[0];
                            if(sub_str[1] != "" ){
                                //have_done=sub_str[1];
                                document.getElementById("rb").textContent=sub_str[1];
								temp = parseFloat(sub_str[1]);
								change_rb_c(temp);
                              
                            }
                        }
                });	
				
				
		var dep = linx3[3];
		 $.ajax({
                    url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {type: "get_salary", dep: values},
                        success: function(str){
                            sub_str=str.split(";");
                            //document.getElementById("past_netin").textContent=sub_str[0];
                            if(sub_str[1] != "" ){
                                //have_done=sub_str[1];
                                document.getElementById("sb").textContent=sub_str[1];
								temp = parseFloat(sub_str[1]);
								change_sb_c(temp);
                              
                            }
                        }
                });	
				
				
		var dep = linx3[4];
		 $.ajax({
                    url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {type: "get_salary", dep: values},
                        success: function(str){
                            sub_str=str.split(";");
                            //document.getElementById("past_netin").textContent=sub_str[0];
                            if(sub_str[1] != "" ){
                                //have_done=sub_str[1];
                                document.getElementById("eb").textContent=sub_str[1];
								temp = parseFloat(sub_str[1]);
								change_eb_c(temp);
                              
                            }
                        }
                });	
				
				
		var dep = linx3[5];
		 $.ajax({
                    url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {type: "get_salary", dep: values},
                        success: function(str){
                            sub_str=str.split(";");
                            //document.getElementById("past_netin").textContent=sub_str[0];
                            if(sub_str[1] != "" ){
                                //have_done=sub_str[1];
                                document.getElementById("rdb").textContent=sub_str[1];
								temp = parseFloat(sub_str[1]);
								change_rdb_c(temp);
                              
                            }
                        }
                });	
				
											
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////		
				
				//financial
				$("#fbonus_add").click(function(){
                        var get_fb=parseFloat(document.getElementById("fb").innerHTML);
                        if(get_fb<10){
                           	get_fb+=0.5;
							change_fb_c(get_fb);
						}else
                            alert("已達上限");
                        document.getElementById("fb").innerHTML=get_fb;
                });
              
                $("#fbonus_minus").click(function(){
                        var get_fb=parseFloat(document.getElementById("fb").innerHTML);
                        if(get_fb<=0){
                            alert("已達下限");
                        }else{
                            get_fb-=0.5;
							change_fb_c(get_fb);
                        }
                        document.getElementById("fb").innerHTML=get_fb;
                }); 
				//resourse
				$("#rbonus_add").click(function(){
                        var get_rb=parseFloat(document.getElementById("rb").innerHTML);
                        if(get_rb<10){
                           	get_rb+=0.5;
							change_rb_c(get_rb);
						}else
                            alert("已達上限");
                        document.getElementById("rb").innerHTML=get_rb;
                });
              
                $("#rbonus_minus").click(function(){
                        var get_rb=parseFloat(document.getElementById("rb").innerHTML);
                        if(get_rb<=0){
                            alert("已達下限");
                        }else{
                            get_rb-=0.5;
							change_rb_c(get_rb);
                        }
                        document.getElementById("rb").innerHTML=get_rb;
                });
				//sale
				$("#sbonus_add").click(function(){
                        var get_sb=parseFloat(document.getElementById("sb").innerHTML);
                        if(get_sb<10){
                           	get_sb+=0.5;
							change_sb_c(get_sb);
						}else
                            alert("已達上限");
                        document.getElementById("sb").innerHTML=get_sb;
                });
              
                $("#sbonus_minus").click(function(){
                        var get_sb=parseFloat(document.getElementById("sb").innerHTML);
                        if(get_sb<=0){
                            alert("已達下限");
                        }else{
                            get_sb-=0.5;
							change_sb_c(get_sb);
                        }
                        document.getElementById("sb").innerHTML=get_sb;
                });
				//execute
				$("#ebonus_add").click(function(){
                        var get_eb=parseFloat(document.getElementById("eb").innerHTML);
                        if(get_eb<10){
                           	get_eb+=0.5;
							change_eb_c(get_eb);
						}else
                            alert("已達上限");
                        document.getElementById("eb").innerHTML=get_eb;
                });
              
                $("#ebonus_minus").click(function(){
                        var get_eb=parseFloat(document.getElementById("eb").innerHTML);
                        if(get_eb<=0){
                            alert("已達下限");
                        }else{
                            get_eb-=0.5;
							change_eb_c(get_eb);
                        }
                        document.getElementById("eb").innerHTML=get_eb;
                });
				//rd
				$("#rdbonus_add").click(function(){
                        var get_rdb=parseFloat(document.getElementById("rdb").innerHTML);
                        if(get_rdb<10){
                           	get_rdb+=0.5;
							change_rdb_c(get_rdb);
						}else
                            alert("已達上限");
                        document.getElementById("rdb").innerHTML=get_rdb;
                });
              
                $("#rdbonus_minus").click(function(){
                        var get_rdb=parseFloat(document.getElementById("rdb").innerHTML);
                        if(get_rdb<=0){
                            alert("已達下限");
                        }else{
                            get_rdb-=0.5;
							change_rdb_c(get_rdb);
                        }
                        document.getElementById("rdb").innerHTML=get_rdb;
                });
				//supplierA
				$("#sA_add").click(function(){
					
                        var get_sA=parseFloat(document.getElementById("sA").innerHTML);
                        if(get_sA<10){
                           	get_sA+=0.5;
							change_sA_c(get_sA);
						}else
                            alert("已達上限");
                        document.getElementById("sA").innerHTML=get_sA;
                });
              
                $("#sA_minus").click(function(){
                        var get_sA=parseFloat(document.getElementById("sA").innerHTML);
                        if(get_sA<=0){
                            alert("已達下限");
                        }else{
                            get_sA-=0.5;
							change_sA_c(get_sA);
                        }
                        document.getElementById("sA").innerHTML=get_sA;
                });
				//supplierB
				$("#sB_add").click(function(){
                        var get_sB=parseFloat(document.getElementById("sB").innerHTML);
                        if(get_sB<10){
                           	get_sB+=0.5;
							change_sB_c(get_sB);
						}else
                            alert("已達上限");
                        document.getElementById("sB").innerHTML=get_sB;
                });
              
                $("#sB_minus").click(function(){
                        var get_sB=parseFloat(document.getElementById("sB").innerHTML);
                        if(get_sB<=0){
                            alert("已達下限");
                        }else{
                            get_sB-=0.5;
							change_sB_c(get_sB);
                        }
                        document.getElementById("sB").innerHTML=get_sB;
                });
				//supplierC
				$("#sC_add").click(function(){
                        var get_sC=parseFloat(document.getElementById("sC").innerHTML);
                        if(get_sC<10){
                           	get_sC+=0.5;
							change_sC_c(get_sC);
						}else
                            alert("已達上限");
                        document.getElementById("sC").innerHTML=get_sC;
                });
              
                $("#sC_minus").click(function(){
                        var get_sC=parseFloat(document.getElementById("sC").innerHTML);
                        if(get_sC<=0){
                            alert("已達下限");
                        }else{
                            get_sC-=0.5;
							change_sC_c(get_sC);
                        }
                        document.getElementById("sC").innerHTML=get_sC;
                });
				//distributorA
				$("#dA_add").click(function(){
                        var get_dA=parseFloat(document.getElementById("dA").innerHTML);
                        if(get_dA<10){
                           	get_dA+=0.5;
						}else
                            alert("已達上限");
                        document.getElementById("dA").innerHTML=get_dA;
                });
              
                $("#dA_minus").click(function(){
                        var get_dA=parseFloat(document.getElementById("dA").innerHTML);
                        if(get_dA<=0){
                            alert("已達下限");
                        }else{
                            get_dA-=0.5;
                        }
                        document.getElementById("dA").innerHTML=get_dA;
                });
				//distributorB
				$("#dB_add").click(function(){
                        var get_dB=parseFloat(document.getElementById("dB").innerHTML);
                        if(get_dB<10){
                           	get_dB+=0.5;
						}else
                            alert("已達上限");
                        document.getElementById("dB").innerHTML=get_dB;
                });
              
                $("#dB_minus").click(function(){
                        var get_dB=parseFloat(document.getElementById("dB").innerHTML);
                        if(get_dB<=0){
                            alert("已達下限");
                        }else{
                            get_dB-=0.5;
                        }
                        document.getElementById("dB").innerHTML=get_dB;
                });
				//distributorC
				$("#dC_add").click(function(){
                        var get_dC=parseFloat(document.getElementById("dC").innerHTML);
                        if(get_dC<10){
                           	get_dC+=0.5;
						}else
                            alert("已達上限");
                        document.getElementById("dC").innerHTML=get_dC;
                });
              
                $("#dC_minus").click(function(){
                        var get_dC=parseFloat(document.getElementById("dC").innerHTML);
                        if(get_dC<=0){
                            alert("已達下限");
                        }else{
                            get_dC-=0.5;
                        }
                        document.getElementById("dC").innerHTML=get_dC;
                });
				
				
				
				$("#submit_s").click(function(){
					var num_sA = parseFloat(document.getElementById("sA").innerHTML);
					var num_sB = parseFloat(document.getElementById("sB").innerHTML);
					var num_sC = parseFloat(document.getElementById("sC").innerHTML);
                    var result="";                    
                    //result+=",d_1="+num_sA;
                    //alert(values);
                    $.cookie("supplier_0","supplier_0,d_1=" + num_sA);
					$.cookie("supplier_1","supplier_1,d_1=" + num_sB);
					$.cookie("supplier_2","supplier_2,d_1=" + num_sC);
					
					submit_all();
					
                });
				
				
				$("#submit_e").click(function(){
					var num_fb = parseFloat(document.getElementById("fb").innerHTML);
					var num_rb = parseFloat(document.getElementById("rb").innerHTML);
					var num_sb = parseFloat(document.getElementById("sb").innerHTML);
					var num_eb = parseFloat(document.getElementById("eb").innerHTML);
					var num_rdb = parseFloat(document.getElementById("rdb").innerHTML);
                    
                        //alert(result);
                    $.cookie("finance","empolyee_finance,d_1="+ num_fb);
					$.cookie("equip","empolyee_equip,d_1="+ num_rb);
					$.cookie("sale","empolyee_sale,d_1="+ num_sb);
					$.cookie("human","empolyee_human,d_1="+ num_eb);
					$.cookie("research","empolyee_research,d_1="+ num_rdb);
					
					submit_all();
					//alert("SUCCESS~!!");
                });
				
				 
				 function change_sA_c(p)
				 {
					
					 var get_p=parseFloat(document.getElementById("sA_p").innerHTML);
					 get_p =  parseInt ( get_p * (p/100) );
					 document.getElementById("sA_c").innerHTML=get_p;
				 }
				 
				 function change_sB_c(p)
				 {
					 var get_p=parseFloat(document.getElementById("sB_p").innerHTML);
					 get_p = parseInt( get_p * (p/100) );
					 document.getElementById("sB_c").innerHTML=get_p;
				 }
				 
				 function change_sC_c(p)
				 {
					 var get_p=parseFloat(document.getElementById("sC_p").innerHTML);
					 get_p = parseInt( get_p * (p/100) );
					 document.getElementById("sC_c").innerHTML=get_p;
				 }
				 
				 function change_fb_c(p)
				 {
					 
					 var get_p=25000;
					
					 get_p = parseInt( get_p * (p/100) );
					 
					 document.getElementById("fb_c").innerHTML=get_p;
				 }
				 
				  function change_rb_c(p)
				 {
					  var get_p=32000;
					 get_p = parseInt( get_p * (p/100) );
					 document.getElementById("rb_c").innerHTML=get_p;
				 }
				 
				  function change_sb_c(p)
				 {
					  var get_p=29000;
					 get_p = parseInt( get_p * (p/100) );
					 document.getElementById("sb_c").innerHTML=get_p;
				 }
				 
				  function change_eb_c(p)
				 {
					  var get_p=32000;
					 get_p = parseInt( get_p * (p/100) );
					 document.getElementById("eb_c").innerHTML=get_p;
				 }
				 
				  function change_rdb_c(p)
				 {
					  var get_p=150000;
					 get_p = parseInt( get_p * (p/100) );
					 document.getElementById("rdb_c").innerHTML=get_p;
				 }
				 
				 function submit_all()
				 {
					 relationship="";
                    relationship+=$.cookie("supplier_0")+";"+$.cookie("supplier_1")+";"+$.cookie("supplier_2")+";";
                    relationship+=$.cookie("customer_11")+";"+$.cookie("customer_12")+";"+$.cookie("customer_13")+";"+
                        $.cookie("customer_14")+";"+$.cookie("customer_15")+";"+$.cookie("customer_16")+";"+
                        $.cookie("customer_21")+";"+$.cookie("customer_22")+";"+$.cookie("customer_23")+";"+
                        $.cookie("customer_24")+";"+$.cookie("customer_25")+";"+$.cookie("customer_26")+";";
                    relationship+=$.cookie("finance")+";"+$.cookie("equip")+";"+$.cookie("sale")+";"+$.cookie("human")+";"+$.cookie("research")+";";
                    relationship+=$.cookie("investor");
                    //alert(relationship);
                    $.ajax({
                        url:"relationship.php",
                        type:"GET",
                        datatype:"html",
                        data: {
                            type: "update",
                            result: relationship
                        },
                        success: function(str){
                            //alert("Success!");
						//journal()
                            //alert(relationship+"success!!"+str);
                        }
                    });//*/
                    alert("SUCCESS~!!");
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
			});//end document ready
			
			
		//////////////////////////////////////////////////////////////////////////	
			function rate(field,rate)
				{
					alert(rate);
					
				}
		/////////////////////////////////////////////////////////////////////////
		</script>
        
        
        
    </head>
    <body>   
    	<div id="content">
            <a class="back" href=""></a>
            <p class="head">
                ShelviDream Activity Based Costing Simulated System
            </p>
        <h1>關係管理</h1>
        
        <!-- Tabs 開 始-->
        <div id="tabs" class="stContainer" style="width:97%;height:98%">
  			<ul>
            <?php if($_GET["select_tab"] == 1) { ?>
  				<li>
                <a href="#tabs-1">
                	<img border="0" width="25px" src="../images/r1.png">
                	<h2>投資人</h2>
            	</a>
                </li>
                <?php } ?>
               
               <?php if($_GET["select_tab"] == 2) { ?> 
  				<li>
                <a href="#tabs-2">
                	<img border="0" width="25px" src="../images/r2.png">
               	<h2>員工<br />
               	</h2>
            	</a>
                </li>
                 <?php } ?>
                 
                <?php if($_GET["select_tab"] == 3) { ?>  
  				<li>
                <a href="#tabs-3">
                    <img border="0" width="25px" src="../images/r3.png">
                <h2>顧客<br />
                </h2>
             	</a>
                </li>
                <?php } ?>
                
                <?php if($_GET["select_tab"] == 4) { ?> 
                <li>
                <a href="#tabs-4">
                	<img border="0" width="25px" src="../images/r4.png">
               	<h2>供應商<br />
               	</h2>
            	</a>
                </li>
                 <?php } ?>
                
                <?php if($_GET["select_tab"] == 5) { ?> 
                <li>
                <a href="#tabs-5">
                	<img border="0" width="25px" src="../images/r5.png">
               	<h2>通路商<br />
               	</h2>
            	</a>
                </li>
                <?php } ?>
  			</ul>
            
            <?php if($_GET["select_tab"] == 1) { ?> 
  			<div id="tabs-1">	  	
            <table class="table1">
                <thead>
                    <tr>
                        <th scope="col">等級</th>
                        <th scope="col">費用</th>
                        <th scope="col">Re指數</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">等級一</th>
                        <td>500,000元</td>
                        <td>11.5%</td>
                    </tr>
                    <tr>
                        <th scope="row">等級二</th>
                        <td>1,000,000元</td>
						<td>11%</td>
                    </tr>
                    <tr>
                        <th scope="row">等級三</th>
                        <td>2,000,000元</td>
						<td>10.5%</td>
                    </tr>
                 <tr>
                        <th scope="row">等級四</th>
                        <td>4,000,000元</td>
						<td>10%</td>
                    </tr>
<tr>
                        <th scope="row">等級五</th>
                        <td>8,000,000元</td>
						<td>9.5%</td>
                    </tr>
                </tbody>
                <tfoot>
                	<tr>
                        <th scope="row">目前的投資人等級為</th>
                        <td id="invest_level"></td>
                    </tr> 
                	<tr>
                    	<td colspan="3" align="center"> <input type="image" src="../images/levelup.png" id="submit_i" style="width:100px"></td>
                    <tr>
                </tfoot>
            </table>			
			</div>
            <?php }  ?>
            
            <?php if($_GET["select_tab"] == 2) { ?> 
  			<div id="tabs-2">
            <table class="table1" width="70%">
                <thead>
                	<tr>
                    	<td>員工獎勵</td>
                    </tr>
                    <tr>
                        <th scope="col" width="18%">職稱</th>
                        <th scope="col" width="18%">薪水</th>
                        <th scope="col" width="20%" colspan="3">發放比例</th>
                        <th scope="col" width="18%">發放金額</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">財務人員</th>
                        <td id="fb_p">25,000</td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="fbonus_minus"></td>
                        <td><span id="fb">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="fbonus_add"></td>
                        <td><span id="fb_c">0</span></td>
                    </tr>
                    <tr>
                        <th scope="row">運籌人員</th>
                        <td id="rb_p">32,000</td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="rbonus_minus"></td>
                        <td><span id="rb">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="rbonus_add"></td>
                        <td><span id="rb_c">0</span></td>                        
                    </tr>
                    <tr>
                        <th scope="row">行銷與業務人員</th>
                        <td id="sb_p">29,000</td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="sbonus_minus"></td>
                        <td><span id="sb">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="sbonus_add"></td>
                        <td><span id="sb_c">0</span></td>                        
                    </tr>
                     <tr>
                        <th scope="row">行政人員</th>
                        <td id="eb_p">32,000</td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="ebonus_minus"></td>
                        <td><span id="eb">0</span> %</td>     
                         <td style="width:5%"><input type="image" src="../images/add.png" id="ebonus_add"></td>
                         <td><span id="eb_c">0</span></td>                   
                    </tr>
					 <tr>
                        <th scope="row">研發團隊</th>
                        <td id="rdb_p">150,000</td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="rdbonus_minus"></td>
                        <td><span id="rdb">0</span> %</td>   
                        <td style="width:5%"><input type="image" src="../images/add.png" id="rdbonus_add"></td> 
                        <td><span id="rdb_c">0</span></td>                    
                    </tr>
                </tbody>
                 <tfoot>
                	<tr>
                    	<td colspan="6" align="center"><input type="image" src="../images/submit6.png" id="submit_e" style="width:100px"></td>
                    <tr>
                <tfoot>
            </table>
 
        	</div>
            <?php }  ?>
            
            <?php if($_GET["select_tab"] == 3) { ?>                       
  			<div id="tabs-3">
            	<?php /*?>年分
  				<Select name="year">
    			<option value="">請選擇 </Option>
    			<?php
					$n=1;
					while($n <= $find){
						echo "<Option Value=第 ".$n." 年> 第 ".$n." 年</Option>";
				  		$n++;
					}
				?>
  				</Select>	<?php */?>
            <table style="width:100%">
            	<tfoot>
            	<tr><td align="center">   
            <table class="table1" style="width:49%; float:right;">
                <thead>
                	<tr>
                    	<td colspan="4"><img border="0" width="12%" src="../images/big.png">大量訂單</td>
					</tr>
                    <tr>
                        <th style="width:18%"></th>
                        <th scope="col" style="width:20%"> 滿意度 </th>
                        <th scope="col" style="width:18%"> 名次 </th>
                        <th scope="col" style="width:20%">提升等級</th>
                    </tr>
                </thead>																			
                <tbody>
                    <tr>
                        <th scope="row" id="nav1-1">顧客A</th>
                        <td id="snav1-1">0.07452</td>
                        <td rowspan="3">前三名</td>
                        <td><span class="rating" id="rate1"></span>
			     	    <script type="text/javascript">
							$('#rate1').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusb1"});
                        </script>
				        </td>
                    </tr>
                    <tr>
                        <th scope="row" id="nav1-2">顧客B</th>
                        <td id="snav1-2">0.04222</td>
                        <td><span class="rating" id="rate2"></span>
			     	    <script type="text/javascript">
							$('#rate2').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusb2"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row" id="nav1-3">顧客C</th>
                        <td id="snav1-3">0.25896</td>
                        <td><span class="rating" id="rate3"></span>
			     	    <script type="text/javascript">
							$('#rate3').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusb3"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row" id="nav2-1">顧客D</th>
                        <td id="snav2-1">0.01475</td>
                        <td rowspan="3">後三名</td>
                        <td><span class="rating" id="rate4"></span>
			     	    <script type="text/javascript">
							$('#rate4').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusw1"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row" id="nav2-2">顧客E</th>
                        <td id="snav2-2">0.02368</td>
                        <td><span class="rating" id="rate5"></span>
			     	    <script type="text/javascript">
							$('#rate5').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusw2"});
                        </script></td>
                    </tr>
					 <tr>
                        <th scope="row" id="nav2-3">顧客F</th>
                        <td id="snav2-3">0.05874</td>
                        <td><span class="rating" id="rate6"></span>
			     	    <script type="text/javascript">
							$('#rate6').rating('./RelationshipManagement.php',{maxvalue:3, emp:"B_cusw3"});
                        </script></td>
                    </tr>
                    </tbody>
            </table>
			 <table class="table1" style="width:49%;">
                <thead>
					<tr>
                    	<td colspan="4"><img border="0" width="12%" src="../images/small.png">小量訂單</td>
					</tr>
                    <tr>
                        <th style="width:18%"></th>
                        <th scope="col" style="width:20%"> 滿意度 </th>
                        <th scope="col" style="width:18%"> 名次 </th>
                        <th scope="col" style="width:20%">提升等級</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" id="nav3-1">顧客A</th>
                        <td id="snav3-1">0.02474</td>
                        <td rowspan="3">前三名</td>
                         <td><span class="rating" id="rate7"></span>
			     	    <script type="text/javascript">
							$('#rate7').rating('./RelationshipManagement.php',{maxvalue:3, emp:"S_cusb1"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row" id="nav3-2">顧客B</th>
                        <td id="snav3-2">0.03352</td>
                        <td><span class="rating" id="rate8"></span>
			     	    <script type="text/javascript">
							$('#rate8').rating('./RelationshipManagement.php',{maxvalue:3, emp:"S_cusb2"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row" id="nav3-3">顧客C</th>
                        <td id="snav3-3">0.06662</td>
                        <td><span class="rating" id="rate9"></span>
			     	    <script type="text/javascript">
							$('#rate9').rating('./RelationshipManagement.php',{maxvalue:3, emp:"S_cusb3"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row" id="nav4-1">顧客D</th>
                        <td id="snav4-1">0.03445</td>
                        <td rowspan="3">後三名</td>
                       	<td><span class="rating" id="rate10"></span>
			     	    <script type="text/javascript">
							$('#rate10').rating('./RelationshipManagement.php',{maxvalue:3, emp:"S_cusw1"});
                        </script></td>
                    </tr>
                    <tr>
                        <th scope="row" id="nav4-2">顧客E</th>
                        <td id="snav4-2">0.01152</td>
                        <td><span class="rating" id="rate11"></span>
			     	    <script type="text/javascript">
							$('#rate11').rating('./RelationshipManagement.php',{maxvalue:3, emp:"S_cusw2"});
                        </script></td>
                    </tr>
					 <tr>
                        <th scope="row" id="nav4-3">顧客F</th>
                        <td id="snav4-3">0.02755</td>
                        <td><span class="rating" id="rate12"></span>
			     	    <script type="text/javascript">
							$('#rate12').rating('./RelationshipManagement.php',{maxvalue:3, emp:"S_cusw3"});
                        </script></td>
                    </tr>
                    </tbody>
            	</table>
                </td></tr>
                <tr><td  colspan="8" align="center">
                    <br><input  type="image" src="../images/resume.png" id="resume" onClick="location.href='RelationshipManagement.php#tabs-3'" style="width:100px">
                    &nbsp;<input type="image" src="../images/submit6.png" id="submit_star" style="width:100px"></td></tr> 
            	</td></tr>
            </table>        				          
       		</div>
            <?php }  ?>
            
            <?php if($_GET["select_tab"] == 4) { ?> 
            <div id="tabs-4">
                 <table class="table1" width="60%">
                <thead>
                	<tr>
                    	<td>供應商分紅</td>
                    </tr>
                    <tr>
					    <th width="18%"></th>
                        <th scope="col" width="18%">上期營收</th>
                        <th scope="col" width="20%" colspan="3">發放比例 (%)</th>
                        <th scope="col" width="18%">發放金額</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" >供應商A</th>
                        <td ><span id="sA_p"></span></td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="sA_minus"></td>
                        <td><span id="sA">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="sA_add"></td> 
                        <td><span id="sA_c">0</span></td>
                    </tr>
                    <tr>
                        <th scope="row">供應商B</th>
                        <td><span id="sB_p"></span></td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="sB_minus"></td>
                        <td><span id="sB">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="sB_add"></td>
                        <td><span id="sB_c">0</span></td>
                    </tr>
                    <tr>
                        <th scope="row">供應商C</th>
                        <td><span id="sC_p"></span></td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="sC_minus"></td>
                        <td><span id="sC">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="sC_add"></td>
                        <td><span id="sC_c">0</span></td>
                    </tr>
                </tbody>
                 <tfoot>
                	<tr>
                    	<td colspan="6" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	<input type="image" src="../images/submit6.png" id="submit_s" style="width:100px"></td>
                    <tr>
                <tfoot>
            </table>            				          
       		</div>
            <?php }  ?>
            
            <?php if($_GET["select_tab"] == 5) { ?> 
            <div id="tabs-5">
                <table class="table1" width="60%">
                <thead>
                	<tr>
                    	<td>通路商分紅</td>
                    </tr>
                    <tr>
					    <th width="18%"></th>
                        <th scope="col" width="18%">上期營收</th>
                        <th scope="col" width="20%" colspan="3">發放比例</th>
                        <th scope="col" width="18%">發放金額</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row" >通路商A</th>
                        <td>25,000</td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="dA_minus"></td>
                        <td><span id="dA">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="dA_add"></td>
                        <td><span id="dA_c">0</span></td>
                    </tr>
                    <tr>
                        <th scope="row">通路商B</th>
                        <td>29,000</td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="dB_minus"></td>
                        <td><span id="dB">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="dB_add"></td>
                        <td><span id="dB_c">0</span></td>
                    </tr>
                    <tr>
                        <th scope="row">通路商C</th>
                        <td>30,000</td>
                        <td style="width:5%"><input type="image" src="../images/sub.png" id="dC_minus"></td>
                        <td><span id="dC">0</span> %</td>
                        <td style="width:5%"><input type="image" src="../images/add.png" id="dC_add"></td>
                        <td><span id="dC_c">0</span></td>
                    </tr>
                </tbody>
                 <tfoot>
                	<tr>
                    	<td colspan="6" align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        	<input type="image" src="../images/submit6.png" id="submit_d" style="width:100px"></td>
                    <tr>
                <tfoot>
            </table>
          				          
       		</div>
            <?php }  ?>
            
		</div>    <!-- Tabs 結束 -->
            
            
       
          -
      </div><!-- end content -->
    </body>
</html>