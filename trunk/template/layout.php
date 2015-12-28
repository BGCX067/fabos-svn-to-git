<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php Output::charset() ?>
<title><?php Output::title() ?></title>
<?php Output::meta('author', 'caleng') ?>
<?php Output::keywords() ?>
<?php Output::description() ?>
<?php Output::importJS() ?>
<?php Output::importCSS() ?>
</head>

<body>
<?php include_once($TEMPLATE_FILE); ?>

</body>
</html>