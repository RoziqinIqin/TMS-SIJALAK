<?
$base_url =  base_url();
$data = $this->db->query("select t1.fld_btno,
                          t2.fld_bttynm,
                          t5.fld_tyvalnm,
                          t3.fld_username,
                          date_format(t1.fld_btdt,'%Y-%m-%d') 'date',
                          concat('<a href = ','$base_url','index.php/page/form/' ,t2.fld_bttyform, '/edit/',t1.fld_btid,'>' , 'View' , '</a>') 'view'
			  from tbl_aprvtkt t0  
                          left join tbl_bth t1 on t1.fld_btid=t0.fld_btid 
                          left join tbl_btty t2 on t2.fld_bttyid=t1.fld_bttyid 
                          left join tbl_user t3 on t3.fld_userid=t1.fld_baidp
			  left join tbl_tyval t5 on t5.fld_tyvalcd=t0.fld_aprvroleid and fld_tyid=3
                          where t0.fld_usergrpid=$groupid and t0.fld_aprvtktstat=1 
			  and t1.fld_btloc='$location' order by t1.fld_btdt DESC");
?>
<form>
<br>
<table widrth=100%>
  <tr>
    <td width=700 height=300 valign='top'>
      <div style='height:200px; width:100%; overflow-x:scroll ; overflow-y: scroll; padding-bottom:10px;'>
        <fieldset style="height: 200px;">
        <legend>Pending Approval</legend>
          <table cellpadding="1" cellspacing="1" width="100%">
            <tr height="10" bgcolor="#CDCBBF" align="center">
              <td>Transaction Type</td>
              <td>Transaction Number</td>
              <td>Date</td>
              <td>Posted By</td>
              <td>Approval Type</td>
              <td>Action</td>            
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
              <td><? echo $rdata->fld_bttynm ; ?> </td>
              <td><? echo $rdata->fld_btno ; ?> </td>
              <td><? echo $rdata->date ; ?> </td>
              <td><? echo $rdata->fld_username ; ?> </td>
              <td><? echo $rdata->fld_tyvalnm ; ?> </td>
              <td><? echo $rdata->view ; ?> </td>

	    <? } ?>
            </tr>
          </table>
      </fieldset>
      </div>
    </td>
    <td width=600>&nbsp;</td>
  </tr>
   <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>


</form> 
