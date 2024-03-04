<?php

declare(strict_types=1);

namespace App\Http;

use App\Core\Session;

class Feedback
{
	public static $component = null;
	private static $createComponent = true;

	/**
	 * Set a new feedback name
	 * 
	 * @param mixed $value
	 * 
	 * @return void
	 */
	public static function set($value): void
	{
		Session::flash('feedback', $value);
	}

	/**
	 * Select the feedback message to show (by name)
	 * 
	 * @param mixed $value
	 * 
	 * @return object
	 */
	public static function for($value): object
	{
		static::$createComponent = Session::get('feedback') == $value ? true : false;

		return new static();
	}

	/**
	 * Execute the feedback message
	 * 
	 * @return mixed
	 */
	public static function run(): mixed
	{
		echo static::$component ?? null;

		return new static();
	}

	/**
	 * Create an alert message 
	 * 
	 * @param array $args
	 * 
	 * @return object
	 */
	public static function alert($args = []): object
	{
		if (static::$createComponent) {
			// Default settings
			$defaultText = "-_-";
			$defaultStyle = "primary";
			$defaultIcon = null;

			// Override default settings if any given in $args
			$text = $args['text'] ?? $defaultText;
			$style = $args['style'] ?? $defaultStyle;
			$icon = isset($args['icon']) ? "<i class=\"{$args['icon']} me-2\"></i>" : $defaultIcon;

			// Create the feedback component
			static::$component = "
				<div class=\"alert alert-{$style} alert-dismissible fade show\" role=\"alert\" style=\"max-widyh:200px;\">
					$icon $text
					<button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Stäng\"></button>
				</div>
			";
		}

		return new static();
	}

	public static function callout($args = []): object
	{
		if (static::$createComponent) {
			// Default settings
			$defaultText = "-_-";
			$defaultStyle = "note";
			$defaultBootstrapIcon = false;
			$defaultDisableIcon = false;

			// Override default settings if any given in $args
			$text = $args['text'] ?? $defaultText;
			$style = $args['style'] ?? $defaultStyle;
			$disableIcon = $args['disableIcon'] ?? $defaultDisableIcon;
			$bootstrapIcon = $args['bootstrapIcon'] ?? $defaultBootstrapIcon;

			$useBsIcon = $bootstrapIcon ? "callout-bs-icon" : null;
			$useIcon = $disableIcon ? "callout-no-icon" : null;

			// Create the feedback component
			static::$component = "
				<div class=\"callout callout-{$style} $useBsIcon $useIcon mx-auto\">
					<div class=\"callout-header\">$text</div>
				</div>
			";
		}

		return new static();
	}

	/**
	 * Create a toast message 
	 * 
	 * @param array $args
	 * 
	 * @return object
	 */
	public static function toast($args = []): object
	{
		if (static::$createComponent) {
			// Default settings
			$defaultToastId = "feedbackToast";
			$defaultOffsetY = "58px";
			$defaultText = "-_-";
			$defaultStyle = "primary";
			$defaultIcon = null;
	
			// Override default settings if any given in $args
			$toastId =  $defaultToastId;
			$offsetY = $args['offset-y'] ?? $defaultOffsetY;
			$text = $args['text'] ?? $defaultText;
			$style = $args['style'] ?? $defaultStyle;
			$icon = isset($args['icon']) ? "<i class=\"{$args['icon']} me-2\"></i>" : $defaultIcon;
		
			// Create the feedback component
			static::$component = "
				<div class=\"toast-container position-fixed end-0 p-3\" style=\"top: $offsetY\">
					<div id=\"$toastId\" class=\"toast align-items-center text-bg-{$style} border-0\" role=\"alert\" aria-live=\"assertive\" aria-atomic=\"true\">
						<div class=\"d-flex\">
							<div class=\"toast-body\">$icon $text</div>
							<button type=\"button\" class=\"btn-close btn-close-white me-2 m-auto\" data-bs-dismiss=\"toast\" aria-label=\"Stäng\"></button>
						</div>
					</div>
				</div>
			";
		}

		return new static();
	}
}