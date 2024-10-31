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

/**
 * @internal This class is not part of the BC promise of this library.
 */
final class MethodParameterFactory
{
    /**
     * Formats the given default value to a string-able mixin
     *
     * @param mixed $defaultValue
     * @return string
     */
    public function format($defaultValue): string
    {
        if (method_exists($this, $method = 'format'.ucfirst(gettype($defaultValue)))) {
            return ' = ' . $this->{$method}($defaultValue);
        }
        return '';
    }

    private function formatDouble(float $defaultValue): string
    {
        return var_export($defaultValue, true);
    }

    /**
     * @param mixed $defaultValue
     * @return string
     */
    private function formatNull($defaultValue): string
    {
        return 'null';
    }

    private function formatInteger(int $defaultValue): string
    {
        return var_export($defaultValue, true);
    }

    private function formatString(string $defaultValue): string
    {
        return var_export($defaultValue, true);
    }

    private function formatBoolean(bool $defaultValue): string
    {
        return var_export($defaultValue, true);
    }

    /**
     * @param array<array, null, int, float, bool, string, object> $defaultValue
     * @return string
     */
    private function formatArray(array $defaultValue): string
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

    private function formatObject(object $defaultValue): string
    {
        return 'new '. get_class($defaultValue). '()';
    }
}
