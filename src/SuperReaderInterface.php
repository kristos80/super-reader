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
	public const STDIN = "stdin";

	/**
	 *
	 */
	public const ANY_SUPER_GLOBAL = "any_super_global";

	/**
	 *
	 */
	public const CAST_INT = "integer";

	/**
	 *
	 */
	public const CAST_FLOAT = "float";

	/**
	 *
	 */
	public const CAST_STRING = "string";

	/**
	 *
	 */
	public const CAST_BOOLEAN = "boolean";

	/**
	 *
	 */
	public const CAST_ARRAY = "array";

	/**
	 *
	 */
	public const CAST_OBJECT = "object";

	/**
	 * @param string|iterable $from
	 * @return self
	 */
	public function from(string|iterable $from = self::GET): self;

	/**
	 * @SuppressWarnings("BooleanArgumentFlag")
	 * @param string|array $possibleKeyNames
	 * @param array $possibleValues
	 * @param bool $strict
	 * @return bool
	 */
	public function equals(string|array $possibleKeyNames, mixed $possibleValues, bool $strict = FALSE): bool;

	/**
	 * @return iterable
	 */
	public function getFull(): iterable;

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