<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?> | Flashcards</title>
	    <meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="<?=registry("app.description")?>" />
		<meta name="author" content="<?=registry("vendorInfo.name")?>">
		<meta name="robots" content="index, follow"/>
		<meta name="revisit-after" content="2 month"/>


		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- sb-admin-2 bootstrap theme css file -->
		<link type="text/css" rel="stylesheet" href="<?=linkCss("sb-admin-2")?>"/>

		<!-- font-awesome icons -->
		<link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- loader animation css file -->
		<link type="text/css" rel="stylesheet" href="<?=linkCss("loader")?>"/>

		<!-- Project css file -->
		<link type="text/css" rel="stylesheet" href="<?=linkCss("default")?>"/>

		<!-- Jquery + Jquery UI -->
		<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<script>
			function returnFWAlias() {
				return "<?=linkTo()?>";
			}
		</script>
	</head>	
	<body>
		<div id="wrapper">