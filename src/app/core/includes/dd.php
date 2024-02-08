<?php

function dd($input, $style = null) 
{
	$functionName = __FUNCTION__ . "()";

	$style_body = "
		margin: 0; 
		padding: 0;
	";
	
	$style_fnOutputWrap = "
		display: flex; 
		flex-direction: column; 
		height: 100vh;
	";

	$style_fnOutputHead = "
		color: white;
		font-family: Arial, sans-serif;
		padding: 16px 32px;
		background-color: #164e63;
		font-size: 20px;
		font-weight: bold;
	";
	
	$style_fnOutputBody = "
		color: white;
		font-family: Arial, sans-serif;
		padding: 16px 32px;
		background-color: #0e7490;
		flex-grow: 1;
		font-size: 16px;
	";
	
	echo "<body style='$style_body'>";
		echo "<div style='$style_fnOutputWrap'>";
			echo "<div style='$style_fnOutputHead'>Function {$functionName}</div>";
			echo "<div style='$style_fnOutputBody'>";
				echo "<pre>";
					if ($style === "print_r") {
						print_r($input);
					} else {
						var_dump($input);
					}
				echo "</pre>";
			echo "</div>";
		echo "</div>";
	echo "</body>";
	die();
}