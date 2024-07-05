<?php
declare(strict_types=1);

namespace Kristos80\SuperReader;

final class SuperReader implements SuperReaderInterface {

	/**
	 * @var string|iterable
	 */
	private string|iterable $from = self::GET;

	/**
	 * @param string|iterable $from
	 * @return SuperReaderInterface
	 */
	public function from(string|iterable $from = self::GET): SuperReaderInterface {
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
			foreach($this->getFull() as $keyName => $value) {
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
	 * @return iterable
	 */
	public function getFull(): iterable {
		$data = [];

		if(is_iterable($this->from)) {
			return $this->from;
		}

		switch($this->from) {
			case self::GET:
				$data = $_GET;
			break;
			case self::POST:
				$data = $_POST;
			break;
			case self::ENV;
				$data = $_ENV;
			break;
			case self::COOKIE:
				$data = $_COOKIE ?? [];
			break;
			case self::SESSION:
				$data = $_SESSION ?? [];
			break;
			case self::SERVER:
				$data = $_SERVER ?? [];
			break;
			case self::ANY_SUPER_GLOBAL:
				$data = array_merge($_GET,
					$_POST,
					$_ENV,
					$_COOKIE ?? [],
					$_SESSION ?? []);
			break;
		}

		return $data;
	}

	/**
	 * @param string $value
	 * @param string $cast
	 * @return mixed
	 */
	private function cast(string $value, string $cast): mixed {
		if($cast === self::CAST_ARRAY) {
			$value = json_decode($value, TRUE);
			$cast = NULL;
		}

		if($cast === self::CAST_OBJECT) {
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

}