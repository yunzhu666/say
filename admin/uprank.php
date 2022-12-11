<?php
session_start();
include_once("../config/config.php");
include_once("../config/ini.php");
include_once("nav.php");
$link=@mysqli_connect(MYSQLIP, MYSQLUSER, MYSQLPSWD);
@mysqli_select_db($link,MYSQLBASE);
$query=@mysqli_query($link,"select * from user where username='".$_SESSION['username']."'");
$rows=@mysqli_fetch_array($query);
if($rows['id']!=1 || $_SESSION['username']==''){
	echo '<script language="JavaScript">location="../index.php";</script>';
}
?>
<!doctype html>
<html class="no-js">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>排名更新- <?php echo SITENAME?></title><meta name="renderer" content="webkit">
  <meta http-equiv="Cache-Control" content="no-siteapp"/>
  <link rel="icon" type="icon" href="../assets/i/favicon.ico">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">
  <link rel="stylesheet" href="../assets/css/amazeui.min.css">
  <link rel="stylesheet" href="../assets/css/app.css">
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<div id="content">
<br /><br /><br /><br /><br />
<?php
	@$queSite=mysqli_query($link, "SELECT * FROM site;");
	@$rowSite=mysqli_fetch_array($queSite);
	@$commDate=$rowSite['sitecmdate'];
?>
	<div class="am-alert am-alert-success" data-am-alert>
  <button type="button" class="am-close">&times;</button>
  <p>上次更新的时间为：<?php ini_set('date.timezone', 'Asia/Shanghai'); echo date("Y-m-d H:i:s",$commDate); ?></p>
</div>
	<form action="" class="am-form" id="doc-vld-msg" method="post">
  <fieldset>
	<input name="uprank" class="am-btn  am-btn-secondary" value="更新排名" type="submit"/>
  </fieldset>
</form>
</div>
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="../assets/js/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.3/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/amazeui.ie8polyfill.min.js"></script>
<![endif]-->
<script src="../assets/js/amazeui.min.js"></script>
	<script type="text/javascript">
	$(function() {
  $('#doc-vld-msg').validator({
    onValid: function(validity) {
      $(validity.field).closest('.am-form-group').find('.am-alert').hide();
    },

    onInValid: function(validity) {
      var $field = $(validity.field);
      var $group = $field.closest('.am-form-group');
      var $alert = $group.find('.am-alert');
      // 使用自定义的提示信息 或 插件内置的提示信息
      var msg = $field.data('validationMessage') || this.getValidationMessage(validity);

      if (!$alert.length) {
        $alert = $('<div class="am-alert am-alert-danger"></div>').hide().
          appendTo($group);
      }

      $alert.html(msg).show();
    }
  });
});
</script>
<?php include("../footer.php")?>
<?php
	include("../functions.php");
 if(@$_POST['uprank']){
		$queUpComm=mysqli_query($link,"SELECT * FROM user");
	 	$rowUpComm=mysqli_fetch_array($queUpComm);
	 	while($rowUpComm){
	 		$Uid=$rowUpComm['id'];
			@mysqli_query($link,"UPDATE user SET usercomm=(SELECT COUNT(sid) FROM megs WHERE sid=".$Uid.") WHERE id=".$Uid.";");
			@mysqli_query($link,"UPDATE site SET sitecmdate=".time().";");
		}
 }
?>

</script>
</body>
</html>