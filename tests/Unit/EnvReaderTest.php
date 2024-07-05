<?php
declare(strict_types=1);

namespace Kristos80\SuperReader\Tests\Unit;

use Kristos80\SuperReader\SuperReaderInterface;

final class EnvReaderTest extends SuperReaderTester {

	/**
	 * @return string
	 */
	function getFrom(): string {
		return SuperReaderInterface::ENV;
	}

	/**
	 * @return void
	 */
	public function testUnsanitizedText(): void {
		$sanitizedText = $this->superReader->get("TEST_UNSANITIZED_VALUE", NULL, TRUE, "array");

		$this->assertNotEquals(["<div onmouseover=\"alert('<?php echo htmlspecialchars(\$xss) ?>')\">"], $sanitizedText);
	}

}