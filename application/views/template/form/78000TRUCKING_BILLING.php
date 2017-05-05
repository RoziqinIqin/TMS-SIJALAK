<div id="message" style="padding-top: 5px; padding-bottom: 5px; background-color: red; border: 1px solid rgb(0, 0, 0); visibility: hidden;"></div>

<form name="78000TRUCKING_BILLING" method="post" id="78000TRUCKING_BILLING" action="http://dunex-apps.com/index.php/page/form_process">
<input name="fid" value="65" type="hidden">
<input name="fnm" value="78000TRUCKING_BILLING" type="hidden">
<input name="act" value="add" id="act" type="hidden">
<input name="sf" value="" id="act" type="hidden">
<br>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
    <tbody><tr>
    <td style="border-right: 1px solid black;" width="87%">
<table align="center" border="0" cellpadding="0" cellspacing="0">
        <tbody><tr><td style="border-bottom: 1px solid black;" nowrap="nowrap">ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
     <td nowrap="nowrap">
	   <input name="fld_btid" value="" id="fld_btid" maxlength="100" size="7" class="inputBox1" readonly="1" type="text">  </td>
  </tr>
  <tr>
        <td style="border-bottom: 1px solid black;" nowrap="nowrap">Company&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
     <td nowrap="nowrap">
	   <input name="fld_baido_dsc" value="PT. Dunia Express Transindo" id="fld_baido_dsc" maxlength="100" size="30" class="default" readonly="1" type="text"><input name="fld_baido" id="fld_baido" value="1" type="hidden">  </td>
  </tr>
  <tr>
        <td style="border-bottom: 1px solid black;" nowrap="nowrap">Billing Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
     <td nowrap="nowrap">
	   <input name="fld_btno" value="[AUTO]" id="fld_btno" maxlength="100" size="0" class="inputBox1" readonly="1" type="text">  </td>
<td>&nbsp;&nbsp;&nbsp;</td>
        <td style="border-bottom: 1px solid black;" nowrap="nowrap">Billng Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
     <td nowrap="nowrap">
	   <input name="fld_btdt" value="2014-03-18 17:36:40" id="fld_btdt" maxlength="15" size="9" class="inputBox1" type="text"><a href="javascript:void(0)" id="fld_btdt-trigger"><img src="http://dunex-apps.com//images/calendar.jpg" border="0" height="14" width="14"></a><script>
		      Calendar.setup({
		      dateFormat : "%Y-%m-%d",
                      trigger    : "fld_btdt-trigger",
		      inputField : "fld_btdt",
		      onSelect   : function() { this.hide() }
		      });
		      </script>  </td>
  </tr>
  <tr>
        <td style="border-bottom: 1px solid black;" nowrap="nowrap">Customer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
     <td nowrap="nowrap">
	   <input name="fld_baidc_dsc" value="" id="fld_baidc_dsc" maxlength="100" size="35" class="default" onchange="popup_selector(document.getElementById('fld_baidc_dsc').value,'http://dunex-apps.com/','list_customer','fld_baidc','','','','','')" type="text"><a href="javascript:void(1)" onclick="popup_selector(document.getElementById('fld_baidc_dsc').value,'http://dunex-apps.com/','list_customer','fld_baidc','','','','','')"><img src="http://dunex-apps.com//images/filefind.png" border="0" height="14" width="14"></a><input name="fld_baidc" id="fld_baidc" value="807" type="hidden">  </td>
<td>&nbsp;&nbsp;&nbsp;</td>
        <td style="border-bottom: 1px solid black;" nowrap="nowrap">Fleet Type&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
     <td nowrap="nowrap">
	   <select name="fld_btiid" id="fld_btiid" class="default">
<option value="0">[--Select--]</option>
<option value="1">Trailer</option>
<option value="2">Car Carrier</option>
<option value="3">Box</option>
</select>  </td>
  </tr>
  <tr>
        <td style="border-bottom: 1px solid black;" nowrap="nowrap">Total Amount&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
     <td nowrap="nowrap">
	   <input name="fld_btamt" value="" id="fld_btamt" maxlength="100" size="0" class="inputBox1" readonly="1" type="text">  </td>
  </tr>
  <tr>
        <td style="border-bottom: 1px solid black;" nowrap="nowrap">Posted By&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
     <td nowrap="nowrap">
	   <input name="fld_baidp_dsc" value="SUDARMAN [11120315]" id="fld_baidp_dsc" maxlength="100" size="30" class="default" readonly="1" onchange="popup_selector(document.getElementById('fld_baidc_dsc').value,'http://dunex-apps.com/','list_customer','fld_baidc','','','','','')" type="text"><input name="fld_baidp" id="fld_baidp" value="315" type="hidden">  </td>
  </tr>
  <tr>
    <input name="fld_bttyid" id="fld_bttyid" value="15" type="hidden">  
  </tr>
  <tr>
</tr></tbody></table>
</td>
<td valign="top">
      <table>
         <tbody><tr>
          <td>&nbsp;&nbsp;&nbsp;Transaction Map :</td>
        </tr>
        <tr> 
          <td>
		           </td>
        </tr><tr> 
	<td>- </td>
	</tr>
        <tr>
	<td>
                           </td>



       </tr>

      </tbody></table>
</td>
</tr>
</tbody></table>
<br>
<div id="ddtabs" class="basictab">
  <ul>
    <li><a class="current" href="javascript:void(0)" onclick='expandcontent("Settlement Result", this)'>Settlement Result</a></li>
  </ul>
</div>
<div class="ddcolortabsline">&nbsp;</div>
<div style="height: 400px; width: 100%; overflow: scroll; padding-bottom: 10px;">
  <div>
    <div style="display: block;" id="Settlement Result" class="tabcontent">
      <table id="" bgcolor="#FFFFFF" width="100%" cellpadding="0" cellspacing="1">
        <tbody>
          <tr align="center" bgcolor="#CDCBBF" height="10">
            <td nowrap="nowrap" width="30">No</td>
            <td align="center" nowrap="nowrap">DO Number </td>
            <td align="center" nowrap="nowrap">Customer </td>
            <td align="center" nowrap="nowrap">Vehicle Number </td>  
            <td align="center" nowrap="nowrap">Driver </td> 
            <td align="center" nowrap="nowrap">Cost Type </td><td align="center" nowrap="nowrap">Amount </td><td align="center" nowrap="nowrap">Action </td></tr><tr bgcolor="#FFFFFF"><td width="20">1</td><td align="" nowrap="nowrap">DET/BDO/1402/01082</td><td align="" nowrap="nowrap">PT.Prospect Motor</td><td align="" nowrap="nowrap">B 9028 WV</td><td align="" nowrap="nowrap">HARIS FARKHANI(1061)</td><td align="" nowrap="nowrap">Cash Advance</td><td align="" nowrap="nowrap">486000</td><td align="" nowrap="nowrap"><a href="http://dunex-apps.com/index.php/page/deleteSettlement/265/56937" onclick="return confirm(' Are you sure want to Delete ? ')">Delete</a></td></tr><tr bgcolor="#F5F5F5"><td width="20">2</td><td align="" nowrap="nowrap">DET/BDO/1402/01088</td><td align="" nowrap="nowrap">PT.Prospect Motor</td><td align="" nowrap="nowrap">B 9029 UIN</td><td align="" nowrap="nowrap">NURPAMUJI</td><td align="" nowrap="nowrap">Cash Advance</td><td align="" nowrap="nowrap">486000</td><td align="" nowrap="nowrap"><a href="http://dunex-apps.com/index.php/page/deleteSettlement/266/56937" onclick="return confirm(' Are you sure want to Delete ? ')">Delete</a></td></tr>
<tr>

</tr>
</tbody>
</table>

</div>
</form>
<br>

