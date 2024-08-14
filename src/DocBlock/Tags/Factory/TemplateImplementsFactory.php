<?php

declare(strict_types=1);

namespace phpDocumentor\Reflection\DocBlock\Tags\Factory;

use Webmozart\Assert\Assert;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use PHPStan\PhpDocParser\Ast\PhpDoc\ImplementsTagValueNode;
use phpDocumentor\Reflection\DocBlock\Tags\TemplateImplements;

/**
 * @internal This class is not part of the BC promise of this library.
 */
final class TemplateImplementsFactory extends AbstractImplementsFactory
{
    public function __construct(TypeResolver $typeResolver, DescriptionFactory $descriptionFactory)
    {
        parent::__construct($typeResolver, $descriptionFactory);
        $this->tagName = '@template-implements';
    }

    public function create(PhpDocTagNode $node, Context $context): Tag
    {
        $tagValue = $node->value;
        Assert::isInstanceOf($tagValue, ImplementsTagValueNode::class);

        $description = $tagValue->getAttribute('description');
        if (is_string($description) === false) {
            $description = $tagValue->description;
        }

        return new TemplateImplements(
            $this->typeResolver->createType($tagValue->type, $context),
            $this->descriptionFactory->create($description, $context) 
        );
    }
}
