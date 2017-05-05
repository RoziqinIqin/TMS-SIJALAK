<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRANSPORT MANAGEMENT SYSTEM</title>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>css/css.css" />
</head>

<body>

<div id="login_bg">

<div id="login_header">







<div class="login_title">

<div class="login_container">
<header>
<h1><font size="12">TRANSPORT MANAGEMENT SYSTEM</font></H1>

<H1><font size="12">TMS-SIJALAK YOGYAKARTA</font></H1>

<H1>PRODUCTION LIBRARY</H1>
</header></container>


</div>

</div></div>
<div class="login_line"></div>




<div id="login_body_content">

<div class="login_left_content">
<div class="login_logo"></div>
 
</div>

<div class="login_right_content">
 <form name="login_form" action="<?=base_url()?>index.php/login" method="post">
  <table width="300" border="0" cellspacing="3" cellpadding="3" style="border-collapse:collapse;">
Welcome to <strong>Transport Management System</strong>
<br>Please use your username and password to login
    <tr>
      <td width="80">Username</td>
      <td width="5">:</td>
      <td><input id="username" name="username" size="20" type="text" />
       </td>
    </tr>
    <tr>
      <td>Password</td>
      <td>:</td>
      <td><input id="password" name="password" size="20" type="password" />
          <input id="company" name="company" size="20" type="hidden" value=1/>
       </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type='submit' value='Login' class="BtnGreen" onMouseOver="this.className='BtnGreenHov'" onMouseOut="this.className='BtnGreen'" > <input type='reset' value='Reset' class="BtnRed" onMouseOver="this.className='BtnRedHov'" onMouseOut="this.className='BtnRed'"></td>
   </tr>
  </table>
</form>
</div>

</div>


</body>
</html>
