<?php
declare(strict_types=1);

namespace Kristos80\SuperReader\Tests\Unit;

final class PostReaderTest extends SuperReaderTester {

	/**
	 * @return void
	 */
	public function testRaw(): void {
		$input = __DIR__ . "/../input.txt";
		file_put_contents($input, json_encode($data = ["foo" => "dummy"]));

		$array = $this->superReader->getFromInput($input, "array");
		$object = $this->superReader->getFromInput($input, "object");

		$this->assertEquals($data, $array);
		$this->assertEquals((object) $data, $object);

		$this->assertNull($this->superReader->getFromInput("php://input"));

		unlink($input);
	}

	/**
	 * @return string
	 */
	function getFrom(): string {
		return "post";
	}

}