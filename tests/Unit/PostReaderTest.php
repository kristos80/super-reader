<?php
declare(strict_types=1);

namespace Kristos80\SuperReader\Tests\Unit;

use Kristos80\SuperReader\SuperReaderInterface;

final class PostReaderTest extends SuperReaderTester {

	/**
	 * @return string
	 */
	function getFrom(): string {
		return SuperReaderInterface::POST;
	}

}