<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection\DocBlock\Tags\Factory;

use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use function str_repeat;
use function strlen;

class MethodParameterFactory
{
    /**
     * Formats the given default value to a string-able mixin
     */
    public function format($defaultValue): string
    {
        if (method_exists($this, $method = 'format'.ucfirst(gettype($defaultValue)))) {
            return ' = ' . $this->{$method}($defaultValue);
        }
        return '';
    }

    protected function formatDouble(float $defaultValue): string
    {
        return var_export($defaultValue, true);
    }

    protected function formatNull($defaultValue): string
    {
        return 'null';
    }

    protected function formatInteger(int $defaultValue): string
    {
        return var_export($defaultValue, true);
    }

    protected function formatString(string $defaultValue): string
    {
        return var_export($defaultValue, true);
    }

    protected function formatBoolean(bool $defaultValue): string
    {
        return var_export($defaultValue, true);
    }

    protected function formatArray(array $defaultValue): string
    {
        $formatedValue = '[';

        foreach ($defaultValue as $key => $value) {
            if (method_exists($this, $method = 'format'.ucfirst(gettype($value)))) {
                $formatedValue .= $this->{$method}($value);

                if ($key !== array_key_last($defaultValue)) {
                    $formatedValue .= ',';
                }
            }
        }

        $formatedValue .= ']';

        return $formatedValue;
    }

    protected function formatObject(object $defaultValue): string
    {
        return 'new '. get_class($defaultValue). '()';
    }
}
