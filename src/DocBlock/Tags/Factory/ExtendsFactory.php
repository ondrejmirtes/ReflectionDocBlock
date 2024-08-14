<?php

declare(strict_types=1);

namespace phpDocumentor\Reflection\DocBlock\Tags\Factory;

use Webmozart\Assert\Assert;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use phpDocumentor\Reflection\DocBlock\Tags\Extends_;
use PHPStan\PhpDocParser\Ast\PhpDoc\ExtendsTagValueNode;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;

/**
 * @internal This class is not part of the BC promise of this library.
 */
final class ExtendsFactory extends AbstractExtendsFactory
{
    public function __construct(TypeResolver $typeResolver, DescriptionFactory $descriptionFactory)
    {
        parent::__construct($typeResolver, $descriptionFactory);
        $this->tagName = '@extends';
    }

    public function create(PhpDocTagNode $node, Context $context): Tag
    {
        $tagValue = $node->value;
        Assert::isInstanceOf($tagValue, ExtendsTagValueNode::class);

        $description = $tagValue->getAttribute('description');
        if (is_string($description) === false) {
            $description = $tagValue->description;
        }

        return new Extends_(
            $this->typeResolver->createType($tagValue->type, $context),
            $this->descriptionFactory->create($description, $context) 
        );
    }
}
