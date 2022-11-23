<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Validation;

class ReserveArgumentValidation
{
    private array $validLabels = [];

    /**
     * @param array $arguments
     * @param array $reserve
     * @return array|array[]
     */
    public function validateDeleteArguments(array $arguments, array $reserve): array
    {
        if (count($arguments) === 0) {
            return [];
        }

        foreach ($arguments as $argument) {
            $this->validateLabel((int)$argument, $reserve);
        }

        return $this->validLabels;
    }

    /**
     * Check that given label is a real label of mine.
     *
     * @param int $label
     * @param array $reserve
     */
    private function validateLabel(int $label, array $reserve): void
    {
        foreach ($reserve as $reserveItem) {
            if ((int)$reserveItem['label'] === $label) {
                $this->validLabels[] = [
                    'label' => $label,
                    'queueNumber' => $reserveItem['X_queue_number'],
                ];
            }
        }
    }
}
