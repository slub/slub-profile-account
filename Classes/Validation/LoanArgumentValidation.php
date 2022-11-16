<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-profile-account
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubProfileAccount\Validation;

class LoanArgumentValidation
{
    private array $validBarcodes;

    /**
     * @param array $arguments
     * @param array $loans
     * @return array|array[]
     */
    public function validateRenewalArguments(array $arguments, array $loans): array
    {
        if (count($arguments) === 0) {
            return [];
        }

        foreach ($arguments as $argument) {
            $this->validateBarcode((int)$argument, $loans);
        }

        return [
            'barcodes' => $this->validBarcodes
        ];
    }

    /**
     * Check that given barcode is a real barcode of mine and
     * it is renewable.
     *
     * @param int $barcode
     * @param array $loans
     * @return void
     */
    private function validateBarcode(int $barcode, array $loans): void
    {
        foreach ($loans as $loan) {
            if ((int)$loan['X_barcode'] === $barcode &&
                (bool)$loan['X_is_renewable'] === true
            ) {
                $this->validBarcodes[] = $barcode;
            }
        }
    }
}
