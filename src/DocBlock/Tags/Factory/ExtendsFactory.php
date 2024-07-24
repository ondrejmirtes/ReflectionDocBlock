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
use phpDocumentor\Reflection\DocBlock\Tags\TemplateExtends;

/**
 * @internal This class is not part of the BC promise of this library.
 */
class ExtendsFactory implements PHPStanFactory
{
    private DescriptionFactory $descriptionFactory;
    private TypeResolver $typeResolver;

    public function __construct(TypeResolver $typeResolver, DescriptionFactory $descriptionFactory)
    {
        $this->descriptionFactory = $descriptionFactory;
        $this->typeResolver = $typeResolver;
    }

    public function create(PhpDocTagNode $node, Context $context): Tag
    {
        $tagValue = $node->value;
        Assert::isInstanceOf($tagValue, ExtendsTagValueNode::class);

        $description = $tagValue->getAttribute('description');
        if (is_string($description) === false) {
            $description = $tagValue->description;
        }

        $class = $node->name === '@extends' ? Extends_::class : TemplateExtends::class;

        return new $class(
            $this->typeResolver->createType($tagValue->type, $context),
            $this->descriptionFactory->create($tagValue->description, $context) 
        );
    }

    public function supports(PhpDocTagNode $node, Context $context): bool
    {
        return $node->value instanceof ExtendsTagValueNode && ($node->name === '@extends' || $node->name === '@template-extends');
    }
}
