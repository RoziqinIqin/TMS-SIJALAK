function form_action (fnm,act) {
	if (act == 'copy') {
		document.getElementById('act').value = 'copy';
	}

	if(act == 'add' || act == 'edit') {
		var err= ""; 
		var x = document.getElementsByTagName('input');
		var y = document.getElementsByTagName('select');
// MANDATORY FIELDS
		for (i = 0; i < x.length; i++) {
			var obt=0; var kolom='';
			if (x[i].className == 'mandatory') {
				if (x[i].value == ""){
					if (fnm=='78000DELIVERY_ORDER_BOX') {
						if (x[i].name == 'fld_baidc_dsc') {var kolom='Pelanggan';}
						if (x[i].name == 'fld_btdt') {var kolom='Tanggal Eksekusi';}
						if (x[i].name == 'fld_btflag_dsc') {var kolom='Tipe Armada';}
						if (x[i].name == 'fld_btp26_dsc') {var kolom='Tipe yang ditagihkan';}
						if (x[i].name == 'fld_btp32_dsc') {var kolom='Deal Tarif';}
						if (x[i].name == 'fld_btp12_dsc') {var kolom='Nomor Mobil';}
						if (x[i].name == 'fld_btp11_dsc') {var kolom='Supir';}
						if (x[i].name == 'fld_btp04_dsc') {var kolom='Nama Subkon';}
						if (x[i].name == 'fld_btp01_dsc') {var kolom='Total Sewa';}
						if (x[i].name == 'fld_btp16_dsc') {var kolom='Uang DP (Subkon)';}
						if (x[i].name == 'fld_btp05') {var kolom='Nomor Mobil Subkon';}
						if (x[i].name == 'fld_btp06') {var kolom='Supir Subkon';}
						if (x[i].name=='78000LANGSIRANfld_btdt1') {obt=1;}
						if (x[i].name=='78000LANGSIRANfld_btp011') {obt=1;}
						if (x[i].name=='78000LANGSIRAN78000LANGSIRANfld_btdt2') {obt=1;}
						if (x[i].name=='78000LANGSIRANfld_btp012'){obt=1;}
					}
					if (obt == 0 && (fnm=='78000DELIVERY_ORDER_BOX' || fnm=='78000VOUCHER')) {
						err="ERROR";
						if (kolom!=''){
							msg= "E R R O R . . . . . \n\nField  " + kolom +"  cannot be blank." + 
								"\n\n'Save' unsuccessfully (Failed)" + "\n\n "; //"\n\n --> " + x[i].name +
						} else {
							msg= "E R R O R . . . . . \n\nMandatory Field(s) cannot be blank." + 
								"\n\n'Save' unsuccessfully (Failed)" + "\n\n "; //"\n\n --> " + x[i].name +
						}
						alert(msg);
			//			alert("Mandatory Field Cannot be Blank");
						x[i].focus();
						exit ;
					}
				} 
			}
		}
                   
		for (u = 0; u < y.length; u++) {
			if (y[u].className == 'mandatoryxx') {
				if (y[u].value == "0"){
				  alert("There are Mandatory Field(s) cannot be Blank\n\n");
				  y[u].focus(); 
				  err="ERROR";
				  exit ;
				}
			}
		}

// NOT MANDATORY FIELDS
		
		if (fnm=='78000DELIVERY_ORDER_BOX' && err=="" ) {
			err="";
			var msg="";

 			var Rute = document.getElementById('fld_btp09_dsc').value;
			var RuteB = document.getElementById('fld_btp18_dsc').value;
			var Pelanggan = document.getElementById('fld_baidc_dsc').value;
			var Ty = document.getElementById('fld_baidot').value;
			if (Rute=="" && RuteB=="") {
				err="ERROR";
				msg="E R R O R . . . . . \n\nRute original and / or Rute Blong of customer " + Pelanggan + " (" +Ty + ")" + 
					" cannot be blank" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
//				alert(msg);
//				Rute.focus();
//				exit ;	
			}
		}
		
		if (fnm=='78000DELIVERY_ORDER_BOX' && err=="") {
			err="";
			var msg="";
			var FlgVou="";
//
// Dibutuhkan Voucher atau tidak.
//  		var ExtVou = "";  // Butuh Voucher
			var ExtVou = "999"; // tidak butuh Voucher
//
//
		// Declare Variable
			if (err=="") {
			var CreDt = document.getElementById('fld_btp33').value; //'14-11-2016 18:19:08';
			var CreDate = new Date(CreDt.substring(6,10),CreDt.substring(3,5),CreDt.substring(0,2),CreDt.substring(11,13),CreDt.substring(14,16),CreDt.substring(17,19),0);
			var MinDate = new Date("December 18, 2016 23:59:59");
			
			var TSew = document.getElementById('fld_btp01').value;
			var SbKo = document.getElementById('fld_btp04_dsc').value;
			var Rute = document.getElementById('fld_btp09_dsc').value;
			var RuteB = document.getElementById('fld_btp18_dsc').value;
			var Pelanggan = document.getElementById('fld_baidc_dsc').value;
			var Ty = document.getElementById('fld_baidot').value;
			var Ty2 = document.getElementById('fld_btidp_dsc').value;
			var m1 = Ty2.indexOf("COD");
			var Ty2d= Ty2.substring(m1,m1+3);
			
			var UBH = Number(document.getElementById('fld_btp27').value);
			var UBHx = document.getElementById('fld_btp27').value;
			var UMD = Number(document.getElementById('fld_btp03').value);
			var BLG = Number(document.getElementById('fld_btuamt').value);
			var KasBon = Number(document.getElementById('fld_btp28').value);
			var DealTarif = Number(document.getElementById('fld_btp32').value);
			var Komisi = Number(document.getElementById('fld_btp36').value);
			var Komisi_pct = Number(document.getElementById('fld_btp37').value);
			var DPMs = Number(document.getElementById('fld_btp31').value);
			var DPSb = Number(document.getElementById('fld_btp16').value);

			var TSewp = document.getElementById('fld_btp01_dsc').value;
			var UBHp = document.getElementById('fld_btp27_dsc').value;
			var UMDp = document.getElementById('fld_btp03_dsc').value;
			var BLGp = document.getElementById('fld_btuamt_dsc').value;
			var KasBonp = document.getElementById('fld_btp28_dsc').value;
			var DealTarifp = document.getElementById('fld_btp32_dsc').value;
			var DPMsp = DPMs.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			var DPSbp = DPSb.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			var Komisip = document.getElementById('fld_btp36_dsc').value;
			var Komisip_pct = document.getElementById('fld_btp37_dsc').value;

			//1611-1774-1392-4611/580000/0/0.55000/0.60000
			var Vou = document.getElementById('fld_btp38_dsc').value;
			var t1 = Vou.indexOf("/");
			var t2 = Vou.indexOf("/",t1+1);
			var t3 = Vou.indexOf("/",t2+1);
			var t4 = Vou.indexOf("/",t3+1);
			var BlgVou=Number(Vou.substring(t1+1,t2)); 
			var KsbVou=Number(Vou.substring(t2+1,t3));
			var PctVou=Number(Vou.substring(t3+1,t4));
			var PccVou=Number(Vou.substring(t4+1,t4+7));

			//Center to Center          /0.45/0.50                    /0.50/0.55
			var Orn = document.getElementById('fld_btp39').value;
			var u1 = Orn.indexOf("/");
			var u2 = Orn.indexOf("/",u1+1);
			//var u3 = Orn.indexOf("/",u2+1);
			//var u4 = Orn.indexOf("/",u3+1);
			var URG=Number(Orn.substring(u1+1,u2));
			var CRG=Number(Orn.substring(u2+1,u2+6));  //u3));
			var UCD=URG;  //Number(Orn.substring(u3+1,u4));
			var CCD=CRG;  //Number(Orn.substring(u4+1,u4+6));
			}
			
			if (Komisi != 0){
				var Kmsp = Komisi / DealTarif;
				document.getElementById('fld_btp37').value = Kmsp;
				document.getElementById('fld_btp37_dsc').value = (Kmsp*100).toFixed(2) + "%";
			} 
			if (Komisi == 0 && Komisi_pct != 0){
				Komisi = Komisi_pct * DealTarif;
				document.getElementById('fld_btp36').value = Komisi;
				document.getElementById('fld_btp36_dsc').value = Komisi.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				document.getElementById('fld_btp37').value = Komisi_pct;
				document.getElementById('fld_btp37_dsc').value = Komisi_pct.toFixed(2) + "%";
			} 
			var MRG = DealTarif - Komisi;
			var MRGp = MRG.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");

			if (SbKo == ""){
				var UJO = Number(UBH + UMD + BLG);
				var UJOp = UJO.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				var Pct=UJO/MRG;
				var UJO2= UJO + KasBon;
				var UJO2p = UJO2.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
				var PctA=UJO2/MRG;
				var PctA2 = PctA*100;
				document.getElementById('fld_btp35').value = PctA.toFixed(4);
				document.getElementById('fld_btp35_dsc').value = PctA2.toFixed(2) + "%";
				var PctDP1 = DPMs/MRG;
				var PctDP1p = PctDP1*100;
				document.getElementById('fld_btamt').value = UJO2;
//				document.getElementById('fld_btamt_dsc').value = CurrencyFormatted(UJO2);
			} 
			else {
				var Pct=(MRG-TSew)/MRG;
				var PctDP1 = DPSb/TSew;
				var PctDP1p = PctDP1*100;
				document.getElementById('fld_btamt').value = 0;
//				document.getElementById('fld_btamt_dsc').value = '0';
			}
			var Pct2 = Pct*100;
			document.getElementById('fld_btp34').value = Pct.toFixed(4);
			document.getElementById('fld_btp34_dsc').value = Pct2.toFixed(2) + "%";

//TRIAL
			if (err=="999" ) {
				err="";
				var msg="";
				err="ERROR";
				msg="E R R O R . . . . . " 
					+"\n\nCreated    = " + CreDate 
					+"\nNow    = " + MinDate 
					+"\nType    = " + Ty2d + " from " +Ty2 + " dari " +m1
					+"\n\nU B H     = " + UBHp 
					+"\n\nKomisi    = " + Komisi 
					+"\n%Komisi    = " + Komisi_pct 
					+"\n\nVou    = " + Vou.substring(0,t1) 
					+"\nBlgVou    = " + BlgVou + " : " + t1
					+"\nKsbVou    = " + KsbVou + " : " + t2
					+"\nPctVou    = " + PctVou + " : " + t3
					+"\nPccVou    = " + PccVou + " : " + t4
					+"\n\nDeal tarif = " + DealTarif.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
					+"\n\nDP        = " + DPMs 
					+"\n\nPct DP    = " + PctDP1 
					+"\n\nOrigin    = " + Orn.substring(0,u1)
					+"\nTest    = " + URG + " : " + u1
					+"\nTest2    = " + CRG + " : " + u2
//					+"\nTest3    = " + UCD + " : " + u3
//					+"\nTest4    = " + CCD + " : " + u4
					+"\n\nPct    = " + Pct2.toFixed(2) + "%" + " : " + Pct
					+"\n\nPct%   = " + PctA2.toFixed(2) + "%"	 + " : " + Pct2
					+"\n\nVoucher Flag  = " + ExtVou
					+"\n\n ";
				msg=msg + "\n\n" +"diubah yak";
			}

		// Armada milik sendiri		
			if (SbKo == ""){
				if (DealTarif < UJO && err==""){
					err="ERROR";
					msg="E R R O R . . . . . \n\nDeal Tarif = " + DealTarifp +"\nUJO          = " + CurrencyFormatted(UJO) +
						"\n\nDealTarif cannot be less than Total UJO / UBH" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
				}
				if (Rute != '' && UBHx<5000 && err==""){
					err="ERROR";
					msg="E R R O R . . . . . \n\n'Uang Bagi Hasil' = " + UBHp +
						"\n\n'Uang Bagi Hasil' cannot less than Rp. 5.000, for customer " + Pelanggan + 
						" (" +Ty +")" + " and rute '" + Rute +"'." +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
				}
				if ((BLG > 200000 && err=="" && CreDate>MinDate) || (BLG > 200000 && err=="" && Pct > URG && CreDate<MinDate)) {
					if (Vou =="" || (Vou !="" && BlgVou!= 0 && BLG>BlgVou) || (Vou !="" && BlgVou== 0 && BLG>200000) ) {
						err="ERROR";
						FlgVou="999";
						if (Vou=="" && BlgVou==0){ var BlgVoup=200000;} else {BlgVoup=BlgVou;}
						if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
						msg=msg+"\n\nNgeBlong '"+ RuteB +"' of customer " + Pelanggan + " (" +Ty +")" +" is Rp. " + BLGp +  
							". \nIt cannot greater than Rp. " +BlgVoup.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ; 
						if (ExtVou=="") { 
							msg=msg+"\n\n'Save' unsuccessfully (Failed)" + 
								"\n\nYou need voucher (approval) with 'Ngeblong' Rp. "+BLGp +" ." + "\n\n ";
						}
					}
				}
				if ((KasBon > 200000 && err=="" && CreDate>MinDate) || (KasBon > 200000 && err=="" && PctA > CRG  && CreDate>MinDate)) {
					if (Vou =="" || (Vou !="" && KsbVou!= 0 && KasBon>KsbVou) || (Vou !="" && KsbVou== 0 && KasBon>200000) ) {
						err="ERROR"; 
						FlgVou="999";
						if (Vou=="" && KsbVou==0){ var KsbVoup=200000;} else {KsbVoup=KsbVou;}
						if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
						msg= msg+"\n\nKasbon of customer " + Pelanggan + " (" +Ty +") " + " is Rp. " + KasBonp +  
							". \nIt cannot greater than Rp. " +KsbVoup.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") ; 
						if (ExtVou=="") { 
							msg=msg+"\n\n'Save' unsuccessfully (Failed)" + 
								"\n\nYou need voucher (approval) with 'Kasbon' Rp. "+KasBonp +" ." + "\n\n ";
						}
					}
				}
				if (UJO == 0 && err=="") {
					err="ERROR";
					msg="E R R O R . . . . . \n\nTotal UBH of this Trucking cannot be Zero" + "\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
				}
				if ((Ty =="JO" || Ty =="Reguler") && err=="" && Pct > URG && CreDate>MinDate) {
					if (Vou =="" || (Vou !="" && PctVou !=0 && Pct>PctVou) || (Vou!="" &&PctVou==0 && Pct>URG) ) {
						err="ERROR";
						FlgVou="999";
						if (Vou=="" || PctVou==0){var PctVoup=URG*100;} else {PctVoup=PctVou*100;}
						if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
						msg= msg+"\n\nUJS              = "+UJOp+"\nDeal Tarif     = " + DealTarifp +
							"\nPercentage = " +UJOp+ " / "+ DealTarifp +" = " + Pct2.toFixed(2)+"%"+
							"\n\nPercentage UJS of customer " + Pelanggan + " (" +Ty + ")" + " is " + Pct2.toFixed(2) + "%."; 
						if (ExtVou=="") { 
							msg=msg+"\nIt cannot greater than " + PctVoup.toFixed(2)+"%" + "\n\n'Save' unsuccessfully (Failed)" + 
								"\n\nYou need voucher (approval) with 'Percentage UJS' "+Pct2.toFixed(2) +"% ." + "\n\n ";
						}
						if (Komisi > 0) {
							if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
							msg=msg+"\n\nUJS                   = "+UJOp+"\nDeal Tarif         = " + DealTarifp +
								"\nMarketing Fee = " + Komisip + 
								"\nOps. Margin     = " + DealTarifp + " - " + Komisip + " = " + MRGp +
								"\nPercentage      = " +UJOp+ " / "+MRGp+" = " + Pct2.toFixed(2)+"%"+
								"\n\nPercentage UJS of customer " + Pelanggan + " (" +Ty + ")" + " is " + Pct2.toFixed(2) + "%."; 
							if (ExtVou=="") { 
								msg=msg+"\nIt cannot greater than " + PctVoup.toFixed(2)+"%" + "\n\n'Save' unsuccessfully (Failed)" + 
									"\n\nYou need voucher (approval) with 'Percentage UJS' "+Pct2.toFixed(2) +"% ." + "\n\n ";
							}
						}
					}
				}
				if ((Ty =="JO" || Ty =="Reguler") && err=="" && PctA > CRG && CreDate>MinDate) {
					if (Vou =="" || (Vou !="" &&PccVou != 0 && PctA>PccVou) || (Vou !="" && PccVou==0 && PctA>CRG) ) {
						err="ERROR";
						FlgVou="999";
						if (Vou==""  || PccVou==0){ var PctVoup=CRG*100;} else {PctVoup=PccVou*100;}
						if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
						msg= msg+"\n\nAllUJS              = "+UJO2p+"\nDeal Tarif     = " + DealTarifp +
							"\nPercentage = " +UJO2p+ " / "+ DealTarifp +" = " + PctA2.toFixed(2)+"%"+
							"\n\nPercentage UJS of customer " + Pelanggan + " (" +Ty + ")" + " is " + PctA2.toFixed(2) + "%." ; 
						if (ExtVou=="") { 
							msg=msg+"\nIt cannot greater than " + PctVoup.toFixed(2)+"%" + "\n\n'Save' unsuccessfully (Failed)" + 
								"\n\nYou need voucher (approval) with 'Percentage COST' "+PctA2.toFixed(2) +"% ."  +"\n\n ";
						}
						if (Komisi > 0) {
							if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
							msg= msg+"\n\nAll UJS              = "+UJO2p+"\nDeal Tarif          = "+ DealTarifp +
								"\nMarketing Fee = " + Komisip + 
								"\nOps. Margin     = " + DealTarifp + " - " + Komisip + " = " + MRGp +
								"\nPercentage      = " +UJO2p+ " / "+MRGp+" = " + PctA2.toFixed(2)+"%"+
								"\n\nPercentage ALL UJS of customer " + Pelanggan + " (" +Ty + ")" + " is " + PctA2.toFixed(2) + "%." ; 
							if (ExtVou=="") { 
								msg=msg+"\nIt cannot greater than " + PctVoup.toFixed(2)+"%" +"\n\n'Save' unsuccessfully (Failed)" + 
									"\n\nYou need voucher (approval) with 'Percentage COST' "+PctA2.toFixed(2) +"% ."  +"\n\n ";
							}
						}
					}
				}
				if (Ty =="COD" && err=="" && Pct > UCD && CreDate>MinDate) {
					if (Vou =="" || (Vou !="" && PctVou !=0 && Pct>PctVou) || (Vou!="" &&PctVou==0 & Pct>UCD) ) {
						err="ERROR";
						FlgVou="999";
						if (Vou==""  || PctVou==0){ var PctVoup=UCD*100;} else {PctVoup=PctVou*100;}
						if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
						msg=msg+"\n\nUJS              = "+UJOp+"\nDeal Tarif     = " + DealTarifp +
							"\nPercentage = " +UJOp+ " / "+ DealTarifp +" = " + Pct2.toFixed(2)+"%"+
							"\n\nPercentage UJS of customer " + Pelanggan + " (" +Ty + ")" + " is " + Pct2.toFixed(2) + "%." ; 
						if (ExtVou=="") { 
							msg=msg+"\nIt cannot greater than " + PctVoup.toFixed(2)+"%" + "\n\n'Save' unsuccessfully (Failed)" + 
								"\n\nYou need voucher (approval) with 'Percentage COST' "+Pct2.toFixed(2) +"% ."  +"\n\n ";
						}
						if (Komisi > 0) {
							if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
							msg=msg+"\n\nUJS                   = "+UJOp+"\nDeal Tarif         = " + DealTarifp +
								"\nMarketing Fee = " + Komisip + 
								"\nOps. Margin     = " + DealTarifp + " - " + Komisip + " = " + MRGp +
								"\nPercentage      = " +UJOp+ " / "+MRGp+" = " + Pct2.toFixed(2)+"%"+
								"\n\nPercentage UJS of customer " + Pelanggan + " (" +Ty + ")" + " is " + Pct2.toFixed(2) + "%." ; 
							if (ExtVou=="") { 
								msg=msg+"\nIt cannot greater than " + PctVoup.toFixed(2)+"%" + "\n\n'Save' unsuccessfully (Failed)" + 
								"\n\nYou need voucher (approval) with 'Percentage COST' "+Pct2.toFixed(2) +"% ."  +"\n\n ";
							}
						}
					}
				}
				if (Ty =="COD" && err=="" && PctA > CCD && CreDate>MinDate) {
					if (Vou =="" || (Vou !="" && PctVou !=0 && PctA>PccVou) || (Vou!="" &&PctVou==0 & PctA>CCD) ) {
						err="ERROR";
						FlgVou="999";
						if (Vou==""  && PccVou==0){ var PctVoup=CCD*100;} else {PctVoup=PccVou*100;}
						if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
						msg=msg+"\n\nAll UJS       = "+UJO2p+"\nDeal Tarif        = " + DealTarifp +
							"\nPercentage   = " + PctA2.toFixed(2)+"%"+
							"\n\nPercentage ALL UJS of customer " + Pelanggan + " (" +Ty + ")" + " is " + PctA2.toFixed(2) + "%." ; 
						if (ExtVou=="") { 
							msg=msg+"\nIt cannot greater than " + PctVoup.toFixed(2)+"%" +"\n\n'Save' unsuccessfully (Failed)" + 
							"\n\nYou need voucher (approval) with 'Percentage COST' "+Pct2.toFixed(2) +"% ."  +"\n\n ";
						}
						if (Komisi > 0) {
							if (ExtVou=="") {msg= "E R R O R . . . . . ";} else {msg= "W A R N I N G . . . . . ";}
							msg=msg+"\n\nAll UJS              = "+UJO2p+"\nDeal Tarif          = "+ DealTarifp +
								"\nMarketing Fee = " + Komisip + 
								"\nOps. Margin     = " + DealTarifp + " - " + Komisip + " = " + MRGp +
								"\nPercentage      = " +UJO2p+ " / "+MRGp+" = " + PctA2.toFixed(2)+"%"+
								"\n\nPercentage ALL UJS of customer " + Pelanggan + " (" +Ty + ")" + " is " + PctA2.toFixed(2) + "%." ; 
							if (ExtVou=="") { 
								msg=msg+"\nIt cannot greater than " + PctVoup.toFixed(2)+"%" +"\n\n'Save' unsuccessfully (Failed)" + 
								"\n\nYou need voucher (approval) with 'Percentage COST' "+Pct2.toFixed(2) +"% ."  +"\n\n ";
							}
						}
					}
				}
				if ((Ty =="COD" && err=="" && DPMs == 0) || (Ty2d =="COD" && err=="" && DPMs == 0)) {
					err="ERROR";
					msg="E R R O R . . . . . \n\nDown Payment = "+DPMsp+"\nDeal Tarif   = "+DealTarifp+"\nPercentage   = "+PctDP1p.toFixed(2)+"%"+
						"\n\nDown Payment (DP) of customer " + Pelanggan + " (" +Ty + ")" + " is zero" +
						"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
					if (Komisi > 0) {
						msg="E R R O R . . . . . \n\nDown Payment = "+DPMsp+"\nDeal Tarif   = " + DealTarifp +
							"\nMarketing Fee = " + Komisip + 
							"\nOps. Margin   = " + DealTarifp + " - " + Komisip + " = " + MRGp +
							"\nPercentage   = "+PctDP1p.toFixed(2)+"%"+
							"\n\nDown Payment (DP) of customer " + Pelanggan + " (" +Ty + ")" + " is zero" +
							"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
					}
				}
				// if (Ty =="COD" && err=="" && PctDP1 < .50 && CreDate>MinDate) {
				// 	err="ERROR";
				// 	msg="E R R O R . . . . . \n\nDown Payment = "+DPMsp+"\nDeal Tarif        = "+DealTarifp+"\nPercentage       = "+PctDP1p.toFixed(2)+"%"+
				// 		"\n\nPercentage Down Payment (DP) of customer " + Pelanggan + " (" +Ty + ")" + " is " + PctDP1p.toFixed(2) + "%." +
				// 		"\nIt cannot less than 50%" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
				// 	if (Komisi > 0) {
				// 		msg="E R R O R . . . . . \n\nDown Payment = "+DPMsp+"\nDeal Tarif        = " + DealTarifp +
				// 		"\nMarketing Fee = " + Komisip + "\nPercentage       = "+PctDP1p.toFixed(2)+"%"+
				// 		"\n\nPercentage Down Payment (DP) of customer " + Pelanggan + " (" +Ty + ")" + " is " + PctDP1p.toFixed(2) + "%." +
				// 		"\nIt cannot less than 50%" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
				// 	}
				// } Edit permintaan mas bandang los Dp < 50% 08-03-2017
			} else {
		// Armada Subcon			
				if (DealTarif < TSew && err==""){
					err="ERROR";
					msg="E R R O R . . . . . when using SUBKON\n\nDeal Tarif = " + DealTarifp +"\nTotal Sewa   = " + TSewp +
						"\n\nDealTarif cannot be less than Total Sewa" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
					if (Komisi > 0) {
						msg="E R R O R . . . . . when using SUBKON\n\nDeal Tarif = " + DealTarifp +"\nTotal Sewa   = " + TSewp +
						"\nMarketing Fee = " + Komisip + 
						"\n\nDealTarif cannot be less than Total Sewa" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
					}
				}
				if (Pct < 0.05 && err=="" && CreDate>MinDate) {
					err="ERROR";
					msg="E R R O R . . . . . when using SUBKON\n\nTotal Sewa = "+TSewp+"\nDeal Tarif   = "+DealTarifp+"\n\nMargin Percentage of customer " + Pelanggan + 
						" (" +Ty + ")" + " is " + Pct2.toFixed(2) + "%. \nYou are using third party Logistic, " + SbKo +"."+
						"\nIt cannot less than 5%" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
					if (Komisi > 0) {
						msg="E R R O R . . . . . when using SUBKON\n\nTotal Sewa = "+TSewp+"\nDeal Tarif   = " + DealTarifp +
						"\nMarketing Fee = " + Komisip + "\n\nMargin Percentage of customer " + Pelanggan + 
						" (" +Ty + ")" + " is " + Pct2.toFixed(2) + "%. \nYou are using third party Logistic, Subkon " + SbKo +"."+
						"\nIt cannot less than 5%" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
					}
				}
				// if (PctDP1 > .50 && err=="" && CreDate>MinDate) {
				// 	err="ERROR";
				// 	msg="E R R O R . . . . . when using SUBKON\n\nDown Payment = "+DPSbp+
				// 		"\nTotal Sewa        = "+TSewp+"\nPercentage       = "+PctDP1p.toFixed(2)+"%"+
				// 		"\n\nPercentage Down Payment (DP) of third party Logistic, Subkon " + SbKo + " is " + 
				// 		PctDP1p.toFixed(2) + "%." +
				// 		"\nIt cannot greater than 50%" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
				// 	if (Komisi > 0) {
				// 		msg="E R R O R . . . . . when using SUBKON\n\nDown Payment = "+DPSbp+
				// 		"\nTotal Sewa        = "+ TSewp +
				// 		"\nMarketing Fee = " + Komisip + "\nPercentage       = "+PctDP1p.toFixed(2)+"%"+
				// 		"\n\nPercentage Down Payment (DP) of third party Logistic, Subkon " + SbKo + " is " + 
				// 		PctDP1p.toFixed(2) + "%." +
				// 		"\nIt cannot greater than 50%" +"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
				// 	}
				// } PERMINTAAN PAK ARIS MERUBAH MARGIN 5 % dan DP
			}			
		} 

// VOUCHER		
		if (fnm=='78000VOUCHER' && err=="" ) {
			err="";
			var msg="";
			var SOMaker = document.getElementById('fld_btiid_dsc').value;
			var Company = document.getElementById('fld_baidp_dsc').value;
			var Pct = document.getElementById('fld_btipct_dsc').value;
			var PctA = Number(document.getElementById('fld_btipct').value);
			var Nblg = document.getElementById('fld_btiblg_dsc').value;
			var NblgA = Number(document.getElementById('fld_btiblg').value);
			var Ksbo = document.getElementById('fld_btiksb_dsc').value;
			var KsboA = Number(document.getElementById('fld_btiksb').value);
			var Ktot= PctA + NblgA + KsboA;
			var Cmt = document.getElementById('fld_btcmt').value;
			if (SOMaker=="" && err=="") {
				err="ERROR";
				msg="E R R O R . . . . . \n\nSO Maker cannot be blank" + 
					"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
			}
			if (Company=="" && err=="") {
				err="ERROR";
				msg="E R R O R . . . . . \n\n'For Customer' cannot be blank" + 
					"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
			}
			if (Ktot== 0 && err=="") {
				err="ERROR";
				msg="E R R O R . . . . . \n\nPercentage cannot be zero or \nNgeblong cannot be zero or \nKasbon cannot be zero" + 
					"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
			}
			if (PctA > .65 && err=="") {
				err="ERROR";
				msg="E R R O R . . . . . \n\nPercentage cannot be greater than 65%" + 
					"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
			}
			if (Cmt=="" && err=="") {
				err="ERROR";
				msg="E R R O R . . . . . \n\nComment cannot be blank" + 
					"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
			}
			if (Cmt.length < 9 && err=="") {
				err="ERROR";
				msg="E R R O R . . . . . \n\nPlease fill in the comment properly" + 
					"\n\n'Save' unsuccessfully (Failed)" + "\n\n ";
			}
			if (err =="ERROR") {
				alert(msg);
				SOMaker.focus();
				exit ;
			}
		}

// P O D		
		if (fnm=='78000RETURN_DO' && err=="" ) {
		}	

// Jika ada Error
		if (err=="ERROR"){
			var jwb=confirm(msg);
			// Jika Cancel
			if (jwb==true){
				// Butuh Voucher
				if (ExtVou==""){
					Rute.focus();
					exit ;
				} else {
				// Tidak Butuh Voucher
					if (fnm=='78000DELIVERY_ORDER_BOX'){
						if (FlgVou==""){
							Rute.focus();
							exit ;
						}
						if (FlgVou=="999"){
							err="";
						}
					} else {
						Rute.focus();
						exit ;
					}
				}
			} else {
				Rute.focus();
				exit ;
			}
		}
		
	}

	if (err == ""){
		document[fnm].submit();
	} 
	
}   

function showSubcon(val) {
  var lst = document.getElementsByTagName("tr");
  var fnm = document.getElementById('fnm').value;
  if (val.checked) {
    document.getElementById('fld_btp12_dsc').readOnly = true;
    document.getElementById('fld_btuamt_dsc').readOnly = true; 
    document.getElementById('fld_btp11_dsc').readOnly = true;
    document.getElementById('fld_btp21_dsc').readOnly = true; 
    document.getElementById('fld_btp27_dsc').readOnly = true; 
    document.getElementById('fld_btp28_dsc').readOnly = true; 
    document.getElementById('fld_btp31_dsc').readOnly = true; 
    document.getElementById('fld_btp26_dsc').readOnly = true; 
 
    document.getElementById('fld_btp04_dsc').readOnly = false;
    document.getElementById('fld_btp07').readOnly = false;
    document.getElementById('fld_btp01_dsc').readOnly = false;
    document.getElementById('fld_btp05').readOnly = false;
    document.getElementById('fld_btp06').readOnly = false;
    document.getElementById('fld_btp16_dsc').readOnly = false;

    document.getElementById('fld_btp11_dsc').className = 'default';
    document.getElementById('fld_btp12_dsc').className = 'default';
    document.getElementById('fld_btp04_dsc').className = 'mandatory';
    document.getElementById('fld_btp01_dsc').className = 'mandatory'
    document.getElementById('fld_btp16_dsc').className = 'mandatory'
    document.getElementById('fld_btp05').className = 'mandatory';
    document.getElementById('fld_btp06').className = 'mandatory';

  } else {
    document.getElementById('fld_btp12_dsc').readOnly = false;
    document.getElementById('fld_btuamt_dsc').readOnly = true; //false; 
    document.getElementById('fld_btp11_dsc').readOnly = false;
    document.getElementById('fld_btp21_dsc').readOnly = true; //false; 
    document.getElementById('fld_btp27_dsc').readOnly = true; //false; 
    document.getElementById('fld_btp28_dsc').readOnly = false; 
    document.getElementById('fld_btp31_dsc').readOnly = false; 
    document.getElementById('fld_btp26_dsc').readOnly = false; 
  
    document.getElementById('fld_btp04_dsc').readOnly = true;
    document.getElementById('fld_btp07').readOnly = true;
    document.getElementById('fld_btp01_dsc').readOnly = true;
    document.getElementById('fld_btp05').readOnly = true;
    document.getElementById('fld_btp06').readOnly = true;
    document.getElementById('fld_btp16_dsc').readOnly = true;

    document.getElementById('fld_btp11_dsc').className = 'mandatory';
    document.getElementById('fld_btp12_dsc').className = 'mandatory';
    document.getElementById('fld_btp04_dsc').className = 'default';
   
  }     
}   

function formatNumberP(myElement) {
	var ffname = myElement.name.substr(0,myElement.name.lastIndexOf("_dsc"));
	var val = myElement.value;
	document.getElementById(ffname).value = val;
}

function formatNumber(myElement) { 
        var myVal = "";
        var myDec = ""; 
  var ffname = myElement.name.substr(0,myElement.name.lastIndexOf("_dsc"));
  
        var parts = myElement.value.toString().split(".");
       
        parts[0] = parts[0].replace(/[^0-9]/g,""); 
      
        if ( parts[1] ) {
			myDec = "."+parts[1] 
		}
        
        while ( parts[0].length > 3 ) {
            myVal = ","+parts[0].substr(parts[0].length-3, parts[0].length )+myVal;
            parts[0] = parts[0].substr(0, parts[0].length-3)
        }
        myElement.value = parts[0]+myVal+myDec;
  
        var val = myElement.value;
  var ori = val.replace(/,/g, "");
  document.getElementById(ffname).value = ori;
  
    }

function fup_action (btid,tynextid,tynextform,nextformid,fnm,act) {
  document.getElementById('act').value = 'fup';
  document.getElementById('btid').value = btid;
  document.getElementById('tynextid').value = tynextid;
  document.getElementById('tynextform').value = tynextform;
  document.getElementById('nextformid').value = nextformid;  
  document[fnm].submit();
}

function cekMandatory() {
  var erorr = "";
  var x = document.getElementsByTagName('input');
  var y = document.getElementsByTagName('select');
  for (i = 0; i < x.length; i++) {
    if (x[i].className == 'mandatory') {
      if (x[i].value == ""){
        alert("Mandatory Field Cannot be Blank");
        x[i].focus();
        err="error";
        exit ;
      }
    }
  }

  for (u = 0; u < y.length; u++) {
    if (y[u].className == 'mandatory') {
      if (y[u].value == "0"){
        alert("Mandatory Field Cannot be Blank");
        y[u].focus();
        err="error";
        exit ;
      }
    }
  }

  var answer = confirm('Are you sure want to set Approve this record ?'.VKOnly);
  if (answer) {
    var w = window.open(burl + '/index.php/page/setApproval/'+btid,'CategorySearch','width=1,height=1,left=1,top=1,scrollbars=1,location=no');
    w.hide;
    return false;
  }


}

function print_action (fnm,act) {
  var url = window.location.href;
  var print_url = url.replace('/view/','/printout/')
  if (act == 'all') {
    var print_url = print_url + '?&all=1'
  }
  if (act == 'page') {
    var print_url = print_url + '?&page=1'
  }
  window.location = print_url;
}

function setApproval(btid,burl) {
  var answer = confirm('Are you sure want to set Approve this record ?');
  if (answer) {
    var w = window.open(burl + '/index.php/page/setApproval/'+btid,'CategorySearch','width=1,height=1,left=1,top=1,scrollbars=1,location=no');
    w.hide;
    return false;
  }
}

function logout() {
var base_url = document.getElementById('base_url').value;
if (window.confirm('Are you sure to log out?'))
  {
    window.location = base_url + "index.php/login/logout";
  };
}

function CurrencyFormatted(nStr) {
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

function delTotal(obj,fnm) {
  if (fnm == '78000QTY_DETAIL') {
    var inputs = obj.getElementsByTagName('input');
    for (i = 0; i < inputs.length; i++) {
    var name = inputs[i].name;
    if (name.match(/fld_btqty/gi)) {
      var totalAmount = parseInt(document.getElementById('fld_btqty').value);
      var value = parseInt(inputs[i].value);
      document.getElementById('fld_btqty').value = totalAmount - value;
    }
    } 
  }
  
  if (fnm == '78000PAYMENT_DETAIL') {
    var inputs = obj.getElementsByTagName('input');
    for (i = 0; i < inputs.length; i++) {
    var name = inputs[i].name;
    if (name.match(/fld_btqty/gi)) {
      var totalAmount = parseInt(document.getElementById('fld_btp01').value);
      var value = parseInt(inputs[i].value);
      document.getElementById('fld_btp01').value = totalAmount - value;
    }
    } 
 }
 
 if (fnm == '78000PURCHASE_ORDER_DETAIL' || fnm == '78000CAEXPENSE' || fnm == '78000INVOICE_DTL' || fnm == '78000PAYMENT_DETAIL') {
    var inputs = obj.getElementsByTagName('input');
    for (i = 0; i < inputs.length; i++) {
    var name = inputs[i].name;
    if (name.match(/fld_btamt/gi)) {
      var totalAmount = parseInt(document.getElementById('fld_btamt').value);
      var value = parseInt(inputs[i].value);
      document.getElementById('fld_btamt').value = totalAmount - value;
    }
    } 
 }

  
}

function setTotal(count,fnm) {
var totalAmount = 0;

if (fnm == '78000QTY_DETAIL') {
  for (i=1; i<=count; i++) { 
    var subAmount = (document.getElementById(fnm + 'fld_btqty01' + i).value == '') ? 0 : parseInt(document.getElementById(fnm + 'fld_btqty01' + i).value);
    totalAmount = parseInt(totalAmount + subAmount);
  }
  document.getElementById('fld_btqty').value = totalAmount;
}

if (fnm == '78000PAYMENT_DETAIL') {
  for (i=1; i<=count; i++) { 
    var subAmount = (document.getElementById(fnm + 'fld_btqty01' + i).value == '') ? 0 : parseInt(document.getElementById(fnm + 'fld_btqty01' + i).value);
    totalAmount = parseInt(totalAmount + subAmount);
  }
  document.getElementById('fld_btp01').value = totalAmount;
}

}

function change(div,count,fnm,countField) {
  var div = document.getElementById(div);
  var elms = div.getElementsByTagName("*");
  var subTotal = 0;
  var row = document.getElementById(countField).value;
  for(var i = 0, maxI = elms.length; i < maxI; ++i) {
    var elm = elms[i];
      if(elm.type == "text" || elm.type == "hidden") {
          if (elm.name == fnm + 'fld_btqty01' + count || elm.name == fnm + 'fld_btuamt01' + count) {
            var subTotal = parseFloat(document.getElementById(fnm + 'fld_btqty01' + count).value * document.getElementById(fnm + 'fld_btuamt01' + count).value);
            document.getElementById(fnm + 'fld_btamt01' + count).value = subTotal;
            var myVal = "";
            var myDec = "";
            var parts = subTotal.toString().split(".");
            parts[0] = parts[0].replace(/[^0-9]/g,"");
            if ( parts[1] ) { myDec = "."+parts[1] }
            while ( parts[0].length > 3 ) {
              myVal = ","+parts[0].substr(parts[0].length-3, parts[0].length )+myVal;
              parts[0] = parts[0].substr(0, parts[0].length-3)
            }
            var sbt = parts[0]+myVal+myDec;
            document.getElementById(fnm + 'fld_btamt01' + count + '_dsc').value = sbt;
          }
          if (elm.name == fnm + 'fld_btamt01' + count)  {
            var totalAmount = 0;
            var inputs = div.getElementsByTagName('input');
            for (m = 0; m < inputs.length; m++) {
              var name = inputs[m].name;
              if (name.match(/fld_btamt01/gi) && !name.match(/_dsc/gi)) {
                var subAmount = parseFloat(inputs[m].value);
                totalAmount = parseFloat(totalAmount + subAmount);
              }
            }
            var tax = parseFloat(totalAmount * 0.1) ;
            totalAmount = totalAmount.toFixed(2);
            tax = tax.toFixed(2);
      if(fnm == '78000') {
              document.getElementById('fld_btamt').value = totalAmount;
              document.getElementById('fld_btamt_dsc').value = totalAmount;
      }
          }
    }
  }

}

function popup_selector(ffval,burl,qname,ffname,bindfield1,bindfield2,bindfield3,bindfield4,bindfield5) {
  var bindval1 = (bindfield1 !='') ? document.getElementById(bindfield1).value : 999;
  var bindval2 =  (bindfield2 !='') ? document.getElementById(bindfield2).value : 999;
  var bindval3 =  (bindfield3 !='') ? document.getElementById(bindfield3).value : 999;
  var bindval4 = (bindfield4 !='') ? document.getElementById(bindfield4).value : 999;
  var bindval5 =  (bindfield5 !='') ? document.getElementById(bindfield5).value : 999;
  var w = window.open(burl + 'index.php/popup/selector?val='+ffval+'&qname='+qname+'&ffname='+ffname+'&bindval1='+bindval1+'&bindval2='+bindval2+'&bindval3='+bindval3+'&bindval4='+bindval4+'&bindval5='+bindval5,'CategorySearch','width=550,height=550,left=50,top=50,scrollbars=1,location=no');
  w.focus();
  return false;
}

function keyhandler(obj,e,max) {
  e = e || event;
  max = max || 50;
  var keycode = e.keyCode
  , len     = 0
  , This    = keyhandler
  , currlen = obj.value.length;
  if (currlen == 4) { 
    var currtext = document.getElementById('fld_btp29').value;
    document.getElementById('fld_btp29').value = currtext + " ";
  }
  if (!('countfld' in This)) {
        This.countfld = document.getElementById('counter');
  }
  if (keycode === 13) {
    return document.forms[0].submit();
  }
  if ((keycode == 32 || keycode>46) && currlen >= max) {
    This.countfld.innerHTML = 'maximum input length reached';
    return false;
  }
  len = (keycode==8 || (keycode===46) && obj.value.length<=max && currlen > 0)
  ? currlen-1
  : keycode <= 46
  ? currlen
  : currlen+1;
  This.countfld.innerHTML = (currlen <1 ? max : max-len) + ' characters left';
  return true;
}

function convertToUpper1(obj) {
  obj.value=obj.value.toUpperCase();
}
    
function showProtect(val) {
  if (val.value == 1) {
    document.getElementById('fld_btp21').style.display = "block";
    document.getElementById('fld_btp21-trigger').style.display = "block";
    document.getElementById('fld_btp22').style.display = "block";
  }
  else {
    document.getElementById('fld_btp21').style.display = "block"; //"none";
    document.getElementById('fld_btp21-trigger').style.display = "block"; //"none";
    document.getElementById('fld_btp22').style.display = "none";
  }
}
   

// AJAX

function cekContainer() {
  var ajaxRequest;  // The variable that makes Ajax possible!
  try {
    // Opera 8.0+, Firefox, Safari
  ajaxRequest = new XMLHttpRequest();
  } 
  catch (e) {
  // Internet Explorer Browsers
    try {
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
  } 
    catch (e) {
    try {
      ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
    } 
      catch (e) {
      // Something went wrong
    alert("Your browser broke!");
    return false;
    }
  }
  }
  // Create a function that will receive data sent from the server
  ajaxRequest.onreadystatechange = function() {
  if(ajaxRequest.readyState == 4) {
  var ajaxDisplay = document.getElementById('message');
  ajaxDisplay.innerHTML = ajaxRequest.responseText;
  if (ajaxRequest.responseText == '' ) {
    document.getElementById("message").style.visibility = "hidden";     
  }
  else {
    document.getElementById("message").style.visibility = "visible"; 
    document.getElementById('fld_btp29').value = '';
    document.getElementById('fld_btp29').focus();
  }
  }
}
  var contnum = document.getElementById('fld_btp29').value;
  var queryString = "fld_btp29=" + contnum;
  var base_url = document.getElementById('base_url').value;
  ajaxRequest.open("GET", base_url + "index.php/page/message/?" + queryString, true);
  ajaxRequest.send(null); 
}

function cekBLOut(){
  var ajaxRequest;  // The variable that makes Ajax possible!
  
  try{
    // Opera 8.0+, Firefox, Safari
    ajaxRequest = new XMLHttpRequest();
  } catch (e){
    // Internet Explorer Browsers
    try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try{
        ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e){
        // Something went wrong
        alert("Your browser broke!");
        return false;
      }
    }
  }
  // Create a function that will receive data sent from the server

  ajaxRequest.onreadystatechange = function(){
    if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('message');
      
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
      if (ajaxRequest.responseText == '' ) {
        document.getElementById("message").style.visibility = "hidden";     
      }
      else {
        document.getElementById("message").style.visibility = "visible"; 
        document.getElementById('fld_btp29').value = '';
        document.getElementById('fld_btp29').focus();
      }
    }
  }
  var book = document.getElementById('fld_btnoreff').value;
  var queryString = "fld_btnoreff=" + book;
  var base_url = document.getElementById('base_url').value;
  ajaxRequest.open("GET", base_url + "index.php/page/message_out/?" + queryString, true);
  ajaxRequest.send(null); 
}

function form_search() {
var search_value = document.getElementById('form_search_value').value;
var base_url = document.getElementById('base_url').value;
window.location = base_url + "index.php/page/view/78000EIR/?fld_btp29=" + search_value + "&search=Search";
}

function countDays() {
var startTime=document.getElementById('fld_btdtsa').value;
var endTime=document.getElementById('fld_btdtso').value;
var startTime_pisah=startTime.split('-');
var endTime_pisah=endTime.split('-');
var objek_tgl=new Date();
var startTime_leave=objek_tgl.setFullYear(startTime_pisah[0],startTime_pisah[1],startTime_pisah[2]);
var endTime_leave=objek_tgl.setFullYear(endTime_pisah[0],endTime_pisah[1],endTime_pisah[2]);
var hasil=(endTime_leave-startTime_leave)/(60*60*24*1000);
document.getElementById('fld_btqty').value=(hasil)+1;
} 
 
