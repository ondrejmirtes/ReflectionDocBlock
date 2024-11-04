<?php

declare(strict_types=1);

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\Types\Mixed_;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \phpDocumentor\Reflection\DocBlock\Tags\Template
 * @covers ::<private>
 */
final class TemplateTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getTemplateName
     * @covers ::getBound
     * @covers ::getDefault
     */
    public function testTemplateCreatedCorrectly(): void
    {
        $fixture = new Template('myTemplate', new String_(), new Mixed_(), new Description(''));
        $this->assertSame('template', $fixture->getName());
        $this->assertSame('myTemplate', $fixture->getTemplateName());
        $this->assertEquals(new String_(), $fixture->getBound());
        $this->assertEquals(new Mixed_(), $fixture->getDefault());
    }

    public function testRendersCorrectly(): void
    {
        $fixture = new Template('myTemplate', new String_(), null, new Description(''));
        $this->assertSame('@template myTemplate of string', $fixture->render());
    }
}
