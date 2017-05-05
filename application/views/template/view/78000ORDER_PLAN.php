<?
$base_url =  base_url();
$location = $this->session->userdata('location');
$data = $this->db->query("select
date_format(t0.fld_btdt,'%Y-%m-%d') 'Tanggal',
t10.fld_empnm 'Supir',
t18.fld_empnm 'Kenek',
t7.fld_bticd,
concat(t8.fld_areanm , '-->', t9.fld_areanm) 'route',
t19.fld_tyvalnm 'Armada',
t0.fld_btno
from
tbl_bth t0
left join tbl_btr t1 on t1.fld_btrsrc=t0.fld_btid and t1.fld_btrdsttyid = 20
left join tbl_bth t2 on t2.fld_btid=t1.fld_btrdst and t2.fld_bttyid=20
left join tbl_be t3 on t3.fld_beid=t0.fld_baidc
left join tbl_emp t4 on t4.fld_empid=t0.fld_baidp
left join tbl_bti t7 on t7.fld_btiid=t0.fld_btp12
left join tbl_emp tx8 on tx8.fld_empid=t0.fld_btp11
left join tbl_route t11 on t11.fld_routeid =t0.fld_btp09
left join tbl_area t8 on t8.fld_areaid=t11.fld_routefrom
left join tbl_area t9 on t9.fld_areaid=t11.fld_routeto
left join tbl_emp t10 on t10.fld_empid=t0.fld_btp11
left join tbl_trk_settlement t12 on t12.fld_btreffid=t0.fld_btid
left join tbl_tyval t13 on t13.fld_tyvalcd=t0.fld_btstat and t13.fld_tyid=2
left join tbl_emp t14 on t14.fld_empid=t0.fld_btp03
left join tbl_trk_settlement t15 on t15.fld_btreffid=t0.fld_btid
left join tbl_lokasi t16 on t16.lokcd=t0.fld_btloc
left join tbl_user t17 on t17.fld_userid=t0.fld_baidp
left join tbl_emp t18 on t18.fld_empid=t0.fld_btp03
left join tbl_tyval t19 on t19.fld_tyvalcd=t7.fld_btiflag and t19.fld_tyid=19
where
t0.fld_bttyid=13
and
date_format(t0.fld_btdt,'%Y-%m-%d')  >= date_format(now(),'%Y-%m-%d') 
and
t0.fld_btloc = $location
order by t0.fld_btdt,t7.fld_bticd,t10.fld_empnm desc
");
?>
<br>
<table widrth=1300>
  <tr>
    <td width=700 height=400 valign='top'>
      <div style='height:400px; width:100%; overflow-x:scroll ; overflow-y: scroll; padding-bottom:10px;'>
        <fieldset style="height: 350px;">
        <legend>Jadwal Eksekusi Order</legend>
          <table cellpadding="1" cellspacing="1" width="100%">
            <tr height="10" bgcolor="#CDCBBF" align="center">
              <td>Nomor SO</td>
              <td>Armada</td>
              <td>Nomor Kendaraan</td>
              <td>Tanggal</td>
              <td>Rute</td>
              <td>Sopir</td>
              <td>Kernet</td>            
            </tr>
            <? foreach ($data->result() as $rdata){
            $no=$no+1;
            if ($no % 2 == 1){
              $bgcolor="#DDDDDD";
            } else {
              $bgcolor="#EEEEEE";
            }
            ?>
            <tr bgcolor="<? echo $bgcolor; ?>">
              <td><? echo $rdata->fld_btno ; ?> </td>
              <td><? echo $rdata->Armada ; ?> </td>
              <td><? echo $rdata->fld_bticd ; ?> </td>
              <td><? echo $rdata->Tanggal ; ?> </td>
              <td><? echo $rdata->route ; ?> </td>
              <td><? echo $rdata->Supir ; ?> </td>
              <td><? echo $rdata->Kenek ; ?> </td>

	    <? } ?>
            </tr>
          </table>
      </fieldset>
      </div>
    </td>
    <td width=600 valign='top'>
    <div style='height:300px; width:100%; overflow-x:scroll ; overflow-y: scroll; padding-bottom:10px;'>
        <fieldset style="height: 200px;">
        <legend>Sales Order</legend>
          <form name="78000ORDER_PLAN" method='post' id="78000ORDER_PLAN" action="<?=base_url();?>/index.php/page/orderPlan">
          <table cellpadding="1" cellspacing="1" width="100%">
          <input name="fld_btloc" id="fld_btloc" value="<?=$this->session->userdata('location');?>" type="hidden">
          <input name="fld_baidp" id="fld_baidp" value="<?=$this->session->userdata('ctid');?>" type="hidden">
          <input name="fld_btstat" id="fld_btstat" value="1" type="hidden">
            <tr height="10" bgcolor="#CDCBBF">
              <td>Tanggal</td>
              <td>:</td>
              <td> <input name="fld_btdt" value="<?=date('Y-m-d');?>" id="fld_btdt" maxlength="15" size="9" class="inputBox1" type="text"><a href="javascript:void(0)" id="fld_btdt-trigger"><img src="<?=base_url();?>/images/calendar.jpg" border="0" height="14" width="14"></a><script>
		      Calendar.setup({
		      dateFormat : "%Y-%m-%d",
                      trigger    : "fld_btdt-trigger",
		      inputField : "fld_btdt",
		      onSelect   : function() { this.hide() }
		      });
		      </script></td>
            </tr>
            <tr height="10" bgcolor="#CDCBBF">
              <td>Armada Tersedia</td>
              <td>:</td>
              <td><input name="fld_btp12_dsc" value="" id="fld_btp12_dsc" maxlength="100" size="30" class="default" onchange="popup_selector(document.getElementById('fld_btp12_dsc').value,'<?=base_url();?>/','list_vehicle_plan','fld_btp12','fld_btloc','fld_btdt','','','')" type="text"><a href="javascript:void(1)" onclick="popup_selector(document.getElementById('fld_btp12_dsc').value,'<?=base_url();?>/','list_vehicle_plan','fld_btp12','fld_btloc','fld_btdt','','','')"><img src="<?=base_url();?>/images/filefind.png" border="0" height="14" width="14"></a>
                  <input name="fld_btp12" id="fld_btp12" value="" type="hidden"></td>
            </tr>
            <tr height="10" bgcolor="#CDCBBF">
              <td>Sopir Tersedia</td>
              <td>:</td>
              <td><input name="fld_btp11_dsc" value="" id="fld_btp11_dsc" maxlength="100" size="30" class="default" onchange="popup_selector(document.getElementById('fld_btp11_dsc').value,'<?=base_url();?>/','list_truck_driver_plan','fld_btp11','fld_baidp','fld_baidp','fld_btloc','fld_btdt','')" type="text"><a href="javascript:void(1)" onclick="popup_selector(document.getElementById('fld_btp11_dsc').value,'<?=base_url();?>/','list_truck_driver_plan','fld_btp11','fld_baidp','fld_baidp','fld_btloc','fld_btdt','')"><img src="<?=base_url();?>/images/filefind.png" border="0" height="14" width="14"></a><input name="fld_btp11" id="fld_btp11" value="" type="hidden"></td>
            </tr>
            <tr height="10" bgcolor="#CDCBBF">
              <td>Rute</td>
              <td>:</td>
              <td><input name="fld_btp09_dsc" value="" id="fld_btp09_dsc" maxlength="100" size="30" class="mandatory" onchange="popup_selector(document.getElementById('fld_btp09_dsc').value,'<?=base_url();?>','list_route_table','fld_btp09','','','','','')" type="text">
                  <a href="javascript:void(1)" onclick="popup_selector(document.getElementById('fld_btp09_dsc').value,'<?=base_url();?>','list_route_table','fld_btp09','','','','','')"><img src="<?=base_url();?>/images/filefind.png" border="0" height="14" width="14"></a><input name="fld_btp09" id="fld_btp09" value="" type="hidden">  </td>
            <tr>
              <td><input type=submit value='Submit'></td>
            </tr>
           
          </table>
        </form> 
      </fieldset>
      </div>
    
    
    </td>
  </tr>
   
</table>

