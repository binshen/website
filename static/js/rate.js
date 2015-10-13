
// JavaScript Document
	var lilv_array = new Array;
	
	//2014
	lilv_array[1] = new Array;
	lilv_array[1][1] = new Array;
	lilv_array[1][2] = new Array;
	lilv_array[1][1][1] = 0.0515;//商贷1年 6%
	lilv_array[1][1][3] = 0.0515;//商贷1～3年5.15%
	lilv_array[1][1][5] = 0.0515;//商贷 3～5年 6.4%
	lilv_array[1][1][10] = 0.0515;//商贷 5-30年 5.15%
	lilv_array[1][2][5] = 0.0325;//公积金 1～5年 4%
	lilv_array[1][2][10] = 0.0325;//公积金 5-30年 4.5%
	//2014年1月1日利率下限（7折）
	lilv_array[2] = new Array;
	lilv_array[2][1] = new Array;
	lilv_array[2][2] = new Array;
	lilv_array[2][1][1] = 0.036;//商贷1年 4.2%
	lilv_array[2][1][3] = 0.036;//商贷1～3年 4.305%
	lilv_array[2][1][5] = 0.036;//商贷 3～5年 4.48%
	lilv_array[2][1][10] = 0.036;//商贷 5-30年 4.585%
	lilv_array[2][2][5] = 0.0227;//公积金 1～5年 4%
	lilv_array[2][2][10] = 0.0227;//公积金 5-30年 4.5%
	//2014年1月1日利率下限（85折）
	lilv_array[3] = new Array;
	lilv_array[3][1] = new Array;
	lilv_array[3][2] = new Array;
	lilv_array[3][1][1] = 0.0437;//商贷1年 5.1%
	lilv_array[3][1][3] = 0.0437;//商贷1～3年 5.2275%
	lilv_array[3][1][5] = 0.0437;//商贷 3～5年 5.44%
	lilv_array[3][1][10] = 0.0437;//商贷 5-30年 5.5675%
	lilv_array[3][2][5] = 0.0276;//公积金 1～5年 4%
	lilv_array[3][2][10] = 0.0276;//公积金 5-30年 4.5%
	//2014年1月1日利率上限（1.1倍）
	lilv_array[4] = new Array;
	lilv_array[4][1] = new Array;
	lilv_array[4][2] = new Array;
	lilv_array[4][1][1] = 0.0566;//商贷1年 6.6%
	lilv_array[4][1][3] = 0.0566;//商贷1～3年 6.765%
	lilv_array[4][1][5] = 0.0566;//商贷 3～5年 7.04%
	lilv_array[4][1][10] = 0.0566;//商贷 5-30年 7.205%
	lilv_array[4][2][5] = 0.0357;//公积金 1～5年 4%
	lilv_array[4][2][10] = 0.0357;//公积金 5-30年 4.5%
	//2014年1月1日利率上限（1.05倍）
	lilv_array[5] = new Array;
	lilv_array[5][1] = new Array;
	lilv_array[5][2] = new Array;
	lilv_array[5][1][1] = 0.0541;//商贷1年 6.3%
	lilv_array[5][1][3] = 0.0541;//商贷1～3年 6.4575%
	lilv_array[5][1][5] = 0.0541;//商贷 3～5年 6.72%
	lilv_array[5][1][10] = 0.0541;//商贷 5-30年6.8775%
	lilv_array[5][2][5] = 0.0341;//公积金 1～5年 4%
	lilv_array[5][2][10] = 0.0341;//公积金 5-30年 4.5%
	function exc_zuhe(v) {
		   if (v == 3) {
			   document.getElementById("calc01_zuhe").style.display = '';
			   document.getElementById("calc01_ctype").style.display = 'none';
			   document.getElementById("singlelv_li").style.display = "none";
			   document.getElementById("sdlv_li").style.display = '';
			   document.getElementById("gjlv_li").style.display = '';
			   document.getElementById("calc01").loanradiotype[2].checked = true;
		   
		   } else {
			   document.getElementById("calc01_zuhe").style.display = 'none';
			   document.getElementById("calc01_ctype").style.display = '';
			   document.getElementById("calc1_js_div1").style.display = '';
			   document.getElementById("calc1_js_div2").style.display = 'none';
			   document.getElementById("sdlv_li").style.display = 'none';
			   document.getElementById("gjlv_li").style.display = 'none';
			   document.getElementById("singlelv_li").style.display = '';
			   if (v == 1) {
				   document.getElementById("singlelv").value = document.getElementById("sdlv").value;
				   document.getElementById("calc01").loanradiotype[0].checked = true;
			   } else {
				   document.getElementById("singlelv").value = document.getElementById("gjlv").value;
				   document.getElementById("calc01").loanradiotype[1].checked = true;				   
			   }
		   }
	}
	function exc_js(fmobj, v) {
	   if (fmobj.name == "calc01") {
		   if (v == 1) {
			   document.getElementById("calc1_js_div1").style.display = '';
			   document.getElementById("calc1_js_div2").style.display = 'none';
		   } else {
			   document.getElementById("calc1_js_div1").style.display = 'none';
			   document.getElementById("calc1_js_div2").style.display = '';
		   }
	   }
	}
	
	function loanreset(fmobj) {
		var loanradiotype = document.getElementsByName("loanradiotype");
		var strloanradiotype;
	
		for (var i = 0; i < loanradiotype.length; i++) {
			if (loanradiotype.item(i).checked) {
				strloanradiotype = loanradiotype.item(i).getAttribute("value");
				break;
			} else {
				continue;
			}
		}
		fmobj.reset();
		exc_zuhe(fmobj, strloanradiotype);
	}
	function ext_loantotal(fmobj) {
		var loanradiotype = document.getElementsByName("loanradiotype"); //取房贷计算
		var price = parseInt(document.getElementById("price").value.toString()); //取房贷计算器单价
		var sqm = parseInt(document.getElementById("sqm").value.toString()); //面积
		var anjie = document.getElementById("anjie").value.toString(); //按揭成数
		var daikuan = parseInt(document.getElementById("daikuan").value.toString()); //贷款总数
		var years = document.getElementById("years").value.toString(); //按揭年数
		//var lilv = document.getElementById("lilv").value.toString(); //利率
		var radioben = document.getElementsByName("radioben"); //本金或者本息 1为本息，2为本金
		var strradioben;
		for (var i = 0; i < loanradiotype.length; i++) {
			if (loanradiotype.item(i).checked) {
				strRadiox = loanradiotype.item(i).getAttribute("value");
				break;
			} else {
				continue;
			}
		}
		for (var i = 0; i < radioben.length; i++) {
			if (radioben.item(i).checked) {
				strradioben = radioben.item(i).getAttribute("value");
				break;
			} else {
				continue;
			}
		}
	
		while ((k = fmobj.month_money2.length - 1) >= 0) {
			fmobj.month_money2.options.remove(k);
		}
	
		var month = years * 12;
		fmobj.month1.value = month + "(月)";
		fmobj.month2.value = month + "(月)";
		if (strRadiox == 3) { //判断是房贷计算 组合型
			//--  组合型贷款(组合型贷款的计算，只和商业贷款额、和公积金贷款额有关，和按贷款总额计算无关)
			if (!reg_Num(fmobj.zuhesy.value)) { alert("混合型贷款请填写商贷比例"); fmobj.zuhesy.focus(); return false; }
			if (!reg_Num(fmobj.zuhegjj.value)) { alert("混合型贷款请填写公积金比例"); fmobj.zuhegjj.focus(); return false; }
			if (fmobj.zuhesy.value == null) { fmobj.zuhesy.value = 0; }
			if (fmobj.zuhegjj.value == null) { fmobj.zuhegjj.value = 0; }
			var total_sy = fmobj.zuhesy.value;
			var total_gjj = fmobj.zuhegjj.value;
			fmobj.fangkuan_total1.value = "略"; //房款总额
			fmobj.fangkuan_total2.value = "略"; //房款总额
			fmobj.money_first1.value = 0; //首期付款
			fmobj.money_first2.value = 0; //首期付款
		   //贷款总额
			var total_sy = parseInt(fmobj.zuhesy.value);
			var total_gjj = parseInt(fmobj.zuhegjj.value);
			var daikuan_total = total_sy + total_gjj;
			fmobj.daikuan_total1.value = daikuan_total;
			fmobj.daikuan_total2.value = daikuan_total;
		   
			//月还款
			var lilv_sd = fmobj.sdlv.value / 100; //得到商贷利率
			var lilv_gjj = fmobj.gjlv.value / 100; //得到公积金利率
	
	
			var all_total2 = 0;
			var month_money2 = "";
			for (j = 0; j < month; j++) {
				//调用函数计算: 本金月还款额
				huankuan = getMonthMoney2(lilv_sd, total_sy, month, j) + getMonthMoney2(lilv_gjj, total_gjj, month, j);
				all_total2 += huankuan;
				huankuan = Math.round(huankuan * 100) / 100;
				//fmobj.month_money2.options[j] = new Option( (j+1) +"月," + huankuan + "(元)", huankuan);
				month_money2 += (j + 1) + "月," + huankuan + "(元)\n";
				
			}
			fmobj.month_money2.value = month_money2;
			//还款总额
			fmobj.all_total2.value = Math.round(all_total2 * 100) / 100;
			//支付利息款
			fmobj.accrual2.value = Math.round((all_total2 - daikuan_total) * 100) / 100;
	
			//2.本息还款
			//月均还款
			var month_money1 = getMonthMoney1(lilv_sd, total_sy, month) + getMonthMoney1(lilv_gjj, total_gjj, month); //调用函数计算
			fmobj.month_money1.value = Math.round(month_money1 * 100) / 100 + "(元)";
			//还款总额
			var all_total1 = month_money1 * month;
			fmobj.all_total1.value = Math.round(all_total1 * 100) / 100;
			//支付利息款
			fmobj.accrual1.value = Math.round((all_total1 - daikuan_total) * 100) / 100;
		} else {
			//--  商业贷款、公积金贷款
			var lilv =fmobj.singlelv.value / 100; //得到利率
			if (fmobj.jisuan_radio[0].checked == true) {
				//------------ 根据单价面积计算
				if (!reg_Num(fmobj.price.value)) { alert("请填写单价"); fmobj.price.focus(); return false; }
				if (!reg_Num(fmobj.sqm.value)) { alert("请填写面积"); fmobj.sqm.focus(); return false; }
				//房款总额
				var fangkuan_total = fmobj.price.value * fmobj.sqm.value;
				fmobj.fangkuan_total1.value = fangkuan_total;
				fmobj.fangkuan_total2.value = fangkuan_total;
				//贷款总额
				var daikuan_total = (fmobj.price.value * fmobj.sqm.value) * (fmobj.anjie.value / 10);
				fmobj.daikuan_total1.value = daikuan_total;
				fmobj.daikuan_total2.value = daikuan_total;
				//首期付款
				var money_first = fangkuan_total - daikuan_total;
				fmobj.money_first1.value = money_first
				fmobj.money_first2.value = money_first;
			} else {
				//------------ 根据贷款总额计算
				if (fmobj.daikuan_total000.value.length == 0) { alert("请填写贷款总额"); fmobj.daikuan_total000.focus(); return false; }
	
				//房款总额
				fmobj.fangkuan_total1.value = "略";
				fmobj.fangkuan_total2.value = "略";
				//贷款总额
				var daikuan_total = fmobj.daikuan_total000.value;
				fmobj.daikuan_total1.value = daikuan_total;
				fmobj.daikuan_total2.value = daikuan_total;
				//首期付款
				fmobj.money_first1.value = 0;
				fmobj.money_first2.value = 0;
			}
			//1.本金还款
			//月还款
			var all_total2 = 0;
			var month_money2 = "";
			for (j = 0; j < month; j++) {
				//调用函数计算: 本金月还款额
				huankuan = getMonthMoney2(lilv, daikuan_total, month, j);
				all_total2 += huankuan;
				huankuan = Math.round(huankuan * 100) / 100;
				//fmobj.month_money2.options[j] = new Option( (j+1) +"月," + huankuan + "(元)", huankuan);
				month_money2 += (j + 1) + "月," + huankuan + "(元)\n";
			}
	
			fmobj.month_money2.value = month_money2;
			//还款总额
			fmobj.all_total2.value = Math.round(all_total2 * 100) / 100;
			//支付利息款
			fmobj.accrual2.value = Math.round((all_total2 - daikuan_total) * 100) / 100;
	
	
			//2.本息还款
			//月均还款
			var month_money1 = getMonthMoney1(lilv, daikuan_total, month); //调用函数计算
			fmobj.month_money1.value = Math.round(month_money1 * 100) / 100 + "(元)";
			//还款总额
			var all_total1 = month_money1 * month;
			fmobj.all_total1.value = Math.round(all_total1 * 100) / 100;
			//支付利息款
			fmobj.accrual1.value = Math.round((all_total1 - daikuan_total) * 100) / 100;
	
		}
		if (strradioben == 2) {
			fmobj.fangkuan_total1.value = fmobj.fangkuan_total2.value;
			fmobj.daikuan_total1.value = fmobj.daikuan_total2.value;
			fmobj.all_total1.value = fmobj.all_total2.value;
			fmobj.accrual1.value = fmobj.accrual2.value;
			fmobj.money_first1.value = fmobj.money_first2.value;
			fmobj.month1.value = fmobj.month2.value;
			fmobj.month_money3.value = fmobj.month_money2.value;
		}
	}
	function ext_loanbenjin(fmobj,v) {
	 if (fmobj.name == "calc01") {
		 if (v == 2) {
			 document.getElementById("benxi").style.display = 'none';
			 document.getElementById("benjin").style.display = '';
		 } else {
			 document.getElementById("benxi").style.display = '';
			 document.getElementById("benjin").style.display = 'none';
		 }
	 }
	}
	//验证是否为数字
	function reg_Num(str) {
		if (str.length == 0) { return false; }
		var Letters = "1234567890.";
	
		for (i = 0; i < str.length; i++) {
			var CheckChar = str.charAt(i);
			if (Letters.indexOf(CheckChar) == -1) { return false; }
		}
		return true;
	}
	//得到利率
	function getlilv(lilv_class, type, years) {
		var lilv_class = parseInt(lilv_class);
		if (years <= 5) {
			return lilv_array[lilv_class][type][5];
		} else {
			return lilv_array[lilv_class][type][10];
		}
	}
	//本金还款的月还款额(参数: 年利率 / 贷款总额 / 贷款总月份 / 贷款当前月0～length-1)
	function getMonthMoney2(lilv, total, month, cur_month) {
		var lilv_month = lilv / 12; //月利率
		//return total * lilv_month * Math.pow(1 + lilv_month, month) / ( Math.pow(1 + lilv_month, month) -1 );
		var benjin_money = total / month;
		return (total - benjin_money * cur_month) * lilv_month + benjin_money;
	
	
	}
	//本息还款的月还款额(参数: 年利率/贷款总额/贷款总月份)
	function getMonthMoney1(lilv, total, month) {
		var lilv_month = lilv / 12; //月利率
		return total * lilv_month * Math.pow(1 + lilv_month, month) / (Math.pow(1 + lilv_month, month) - 1);
	}
	function ShowlilvNew(fmobj, month, lt) {
		var loanradiostr = document.getElementsByName("loanradiotype");
		var loanradiotype;
		for (var i = 0; i < loanradiostr.length; i++) {
			if (loanradiostr.item(i).checked) {
				loanradiotype = loanradiostr.item(i).getAttribute("value");
				break;
			} else {
				continue;
			}
		}
		var indexNumSd = getArrayIndexFromYear(month, 1); // 商贷
		var indexNumGj = getArrayIndexFromYear(month, 2); // 公积金
		if (loanradiotype == 1) {
		   fmobj.singlelv.value = myround(lilv_array[lt][1][indexNumSd] * 100, 2);
	   } else if (loanradiotype == 2) {
			fmobj.singlelv.value = myround(lilv_array[lt][2][indexNumGj] * 100, 2);
		} else {
		   fmobj.singlelv.value = myround(lilv_array[lt][2][indexNumGj] * 100, 2);
		}
	   fmobj.sdlv.value = myround(lilv_array[lt][1][indexNumSd] * 100, 2);
	   fmobj.gjlv.value = myround(lilv_array[lt][2][indexNumGj] * 100, 2);
	}
	function myround(v, e) {
		var t = 1;
		e = Math.round(e);
		for (; e > 0; t *= 10, e--);
		for (; e < 0; t /= 10, e++);
		return Math.round(v * t) / t;
	 }
	function getArrayIndexFromYear(year, dkType) {
		var indexNum = 0;
		if (dkType == 1) {
			if (year == 1) {
				indexNum = 1;
			} else if (year > 1 && year <= 3) {
				indexNum = 3;
			} else if (year > 3 && year <= 5) {
				indexNum = 5;
			} else {
				indexNum = 10;
			}
		} else if (dkType == 2) {
			if (year > 5) {
				indexNum = 10;
			} else {
				indexNum = 5;
			}
		}
		return indexNum;
	}
	function displaySubMenu(li) {
		var subMenu = li.getElementsByTagName("ul")[0];
		subMenu.style.display = "block";
	}
	function hideSubMenu(li) {
		var subMenu = li.getElementsByTagName("ul")[0];
		subMenu.style.display = "none";
	}
	function toggleCity() {
		$("#citydiv").toggle();
	}
	ad_lunxun_1 = ad_lunxun_2 = ad_lunxun_3 = ad_lunxun_4 ='';
