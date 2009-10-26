<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="icon" href="/logikitframework/logikitPublic/favicon.ico" />
<title>Logikit Framework Test</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="<?php echo URLROOT; ?>css/default.css.php?urlRoot=<?php echo URLROOT; ?>" rel="stylesheet" type="text/css" />
<?php echo headerScripts(); ?>

</head>
<body>
	<?php echo bodyCode(); ?>
<div id="wrapper">
<!-- start header -->
<div id="header">
	<div id="logo">
		<h1><a href="#">Logikit::framework</a></h1>
		<h2>"Cute!"</h2>
	</div>
	<div id="menu">
		<ul>
			<li class="active"><a href="http://framework.logikit.net"><?php echo $this->lang['panel_frameworkTitle'] ; ?></a></li>
			<li class="active"><a href="http://docs.logikit.net/><?php echo $this->lang['panel_documentation'] ; ?></a></li>
		</ul>
	</div>
</div>
<!-- end header -->
</div>

<!-- start page -->
<div id="page">
	<!-- start content -->
	<div id="content">
		<div class="post">

						<?php
$this->renderView();

?>
		
		</div>
		
	</div>
	<!-- end content -->
	<!-- start panel -->
	<div class="sidebar">
		<ul>
			
			<li>
				<h2><b><?php echo $this->lang['panel_panel']; ?></b></h2>
				<ul>
					<li><?php echo siteLink('Start/' , $this->lang['panel_home']); ?></li>
					<li><?php echo siteLink('Start/language' , $this->lang['panel_language']); ?></li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- end panel -->
	<div style="clear: both;">&nbsp;</div>
</div>
<div id="footer">
<p>&copy;2009 Logikit. Powered by <a href="http://framework.logikit.net" title="Logikit::Framework">Logikit::Framework</a></p>
</div>

</body>
</html>
