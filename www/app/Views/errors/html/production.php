<!doctype html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="robots" content="noindex">

	<title>잘못된 접근입니다.</title>

	<style type="text/css">
		<?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
	</style>
</head>

<body>

	<div class="container text-center">

		<h1 class="headline">잘못된 접근입니다.</h1>

		<p class="lead">메인으로 이동됩니다..</p>

	</div>

</body>

<script>
	setTimeout(function() {
		location.href='/';
	}, 1000);
</script>

</html>