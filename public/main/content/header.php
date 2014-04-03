<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo $this->meta['title']; ?></title>
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $this->baseasset; ?>images/favicon.ico" />
	<link rel="apple-touch-icon" type="image/x-icon" href="<?php echo $this->baseasset; ?>images/favicon.gif" />
    
	<?php 
	foreach ($this->assets->getAllCss() as $assets) {
		echo $assets;
	}
	?>
    
</head>
<body>