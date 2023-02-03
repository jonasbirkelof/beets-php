<style>
	body {
		margin: 0;
		padding: 0;
	}
	.fn-output-wrap {
		display: flex;
		flex-direction: column;
		height: 100vh;;
	}
	.fn-output-head,
	.fn-output-body {
		color: white;
		font-family: Arial, sans-serif;
		padding: 16px 32px;
	}
	.fn-output-head {
		background-color: #164e63;
		font-size: 20px;
		font-weight: bold;
	}
	.fn-output-body {
		background-color: #0e7490;
		flex-grow: 1;
		font-size: 16px;
	}
</style>

<?php

function dd($input = null, $style = "var_dump") 
{
	$functionName = __FUNCTION__ . "()";

	if (isset($input)) {
		echo "<div class='fn-output-wrap'>";
			echo "<div class='fn-output-head'>Function {$functionName}</div>";
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
		echo "</div>";
		die();
	} else {
		echo "<div class='fn-output-wrap'>";
			echo "<div class='fn-output-head'>Function {$functionName} Error!</div>";
			echo "<div class='fn-output-body'>Missing or invalid argument!</div>";
		echo "</div>";
		die();
	}
}