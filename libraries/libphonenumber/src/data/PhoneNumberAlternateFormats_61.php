<?php

/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

declare(strict_types=1);

namespace libphonenumber\data;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneMetadata;

/**
 * @internal
 */
class PhoneNumberAlternateFormats_61 extends PhoneMetadata
{
    protected const ID = '';
    protected const COUNTRY_CODE = 61;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{4})(\d{2})(\d{2})(\d{2})')
                ->setFormat('$1 $2 $3 $4')
                ->setLeadingDigitsPattern([])
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{4})(\d{6})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern([])
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{3})(\d{3})')
                ->setFormat('$1 $2 $3 $4')
                ->setLeadingDigitsPattern([])
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{8})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['[2378]'])
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
    }
}
