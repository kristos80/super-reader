<?php
declare(strict_types=1);

namespace Kristos80\SuperReader\Tests\Unit;

use Kristos80\SuperReader\SuperReader;
use Kristos80\SuperReader\Tests\TestBase;
use Kristos80\SuperReader\SuperReaderInterface;

abstract class SuperReaderTester extends TestBase {

	/**
	 * @var SuperReader
	 */
	protected SuperReader $superReader;

	/**
	 * @return void
	 */
	public function testEqualityArrayToArray(): void {
		$true = $this->superReader->equals(["{$this->getPrefix()}TEST_VARIABLE"], ["test_value"], TRUE);
		$this->assertTrue($true);

		$false = $this->superReader->equals(["{$this->getPrefix()}test_variable"], ["test_value"], TRUE);
		$this->assertFalse($false);

		$true = $this->superReader->equals(["{$this->getPrefix()}TEST_VARIABLE"], ["test_value"]);
		$this->assertTrue($true);

		$true = $this->superReader->equals(["{$this->getPrefix()}test_variable"], ["test_value"]);
		$this->assertTrue($true);

		$false = $this->superReader->equals(["{$this->getPrefix()}TEST_VARIABLE"], ["no_value"], TRUE);
		$this->assertFalse($false);

		$false = $this->superReader->equals(["{$this->getPrefix()}test_variable"], ["no_value"], TRUE);
		$this->assertFalse($false);

		$false = $this->superReader->equals(["{$this->getPrefix()}TEST_VARIABLE"], ["no_value"]);
		$this->assertFalse($false);

		$false = $this->superReader->equals(["{$this->getPrefix()}test_variable"], ["no_value"]);
		$this->assertFalse($false);
	}

	/**
	 * @return string
	 */
	protected function getPrefix(): string {
		return ($this->getFrom() !== SuperReaderInterface::ENV && $this->getFrom() !== SuperReaderInterface::ANY_SUPER_GLOBAL) ?
			strtoupper($this->getFrom()) . "_" : "";
	}

	/**
	 * @return string
	 */
	abstract function getFrom(): string;

	/**
	 * @return void
	 */
	public function testEqualityArrayToString(): void {
		$true = $this->superReader->equals(["{$this->getPrefix()}TEST_VARIABLE"], "test_value", TRUE);
		$this->assertTrue($true);

		$false = $this->superReader->equals(["{$this->getPrefix()}test_variable"], "test_value", TRUE);
		$this->assertFalse($false);

		$true = $this->superReader->equals(["{$this->getPrefix()}TEST_VARIABLE"], "test_value");
		$this->assertTrue($true);

		$true = $this->superReader->equals(["{$this->getPrefix()}test_variable"], "test_value");
		$this->assertTrue($true);

		$false = $this->superReader->equals(["{$this->getPrefix()}TEST_VARIABLE"], "no_value", TRUE);
		$this->assertFalse($false);

		$false = $this->superReader->equals(["{$this->getPrefix()}test_variable"], "no_value", TRUE);
		$this->assertFalse($false);

		$false = $this->superReader->equals(["{$this->getPrefix()}TEST_VARIABLE"], "no_value");
		$this->assertFalse($false);

		$false = $this->superReader->equals(["{$this->getPrefix()}test_variable"], "no_value");
		$this->assertFalse($false);
	}

	/**
	 * @return void
	 */
	public function testFull(): void {
		$this->assertIsArray($this->superReader->getFull());
	}

	/**
	 * @return void
	 */
	public function testEqualityStringToArray(): void {
		$true = $this->superReader->equals("{$this->getPrefix()}TEST_VARIABLE", ["test_value"], TRUE);
		$this->assertTrue($true);

		$false = $this->superReader->equals("{$this->getPrefix()}test_variable", ["test_value"], TRUE);
		$this->assertFalse($false);

		$true = $this->superReader->equals("{$this->getPrefix()}TEST_VARIABLE", ["test_value"]);
		$this->assertTrue($true);

		$true = $this->superReader->equals("{$this->getPrefix()}test_variable", ["test_value"]);
		$this->assertTrue($true);

		$false = $this->superReader->equals("{$this->getPrefix()}TEST_VARIABLE", ["no_value"], TRUE);
		$this->assertFalse($false);

		$false = $this->superReader->equals("{$this->getPrefix()}test_variable", ["no_value"], TRUE);
		$this->assertFalse($false);

		$false = $this->superReader->equals("{$this->getPrefix()}TEST_VARIABLE", ["no_value"]);
		$this->assertFalse($false);

		$false = $this->superReader->equals("{$this->getPrefix()}test_variable", ["no_value"]);
		$this->assertFalse($false);
	}

	/**
	 * @return void
	 */
	public function testEqualityStringToString(): void {
		$true = $this->superReader->equals("{$this->getPrefix()}TEST_VARIABLE", "test_value", TRUE);
		$this->assertTrue($true);

		$false = $this->superReader->equals("{$this->getPrefix()}test_variable", "test_value", TRUE);
		$this->assertFalse($false);

		$true = $this->superReader->equals("{$this->getPrefix()}TEST_VARIABLE", "test_value");
		$this->assertTrue($true);

		$true = $this->superReader->equals("{$this->getPrefix()}test_variable", "test_value");
		$this->assertTrue($true);

		$false = $this->superReader->equals("{$this->getPrefix()}TEST_VARIABLE", "no_value", TRUE);
		$this->assertFalse($false);

		$false = $this->superReader->equals("{$this->getPrefix()}test_variable", "no_value", TRUE);
		$this->assertFalse($false);

		$false = $this->superReader->equals("{$this->getPrefix()}TEST_VARIABLE", "no_value");
		$this->assertFalse($false);

		$false = $this->superReader->equals("{$this->getPrefix()}test_variable", "no_value");
		$this->assertFalse($false);
	}

	/**
	 * @return void
	 */
	public function testGetString(): void {
		$value = $this->superReader->get("{$this->getPrefix()}TEST_VARIABLE", NULL, TRUE);
		$this->assertEquals("test_value", $value);

		$value = $this->superReader->get("{$this->getPrefix()}test_variable", NULL, TRUE);
		$this->assertNotEquals("test_value", $value);

		$value = $this->superReader->get("{$this->getPrefix()}TEST_VARIABLE");
		$this->assertEquals("test_value", $value);

		$value = $this->superReader->get("{$this->getPrefix()}test_variable");
		$this->assertEquals("test_value", $value);
	}

	/**
	 * @return void
	 */
	public function testGetArray(): void {
		$value = $this->superReader->get(["{$this->getPrefix()}TEST_VARIABLE"], NULL, TRUE);
		$this->assertEquals("test_value", $value);

		$value = $this->superReader->get(["{$this->getPrefix()}test_variable"], NULL, TRUE);
		$this->assertNotEquals("test_value", $value);

		$value = $this->superReader->get(["{$this->getPrefix()}TEST_VARIABLE"]);
		$this->assertEquals("test_value", $value);

		$value = $this->superReader->get(["{$this->getPrefix()}test_variable"]);
		$this->assertEquals("test_value", $value);
	}

	/**
	 * @return void
	 */
	public function testFallbackValue(): void {
		$fallbackValue = $this->superReader->get("{$this->getPrefix()}NON_EXISTING", NULL, TRUE);
		$this->assertNull($fallbackValue);

		$fallbackValue = $this->superReader->get(["{$this->getPrefix()}NON_EXISTING"], NULL, TRUE);
		$this->assertNull($fallbackValue);

		$fallbackValue = $this->superReader->get("{$this->getPrefix()}NON_EXISTING");
		$this->assertNull($fallbackValue);

		$fallbackValue = $this->superReader->get(["{$this->getPrefix()}NON_EXISTING"]);
		$this->assertNull($fallbackValue);

		$fallbackValue = $this->superReader->get("{$this->getPrefix()}NON_EXISTING", "A", TRUE);
		$this->assertEquals("A", $fallbackValue);

		$fallbackValue = $this->superReader->get(["{$this->getPrefix()}NON_EXISTING"], "A", TRUE);
		$this->assertEquals("A", $fallbackValue);

		$fallbackValue = $this->superReader->get("{$this->getPrefix()}NON_EXISTING", "A");
		$this->assertEquals("A", $fallbackValue);

		$fallbackValue = $this->superReader->get(["{$this->getPrefix()}NON_EXISTING"], "A");
		$this->assertEquals("A", $fallbackValue);
	}

	/**
	 * @return void
	 */
	public function testCasting(): void {
		$string = $this->superReader->get("{$this->getPrefix()}TEST_VARIABLE", NULL, FALSE, "string");
		$this->assertIsString($string);

		$bool = $this->superReader->get("{$this->getPrefix()}TEST_BOOL_VARIABLE", NULL, FALSE, "bool");
		$this->assertIsBool($bool);

		$int = $this->superReader->get("{$this->getPrefix()}TEST_INT_VARIABLE", NULL, FALSE, "int");
		$this->assertIsInt($int);

		$float = $this->superReader->get("{$this->getPrefix()}TEST_FLOAT_VARIABLE", NULL, FALSE, "float");
		$this->assertIsFloat($float);

		$null = $this->superReader->get("{$this->getPrefix()}TEST_NULL_VARIABLE", NULL, FALSE, "null");
		$this->assertNull($null);

		$array = $this->superReader->get("{$this->getPrefix()}TEST_ARRAY_VARIABLE", NULL, FALSE, "array");
		$this->assertEquals([
			1,
			2,
			3,
		], $array);

		$object = $this->superReader->get("{$this->getPrefix()}TEST_OBJECT_VARIABLE", NULL, FALSE, "object");
		$this->assertEquals((object) ["foo" => "dummy"], $object);
	}

	/**
	 * @return void
	 */
	protected function setUp(): void {
		parent::setUp();
		$this->superReader = new SuperReader();
		$this->superReader->from($this->getFrom());

		if($this->getFrom() === SuperReaderInterface::GET) {
			$_GET = [];
			$_GET = $this->setValues($_ENV);
		}

		if($this->getFrom() === SuperReaderInterface::POST) {
			$_POST = [];
			$_POST = $this->setValues($_ENV);
		}

		if($this->getFrom() === SuperReaderInterface::SERVER) {
			$server = $this->setValues($_ENV);
			$_SERVER = array_merge($server, $_SERVER);
		}

		if($this->getFrom() === SuperReaderInterface::COOKIE) {
			$cookie = $this->setValues($_ENV);
			$_COOKIE = array_merge($cookie, $_COOKIE);
		}

		if($this->getFrom() === SuperReaderInterface::SESSION) {
			$session = $this->setValues($_ENV);
			$_SESSION = array_merge($session, $_SESSION ?? []);
		}

		if($this->getFrom() === "array") {
			$array = $this->setValues($_ENV);
			$this->superReader->from($array);
		}
	}

	/**
	 * @param array $super
	 * @return array
	 */
	protected function setValues(array $super): array {
		$newSuper = [];
		foreach($super as $key => $value) {
			$newKey = "{$this->getPrefix()}$key";
			$newSuper[$newKey] = $value;
		}

		return $newSuper;
	}

}