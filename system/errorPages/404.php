<?php
$urlRoot = $_SESSION['urlRoot'];
unset($_SESSION['urlRoot']);
header("HTTP/1.0 404 Not Found");
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>404 Not Found</title>
    <link href="<?php echo $urlRoot; ?>logikitPublic/css/error.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrapper">
<div class="notFoundTitle">404 Page Not Found</div>

<div class="notFound"><p>The page you requested was not found.</p></div>
</div>
</body>