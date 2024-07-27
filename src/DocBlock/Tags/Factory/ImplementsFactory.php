<?php

declare(strict_types=1);

namespace phpDocumentor\Reflection\DocBlock\Tags\Factory;

use Webmozart\Assert\Assert;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use phpDocumentor\Reflection\DocBlock\Tags\Implements_;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use PHPStan\PhpDocParser\Ast\PhpDoc\ImplementsTagValueNode;

/**
 * @internal This class is not part of the BC promise of this library.
 */
final class ImplementsFactory extends AbstractImplementsFactory
{
    public function __construct(TypeResolver $typeResolver, DescriptionFactory $descriptionFactory)
    {
        parent::__construct($typeResolver, $descriptionFactory);
        $this->tagName = '@implements';
    }

    public function create(PhpDocTagNode $node, Context $context): Tag
    {
        $tagValue = $node->value;
        Assert::isInstanceOf($tagValue, ImplementsTagValueNode::class);

        $description = $tagValue->getAttribute('description');
        if (is_string($description) === false) {
            $description = $tagValue->description;
        }

        return new Implements_(
            $this->typeResolver->createType($tagValue->type, $context),
            $this->descriptionFactory->create($description, $context) 
        );
    }
}
