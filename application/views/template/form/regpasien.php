<br>
<html>
<body OnLoad="document.POS.fld_btiid1_dsc.focus();">
<form name="<? echo $fld_formnm; ?>" method='post' id="<? echo $fld_formnm; ?>" action="<?=base_url();?>/index.php/page/form_process">
<table align="right">
<input type="hidden" name="act" value="<? echo $mode; ?>" id="act"/>
  <tr>
    <td>Masukkan Nama / Nomer RM Pasien</td>
    <td>:</td>
    <td><input type="text" name="fld_baid01_dsc" id="fld_baid01_dsc" size="50" onChange="popup_selector_regpas(document.getElementById('fld_baid01_dsc').value,'http://localhost/simrs/','list_pasien_detail','fld_baid01')"><input type="hidden" name="fld_baid01" id="fld_baid01">
    <a href="javascript:void(1)" onclick="popup_selector_regpas(document.getElementById('fld_baid01_dsc').value,'http://localhost/simrs/','list_pasien_detail','fld_baid01')"><img src="http://localhost/simrs/images/filefind.png" height="14" width="14" border="0"></a></td>
  </tr>
</table>
<br>
<br>
<br>
<fieldset>
<legend><b>Data Pasien</b></legend>
<div>
<table align='left'>
  <tr>
      <td>No. RM</td>
      <td>:</td>
      <td><input type="text" size="7" name="norm" id="norm" readonly></td>
  </tr>
  <tr>
      <input type="hidden" name="fld_bttyid" id="fld_bttyid" value="15">
      <input type="hidden" name="fld_baido" id="fld_baido" value="1">
      <input type="hidden" name="fld_btno" id="fld_btno" value="[AUTO]">
      <input type="hidden" name="fld_btdt" id="fld_btdt" value="<? echo date('Y-m-d h:m:i');?>">
      <input type="hidden" name="fid" value="64" />
      <input type="hidden" name="fnm" value="78000REGPASIEN" />
      <td>Nama</td>
      <td>:</td>
      <td><input type="text" name="pasien_name" id="pasien_name" readonly></td>
  </tr>
  <tr>
      <td>Tempat / Tanggal Lahir</td>
      <td>:</td>
      <td><input type="text" size="30" name="fld_babop" id="fld_babop" readonly>&nbsp;/&nbsp;<input type="text" name="fld_babod" id="fld_babod" size="9" readonly></td>
  </tr>
  <tr>
      <td>Golongan Darah</td>
      <td>:</td>
      <td><input type="text" size="7" name="blood" id="blood" readonly></td>
  </tr>
   <tr>
      <td>Alamat</td>
      <td>:</td>
      <td><textarea name="fld_bap09" id="fld_bap09" cols="40" rows="5" readonly></textarea></td>
  </tr>
   <tr>
      <td>Telepon</td>
      <td>:</td>
      <td><input type="text" size="15" name="fld_bap06" id="fld_bap06" readonly>&nbsp;&nbsp;&nbsp; HP&nbsp; :&nbsp; <input type="text" size="15" name="fld_bap07" id="fld_bap07" readonly></td>
  </tr>
</table>
</div>
</fieldset>
<br>
<br>
<fieldset>
<legend><b>Data Pendaftaran</b></legend>
<div>
<table align='left'>
  <tr>
      <td>Poliklinik</td>
      <td>:</td>
      <td><input type="text" name="fld_btiid_dsc" id="fld_btiid_dsc" size="30" onChange="popup_selector(document.getElementById('fld_btiid_dsc').value,'http://localhost/simrs/','list_poli','fld_btiid')"><input type="hidden" name="fld_btiid" id="fld_btiid">
    <a href="javascript:void(1)" onclick="popup_selector(document.getElementById('fld_btiid_dsc').value,'http://localhost/simrs/','list_poli','fld_btiid')"><img src="http://localhost/simrs/images/filefind.png" height="14" width="14" border="0"></a>
    </td>
  </tr>
  <tr>
      <td>Dokter</td>
      <td>:</td>
      <td><input type="text" name="fld_baid02_dsc" id="fld_baid02_dsc" size="30" onChange="popup_selector(document.getElementById('fld_baid02_dsc').value,'http://localhost/simrs/','list_dokter','fld_baid02')"><input type="hidden" name="fld_baid02" id="fld_baid02">
    <a href="javascript:void(1)" onclick="popup_selector(document.getElementById('fld_baid02_dsc').value,'http://localhost/simrs/','list_dokter','fld_baid02')"><img src="http://localhost/simrs/images/filefind.png" height="14" width="14" border="0"></a>
    </td>
  </tr>
  <tr>
      <td>Jadwal</td>
      <td>:</td>
      <td><input type="text" name="fld_btp01_dsc" id="fld_btp01_dsc" size="30" onChange="popup_selector(document.getElementById('fld_btp01_dsc').value,'http://localhost/simrs/','list_jadwal','fld_btp01')"><input type="hidden" name="fld_btp01" id="fld_btp01">
    <a href="javascript:void(1)" onclick="popup_selector(document.getElementById('fld_btp01_dsc').value,'http://localhost/simrs/','list_jadwal','fld_btp01')"><img src="http://localhost/simrs/images/filefind.png" height="14" width="14" border="0"></a>
    </td>
  </tr>
  <tr>
      <td>No. Urut</td>
      <td>:</td>
      <td><input type="text" size="7" name="fld_btamt" id="fld_btamt"></td>
  </tr>
</table>
</div>
</fieldset>
<br>
</div>
</form>
</body>
</html>