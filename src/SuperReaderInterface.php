<?php
declare(strict_types=1);

namespace Kristos80\SuperReader;

interface SuperReaderInterface {

	/**
	 *
	 */
	public const GET = "get";

	/**
	 *
	 */
	public const POST = "post";

	/**
	 *
	 */
	public const SERVER = "server";

	/**
	 *
	 */
	public const COOKIE = "cookie";

	/**
	 *
	 */
	public const SESSION = "session";

	/**
	 *
	 */
	public const ENV = "env";

	/**
	 *
	 */
	public const PHP_INPUT = "php://input";

	/**
	 * @param string $from
	 * @return self
	 */
	public function from(string $from = self::GET): self;

	/**
	 * @SuppressWarnings("BooleanArgumentFlag")
	 * @param string|array $possibleKeyNames
	 * @param array $possibleValues
	 * @param bool $strict
	 * @return bool
	 */
	public function equals(string|array $possibleKeyNames, mixed $possibleValues, bool $strict = FALSE): bool;

	/**
	 * @param string $input
	 * @param string|null $cast
	 * @return mixed
	 */
	public function getFromInput(string $input = self::PHP_INPUT, ?string $cast = NULL): mixed;

	/**
	 * @SuppressWarnings("BooleanArgumentFlag")
	 * @param string|string[] $possibleKeyNames
	 * @param mixed|null $default
	 * @param bool $strict
	 * @param string|null $cast
	 * @return mixed
	 */
	public function get(string|array $possibleKeyNames,
		mixed $default = NULL,
		bool $strict = FALSE,
		?string $cast = NULL): mixed;
}