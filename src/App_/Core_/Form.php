<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Session;
use App\Core\Database as DB;

class Form
{
	private $errors = [];
	private $field;
	private $value;
	private $valueLength;

	/**
	 * Get the errors array. Pass a label to only return that sub-array.
	 * 
	 * @param null $label
	 * 
	 * @return array
	 */
	public function errors($label = null): array
	{
		return $label ? $this->errors[$label] : $this->errors;
	}

	/**
	 * Add an error to the errors array.
	 * 
	 * @param string $label
	 * @param mixed $key
	 * @param mixed $value
	 * 
	 * @return object
	 */
	public function error(string $label, $key, $value): object
	{
		$this->errors[$label] = [$key => $value];

		return $this;
	}

	/**
	 * Flash the errors array to the session.
	 * 
	 * @return void
	 */
	public function flashErrors(): void
	{
		Session::flash('errors', $this->errors());
	}

	/**
	 * Initiate the form validation.
	 * 
	 * @param string $field
	 * @param mixed $value
	 * 
	 * @return object
	 */
	public function validate(string $field, $value): object
	{
		$this->field = $field;
		$this->value = $value;
		$this->valueLength = mb_strlen($value);

		return $this;
	}

	/**
	 * Check if the value consists of only alpha characters (a-z, A-Z).
	 * 
	 * @param array $params
	 * 
	 * @return object
	 */
	public function alpha(array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_ALPHA;

		if (! ctype_alpha($this->value)) {
			$this->error($this->field, 'alpha', $errorMessage);
		}

		return $this;
	}

	/**
	 * Check if the value consists of alpha (a-z, A-Z) and/or numeric (0-9) characters.
	 * 
	 * @param array $params
	 * 
	 * @return object
	 */
	public function alphaNumeric(array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_ALPHA_NUMERIC;

		if (! ctype_alnum($this->value)) {
			$this->error($this->field, 'alpha_numeric', $errorMessage);
		}

		return $this;
	}

	/**
	 * Check if the value hs the form of an email address.
	 * 
	 * @param array $params
	 * 
	 * @return object
	 */
	public function email(array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_EMAIL;

		if ($this->valueLength > 0) {
			$validatedEmail = filter_var($this->value, FILTER_VALIDATE_EMAIL) ? true : false;

			if (! $validatedEmail) {
				$this->error($this->field, 'email', $errorMessage);
			}
		}

		return $this;
	}

	public function image()
	{
		return $this;
	}

	/**
	 * Check if the field is filled (not empty).
	 * 
	 * @return bool
	 */
	public function isFilled(): bool
	{
		$isFilled = true;

		if ($this->value == "") $isFilled = false;
		if ($this->value == null) $isFilled = false;
		if (strlen(trim($this->value)) == 0) $isFilled = false;

		return $isFilled;
	}

	/**
	 * Check if the length of the value is in between the given amounts of characters.
	 * 
	 * @param int $minLength
	 * @param int $maxLength
	 * @param array $params
	 * 
	 * @return object
	 */
	public function length(int $minLength, int $maxLength, array $params = []): object
	{
		$allowEmpty = $params['allowEmpty'] ?? false;
		$errorMessage = $params['error'] ?? null;
		$errorMessageMin = $errorMessage ?? $params['errorMin'] ?? null;
		$errorMessageMax = $errorMessage ?? $params['errorMax'] ?? null;
		
		if ($this->valueLength == 0 && $allowEmpty) {
			$minLength = 0;
		}

		$this->lengthMin($minLength, ['error' => $errorMessageMin]);
		$this->lengthMax($maxLength, ['error' => $errorMessageMax]);

		return $this;
	}

	/**
	 * Check if the length of the value is less than the given amount of characters.
	 * 
	 * @param int $maxLength
	 * @param array $params
	 * 
	 * @return object
	 */
	public function lengthMax(int $maxLength, array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_STR_MAX;

		if ($this->valueLength > $maxLength) {
			$this->error($this->field, 'length', $errorMessage);
		}

		return $this;
	}

	/**
	 * Check if the length of the value is larger than the given amount of characters.
	 * 
	 * @param int $minLength
	 * @param array $params
	 * 
	 * @return object
	 */
	public function lengthMin(int $minLength, array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_STR_MIN;
		
		if ($this->valueLength < $minLength) {
			$this->error($this->field, 'length', $errorMessage);
		}

		return $this;
	}

	/**
	 * Check if the value matches another value.
	 * 
	 * @param mixed $matchingValue
	 * @param array $params
	 * 
	 * @return object
	 */
	public function matching($matchingValue, array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_MATCHING;
		
		if ($this->value !== $matchingValue) {
			$this->error($this->field, 'matching', $errorMessage);
		}

		return $this;
	}

	/**
	 * Check if the value has the form of a name.
	 * 
	 * @param array $params
	 * 
	 * @return object
	 */
	public function name(array $params = []): object
	{
		$minLength = $params['min'] ?? 1;
		$maxLength = $params['max'] ?? 64;
		$errorMessage = $params['error'] ?? FORM_ERROR_NAME;

		$this->length($minLength, $maxLength);

		if (! $this->regex('/[^\p{L} -]+/u')) {
			$this->error($this->field, 'name', $errorMessage);
		}

		return $this;
	}
	
	/**
	 * Check if the value consists of only numeric characters (0-9).
	 * 
	 * @param array $params
	 * 
	 * @return object
	 */
	public function numeric(array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_NUMERIC;

		if (
			$this->valueLength > 0 
			&& ! ctype_digit($this->value)
		) {
			$this->error($this->field, 'numeric', $errorMessage);
		}

		return $this;
	}

	/**
	 * Check if the value is formatted as a password.
	 * 
	 * @param array $params
	 * 
	 * @return object
	 */
	public function password(array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_PASSWORD;

		$this->length(PASSWORD_MIN_LENGTH, PASSWORD_MAX_LENGTH, ['error' => $errorMessage]);

		return $this;
	}

	/**
	 * Check if the value matches the given regular expression
	 * 
	 * @param string $regularExpression
	 * @param array $params
	 * 
	 * @return object
	 */
	public function regex(string $regularExpression, array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_MATCH;

		if (preg_match($regularExpression, $this->value) === 1) {
			$this->error($this->field, 'regex', $errorMessage);
		}

		return $this;
	}

	/**
	 * Make the field required.
	 * 
	 * @param array $params
	 * 
	 * @return object
	 */
	public function required(array $params = []): object
	{
		$errorMessage = $params['error'] ?? FORM_ERROR_REQUIRED;

		if (! $this->isFilled()) {
			$this->error($this->field, 'required', $errorMessage);
		}

		return $this;
	}

	/**
	 * Check if the value is unique in the database.
	 * 
	 * @param string $col
	 * @param string $table
	 * @param array $params
	 * 
	 * @return object
	 */
	public function unique(string $col, string $table, array $params = []): object
	{
		$ignoreId = $params['ignore'] ?? null;
		$errorMessage = $params['error'] ?? FORM_ERROR_UNIQUE;

		if (! $this->isFilled()) {
			$errorMessage = FORM_ERROR_FAULTY_VALUE;
		}

		if ($this->valueLength > 0) {
			if ($ignoreId) {
				$sql = "SELECT $col FROM $table WHERE $col = ? AND id <> ?";
				$result = DB::query($sql, [$this->value, $ignoreId])->fetchAll();
			} else {
				$sql = "SELECT $col FROM $table WHERE $col = ?";
				$result = DB::query($sql, [$this->value])->fetchAll();
			}
	
			if (count($result) > 0) {
				$this->error($this->field, 'unique', $errorMessage);
			}
		}		

		return $this;
	}
}