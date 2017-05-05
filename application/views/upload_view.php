<html>
<head>
<title>Upload Form</title>
</head>
<body>

<?php echo $error;?>


<?php echo form_open_multipart('upload/do_upload');?>

<input type="file" name="userfile" size="20" />
<input type="hidden" name="val" size="20" value = "<?php echo $val;?>"/>
<input type="hidden" name="type" size="20" value = "<?php echo $type;?>"/>

<br /><br />

<input type="submit" value="upload" />

</form>

</body>
</html>
