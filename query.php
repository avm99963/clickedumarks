<?php
require_once("core.php");

if (!isloggedin()) {
	header("Location: index.php");
	exit();
}

$morenav = '<a href="home.php">ClickEdu Marks</a> > Query';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Query – ClickEdu Marks</title>
		<link rel="stylesheet" href="styles.css">
		<script src="jquery/jquery.min.js"></script>
		<script src="selectize/selectize.min.js"></script>
		<link rel="stylesheet" type="text/css" href="selectize/selectize.default.css" />
		<script src="js/query.js"></script>
		<?php include("head.php"); ?>
	</head>
	<body>
		<?php include("header.php"); ?>
		<h1>Query</h1>
		<form method="POST">
			<p><label for="query">Query:</label>
				<select name="query" id="query">
					<?php
					foreach ($dict["queries"] as $query) {
						?>
						<option value="<?=$query?>"<?=((isset($_POST["query"]) && $_POST["query"] == $query) ? " selected" : "")?>><?=$query?></option>
						<?php
					}
					?>
				</select>
			</p>
			<p><label for="parameters">Parámetros:</label><br><textarea id="parameters" name="parameters" style="width: 300px; height: 150px;"><?=((isset($_POST["parameters"])) ? $_POST["parameters"] : "")?></textarea></p>
			<p><label for="method">Método:</label> <select name="method"><option value="GET"<?=((isset($_POST["method"]) && $_POST["method"] == "GET") ? " selected" : "")?>>GET</option><option value="POST"<?=((isset($_POST["method"]) && $_POST["method"] == "POST") ? " selected" : "")?>>POST</option></select></p>
			<p><label for="format">Formato:</label> <select name="format"><option value="array"<?=((isset($_POST["format"]) && $_POST["format"] == "array") ? " selected" : "")?>>array</option><option value="json"<?=((isset($_POST["format"]) && $_POST["format"] == "json") ? " selected" : "")?>>json</option></select></p>
			<p><input type="submit" value="Query"></p>
		</form>
		<?php
		if (isset($_POST["query"])) {
			if (isset($_POST["format"]) && $_POST["format"] == "json") {
				$json = ws_curl($_POST["query"], $_POST["parameters"], $_POST["method"]);
			} else {
				$json = ws_query($_POST["query"], $_POST["parameters"], $_POST["method"]);
			}
			?>
<hr>
<p style="word-break: break-all;"><b><?=$conf["apiurl"]?>/ws/app_clickedu_query.php?cons_key=<?=$conf["cons_key"]?>&cons_secret=<?=$conf["cons_secret"]?>&auth_token=<?=$_SESSION["auth_token"]?>&auth_secret=<?=$_SESSION["auth_secret"]?>&query=<?=$_POST["query"].((isset($_POST["parameters"]) && !empty($_POST["parameters"]) ? "&".$_POST["parameters"] : ""))?></b></p>
<pre><?php print_r($json); ?></pre>
			<?php
		}
		?>
	</body>
</html>