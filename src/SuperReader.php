<?php
declare(strict_types=1);

namespace Kristos80\SuperReader;

final class SuperReader implements SuperReaderInterface {

	/**
	 * @var string
	 */
	private string $from = self::GET;

	/**
	 * @param string $from
	 * @return SuperReaderInterface
	 */
	public function from(string $from = self::GET): SuperReaderInterface {
		$this->from = $from;

		return $this;
	}

	/**
	 * @SuppressWarnings("BooleanArgumentFlag")
	 * @param string|array $possibleKeyNames
	 * @param array $possibleValues
	 * @param bool $strict
	 * @param string|null $cast
	 * @return bool
	 */
	public function equals(string|array $possibleKeyNames,
		mixed $possibleValues,
		bool $strict = FALSE,
		?string $cast = NULL): bool {
		$value = $this->get($possibleKeyNames, NULL, $strict);

		if(is_scalar($possibleValues) === TRUE) {
			$possibleValues = [$possibleValues];
		}

		return in_array($value, $possibleValues);
	}

	/**
	 * @SuppressWarnings("BooleanArgumentFlag")
	 * @SuppressWarnings("Superglobals)
	 * @param string[] $possibleKeyNames
	 * @param mixed|null $default
	 * @param bool $strict
	 * @param string|null $cast
	 * @return mixed
	 */
	public function get(string|array $possibleKeyNames,
		mixed $default = NULL,
		bool $strict = FALSE,
		?string $cast = NULL): mixed {
		if(is_scalar($possibleKeyNames) === TRUE) {
			$possibleKeyNames = [$possibleKeyNames];
		}

		$manipulationFn = $strict ? function(string $key) {
			return $key;
		} : function(string $key) {
			return strtolower($key);
		};

		foreach($possibleKeyNames as $possibleKeyName) {
			foreach($this->getSuperGlobal() as $keyName => $value) {
				if($manipulationFn($possibleKeyName) === $manipulationFn($keyName)) {
					$default = $value;
				}
			}
		}

		if($cast) {
			$default = $this->cast($default, $cast);
		}

		return $this->sanitize($default);
	}

	/**
	 * @SuppressWarnings("Superglobals)
	 * @return array
	 */
	private function getSuperGlobal(): array {
		return match ($this->from) {
			self::ENV => $_ENV,
			self::POST => $_POST,
			self::SERVER => $_SERVER,
			self::COOKIE => $_COOKIE,
			self::SESSION => $_SESSION ?? [],
			default => $_GET,
		};
	}

	/**
	 * @param string $value
	 * @param string $cast
	 * @return mixed
	 */
	private function cast(string $value, string $cast): mixed {
		if($cast === "array") {
			$value = json_decode($value, TRUE);
			$cast = NULL;
		}

		if($cast === "object") {
			$value = (object) json_decode($value, TRUE);
			$cast = NULL;
		}

		if($cast) {
			settype($value, $cast);
		}

		return $value;
	}

	/**
	 * @param mixed $value
	 * @return mixed
	 */
	private function sanitize(mixed $value): mixed {
		if(is_bool($value)) {
			return $value;
		}

		if(is_string($value)) {
			return htmlspecialchars($value);
		}

		if(is_int($value)) {
			return filter_var($value, FILTER_VALIDATE_INT);
		}

		if(is_float($value)) {
			return filter_var($value, FILTER_VALIDATE_FLOAT);
		}

		if(is_array($value)) {
			foreach($value as $key => $nonSanitizedValue) {
				$value[$key] = $this->sanitize($nonSanitizedValue);
			}

			return $value;
		}

		return $value;
	}

	/**
	 * @param string $input
	 * @param string|null $cast
	 * @return mixed
	 */
	public function getFromInput(string $input = self::PHP_INPUT, ?string $cast = NULL): mixed {
		$raw = file_get_contents($input);

		if(!$raw) {
			return NULL;
		}

		if($cast) {
			$raw = $this->cast($raw, $cast);
		}

		return $raw;
	}
}