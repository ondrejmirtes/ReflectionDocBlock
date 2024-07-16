<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link http://phpdoc.org
 */

namespace phpDocumentor\Reflection\DocBlock\Tags;

use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\DocBlock\Description;
use phpDocumentor\Reflection\DocBlock\Tags\TagWithType;

/**
 * Reflection class for a {@}implements tag in a Docblock.
 */
final class Implements_ extends TagWithType
{
    public function __construct(Type $type, ?Description $description = null)
    {
        $this->name        = 'implements';
        $this->type        = $type;
        $this->description = $description;
    }

    public static function create(string $body)
    {
        trigger_error(
            'Create using static factory is deprecated, this method should not be called directly
             by library consumers',
            E_USER_DEPRECATED
        );
    }

    public function __toString(): string
    {
        if ($this->description) {
            $description = $this->description->render();
        } else {
            $description = '';
        }

        $type = $this->type;

        return $type . ($description !== '' ? ' ' . $description : '');
    }
}
