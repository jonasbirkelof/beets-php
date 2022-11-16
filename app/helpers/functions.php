<style>
	.fn-output-head,
	.fn-output-body {
		color: white;
		font-family: Arial, sans-serif;
		padding: 8px 16px;
		width:100%;
	}
	.fn-output-head {
		background-color: #164e63;
		font-size: 20px;
		font-weight: bold;
		margin-top: 16px;
	}
	.fn-output-body {
		background-color: #0e7490;
		font-size: 16px;
		margin-bottom: 16px;
	}
</style>

<?php

function dd($input, $style = "var_dump") 
{
	$functionName = __FUNCTION__ . "()";

	if (isset($input)) {
		echo "<div class='fn-output-head'>Function $functionName</div>";
		echo "<div class='fn-output-body'>";
		echo "<pre>";
		if ($style === "var_dump") {
			var_dump($input);
		} elseif ($style === "simple") {
			print_r($input);
		} else {
			var_dump($input);
		}
		echo "</pre>";
		echo "</div>";
	
		die();
	} else {
		echo "<div class='fn-output-head'>Function $functionName - Error</div>";
		echo "<div class='fn-output-body'>Missing or invalid argument!</div>";
	}
}