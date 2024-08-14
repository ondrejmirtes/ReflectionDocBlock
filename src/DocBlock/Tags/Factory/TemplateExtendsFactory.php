<?php

declare(strict_types=1);

namespace phpDocumentor\Reflection\DocBlock\Tags\Factory;

use Webmozart\Assert\Assert;
use phpDocumentor\Reflection\DocBlock\Tag;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\ExtendsTagValueNode;
use phpDocumentor\Reflection\DocBlock\DescriptionFactory;
use phpDocumentor\Reflection\DocBlock\Tags\TemplateExtends;

/**
 * @internal This class is not part of the BC promise of this library.
 */
final class TemplateExtendsFactory extends AbstractExtendsFactory
{
    public function __construct(TypeResolver $typeResolver, DescriptionFactory $descriptionFactory)
    {
        parent::__construct($typeResolver, $descriptionFactory);
        $this->tagName = '@template-extends';
    }

    public function create(PhpDocTagNode $node, Context $context): Tag
    {
        $tagValue = $node->value;
        Assert::isInstanceOf($tagValue, ExtendsTagValueNode::class);

        $description = $tagValue->getAttribute('description');
        if (is_string($description) === false) {
            $description = $tagValue->description;
        }

        return new TemplateExtends(
            $this->typeResolver->createType($tagValue->type, $context),
            $this->descriptionFactory->create($description, $context) 
        );
    }
}
