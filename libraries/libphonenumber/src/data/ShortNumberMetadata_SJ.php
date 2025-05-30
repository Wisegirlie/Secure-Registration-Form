<?php

/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

declare(strict_types=1);

namespace libphonenumber\data;

use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;

/**
 * @internal
 */
class ShortNumberMetadata_SJ extends PhoneMetadata
{
    protected const ID = 'SJ';
    protected const COUNTRY_CODE = 0;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[01]\d\d(?:\d{2})?')
            ->setPossibleLength([3, 5]);
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('11[023]')
            ->setExampleNumber('110')
            ->setPossibleLength([3]);
        $this->emergency = (new PhoneNumberDesc())
            ->setNationalNumberPattern('11[023]')
            ->setExampleNumber('110')
            ->setPossibleLength([3]);
        $this->short_code = (new PhoneNumberDesc())
            ->setNationalNumberPattern('04\d{3}|11[023]')
            ->setExampleNumber('110');
        $this->standard_rate = PhoneNumberDesc::empty();
        $this->carrierSpecific = PhoneNumberDesc::empty();
        $this->smsServices = (new PhoneNumberDesc())
            ->setNationalNumberPattern('04\d{3}')
            ->setExampleNumber('04000')
            ->setPossibleLength([5]);
    }
}
