<?php

namespace App\Enums;

enum ComplaintStatus: string
{
    case Received = 'received';
    case Verification = 'verification';
    case ClarificationRequested = 'clarification_requested';
    case Dispatched = 'dispatched';
    case InHandling = 'in_handling';
    case Resolved = 'resolved';
    case Duplicate = 'duplicate';
    case Invalid = 'invalid';

    public function label(): string
    {
        return match ($this) {
            self::Received => 'Diterima',
            self::Verification => 'Verifikasi',
            self::ClarificationRequested => 'Menunggu Klarifikasi',
            self::Dispatched => 'Didisposisikan',
            self::InHandling => 'Dalam Penanganan',
            self::Resolved => 'Selesai / Teratasi',
            self::Duplicate => 'Duplikat',
            self::Invalid => 'Tidak Valid',
        };
    }
}
