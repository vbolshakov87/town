<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		if (window.opener !== undefined) {
			window.close();
			window.opener.location.reload();
		}
		else {
			window.location.reload();
		}
	</script>
</head>
<body>
<h2 id="title" style="display:none;">Redirecting back to the application...</h2>
<h3 id="link"><a href="/">Click here to return to the application.</a></h3>
<script type="text/javascript">
	document.getElementById('title').style.display = '';
	document.getElementById('link').style.display = 'none';
</script>
</body>
</html>