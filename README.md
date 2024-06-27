# 🔍 super-reader

The SuperReader package provides a robust and flexible way to read and manipulate superglobal variables in `PHP`. It allows for easy retrieval and comparison of superglobal values, supporting strict comparisons, type casting, and sanitization to ensure secure and reliable handling of input data.

---

## Work in Progress (WIP) — Do not use in production yet: ##

- It has not undergone extensive testing.
- Primarily intended for internal projects, subject to potential breaking changes without prior notice.
- There are likely many missing features.

---

[![Coverage Status](https://coveralls.io/repos/github/kristos80/super-reader/badge.svg?branch=master)](https://coveralls.io/github/kristos80/env-reader?branch=master) 
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fkristos80%2Fsuper-reader%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/kristos80/super-reader/master)

---

## Features
- Flexible Source Selection: Retrieve values from various `PHP` superglobals (`$_GET`, `$_POST`, `$_SERVER`, `$_ENV`, `$_COOKIE`, `$_SESSION`) or directly from `php://input`.
- Strict Comparisons: Perform case-sensitive or case-insensitive checks on keys.
- Type Casting: Automatically cast values to specified types (e.g., `array`, `object`, `string`, `integer`).
- Sanitization: Ensure values are properly sanitized to prevent XSS and other security issues.

---

## Installation
Install the package via Composer:

```ssh
composer require kristos80/super-reader
```

## Example Usage

```PHP
use Kristos80\SuperReader\SuperReader;

$superReader = new SuperReader();

// Set the source superglobal to $_POST
$superReader->from(SuperReader::POST);

// Retrieve a variable with optional strict comparison and type casting
$userInput = $superReader->get('user_input', 'default_value', true, 'string');

// Check if a superglobal value matches one of the possible values
$isAdmin = $superReader->equals('user_role', ['admin', 'superadmin'], true);

// Retrieve raw input from php://input and cast it to an array
$jsonInput = $superReader->getFromInput(SuperReader::PHP_INPUT, 'array');
```

## Class Reference

`SuperReader`

This final, read-only class implements the `SuperReaderInterface`.

## Methods

`from`

```PHP
public function from(string $from = self::GET): SuperReaderInterface
```

### Parameters:

- $from (string): The source superglobal to read from (default is $_GET).

Returns: (`SuperReaderInterface`): The current instance for method chaining.

`equals`

```PHP
public function equals(
  string|array $possibleEnvNames,
  mixed $possibleEnvValues,
  bool $strict = FALSE,
  ?string $cast = NULL
): bool
```

### Parameters:

- $possibleEnvNames (string|array): The environment variable name(s) to check.
- $possibleEnvValues (mixed): The value(s) to compare against.
- $strict (bool): Whether to perform a case-sensitive comparison in variable name(s).
- $cast (string|null): Optional type to cast the environment variable value to (e.g., 'array', 'object', 'string').

Returns: (bool): True if the environment variable value matches one of the possible values; otherwise, false.

`get`

```PHP
public function get(
  string|array $possibleEnvNames,
  mixed $default = NULL,
  bool $strict = FALSE,
  ?string $cast = NULL
): mixed
```

### Parameters:

- $possibleEnvNames (string|array): The environment variable name(s) to retrieve.
- $default (mixed|null): The default value to return if the environment variable is not set.
- $strict (bool): Whether to perform a case-sensitive search in variable name(s).
- $cast (string|null): Optional type to cast the environment variable value to (e.g., 'array', 'object', 'string').
  
Returns: (mixed): The value of the environment variable, cast to the specified type if provided, or the default value.

`getFromInput`

```PHP
public function getFromInput(
  string $input = self::PHP_INPUT,
  ?string $cast = NULL
): mixed
```

### Parameters:

- $input (string): The input stream to read from (default is `php://input`).
- $cast (string|null): Optional type to cast the input to (e.g., 'array', 'object').
  
Returns: (mixed): The raw input value, cast to the specified type if provided.

## Contributing
Feel free to contribute by submitting issues or pull requests. Ensure your code adheres to the project's coding standards and includes appropriate tests.
