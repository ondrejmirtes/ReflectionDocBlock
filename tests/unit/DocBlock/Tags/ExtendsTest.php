<?php

declare(strict_types=1);

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use PHPUnit\Framework\TestCase;

/**
 * @covers \phpDocumentor\Reflection\DocBlock\Tags\Extends_
 */
final class ExtendsTest extends TestCase
{
    public function testExtendsCreatedCorrectly(): void
    {
        $type = new Object_(new Fqsen('\\Type'));
        $fixture = new Extends_($type);
        $this->assertSame('extends', $fixture->getName());
        $this->assertSame($type, $fixture->getType());
    }

    public function testRendersCorrectly(): void
    {
        $type = new Object_(new Fqsen('\\Type'));
        $fixture = new Extends_($type);
        $this->assertSame('@extends \\Type', $fixture->render());
    }
}
