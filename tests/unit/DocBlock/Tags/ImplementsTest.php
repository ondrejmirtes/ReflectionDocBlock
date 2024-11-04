<?php

declare(strict_types=1);

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use PHPUnit\Framework\TestCase;

/**
 * @covers \phpDocumentor\Reflection\DocBlock\Tags\Implements_
 */
final class ImplementsTest extends TestCase
{
    public function testCreatedCorrectly(): void
    {
        $type = new Object_(new Fqsen('\\Type'));
        $fixture = new Implements_($type);
        $this->assertSame('implements', $fixture->getName());
        $this->assertSame($type, $fixture->getType());
    }

    public function testRendersCorrectly(): void
    {
        $type = new Object_(new Fqsen('\\Type'));
        $fixture = new Implements_($type);
        $this->assertSame('@implements \\Type', $fixture->render());
    }
}
