<!DOCTYPE html>
<style>
body {
    background: url(http://thepurplepeople.co.uk/dash/Assets/Background.png);
    /*background: #999999;*/
    background-size: 100vw 100vh;
    font-family: Arial;
    font-weight: lighter;
	color:#FFFFFF;
	font-size:30px;
}
</style>
<link rel="stylesheet" href="http://thepurplepeople.co.uk/dash/dash.css" title="external style sheet">
<html>
<head>
<title>Personal Dashboard</title>
<script type="text/javascript" src="http://thepurplepeople.co.uk/dash/dash.js"></script>

<?php include "home.php";?>
<?php include "common.php";?>
</head>
<body>

<div id="container">
<?php echo signin(); ?>
</div>

</body>
</html> 