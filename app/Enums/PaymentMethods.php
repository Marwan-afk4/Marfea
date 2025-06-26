<?php

namespace App\Enums;

enum PaymentMethods : string
{

    case VodafoneCash = 'vodafone_cash';
    case InstaPay = 'insta_pay';
    case Tap = 'tap';


    public static function labels(): array
    {
        return [
            self::VodafoneCash->value => 'Vodafone Cash',
            self::InstaPay->value => 'Insta Pay',
            self::Tap->value => 'Tap',
        ];
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return self::labels()[$this->value];
    }
}
