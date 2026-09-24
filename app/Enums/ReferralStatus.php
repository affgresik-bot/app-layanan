<?php

namespace App\Enums;

enum ReferralStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Accepted = 'accepted';
    case InService = 'in_service';
    case Completed = 'completed';
    case Declined = 'declined';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draf',
            self::Sent => 'Terkirim',
            self::Accepted => 'Diterima Lembaga',
            self::InService => 'Dalam Pelayanan Lembaga',
            self::Completed => 'Selesai',
            self::Declined => 'Ditolak Lembaga',
            self::Cancelled => 'Dibatalkan',
        };
    }
}
