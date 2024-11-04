<?php

declare(strict_types=1);

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use PHPUnit\Framework\TestCase;

/**
 * @covers \phpDocumentor\Reflection\DocBlock\Tags\TemplateImplements
 */
final class TemplateImplementsTest extends TestCase
{
    public function testCreatedCorrectly(): void
    {
        $type = new Object_(new Fqsen('\\Type'));
        $fixture = new TemplateImplements($type);
        $this->assertSame('template-implements', $fixture->getName());
        $this->assertSame($type, $fixture->getType());
    }

    public function testRendersCorrectly(): void
    {
        $type = new Object_(new Fqsen('\\Type'));
        $fixture = new TemplateImplements($type);
        $this->assertSame('@template-implements \\Type', $fixture->render());
    }
}
