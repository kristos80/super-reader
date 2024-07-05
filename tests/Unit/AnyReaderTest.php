<?php
declare(strict_types=1);

namespace Kristos80\SuperReader\Tests\Unit;

use Kristos80\SuperReader\SuperReaderInterface;

final class AnyReaderTest extends SuperReaderTester {

	/**
	 * @return string
	 */
	function getFrom(): string {
		return SuperReaderInterface::ANY_SUPER_GLOBAL;
	}

}