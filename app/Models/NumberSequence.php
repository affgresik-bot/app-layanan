<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class NumberSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'period',
        'last_number',
    ];

    protected function casts(): array
    {
        return [
            'last_number' => 'integer',
        ];
    }

    /**
     * Atomically generate the next sequential number with row locking.
     */
    public static function next(string $prefix, ?string $period = null, int $digits = 5): string
    {
        $period = $period ?? Carbon::now()->format('Ym');

        return DB::transaction(function () use ($prefix, $period, $digits) {
            $sequence = static::where('prefix', $prefix)
                ->where('period', $period)
                ->lockForUpdate()
                ->first();

            if (! $sequence) {
                $sequence = static::create([
                    'prefix' => $prefix,
                    'period' => $period,
                    'last_number' => 1,
                ]);
                $nextNumber = 1;
            } else {
                $sequence->increment('last_number');
                $nextNumber = $sequence->last_number;
            }

            return sprintf('%s-%s-%s', $prefix, $period, str_pad((string) $nextNumber, $digits, '0', STR_PAD_LEFT));
        });
    }
}
