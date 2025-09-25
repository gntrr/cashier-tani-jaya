<?php

namespace App\Helpers;

/**
 * Tempat deklarasi konstanta enum sederhana (bisa diganti native PHP enum jika diperlukan nanti)
 */
class EnumHelper
{
    // Status transaksi penjualan (contoh proyeksi ke depan)
    public const PENJUALAN_DRAFT = 'draft';
    public const PENJUALAN_SELESAI = 'selesai';
    public const PENJUALAN_BATAL = 'batal';

    // Status pembelian
    public const PEMBELIAN_DRAFT = 'draft';
    public const PEMBELIAN_SELESAI = 'selesai';
    public const PEMBELIAN_BATAL = 'batal';

    // Mapping label (untuk badge di view)
    public static function label(string $key): string
    {
        return [
            self::PENJUALAN_DRAFT => 'Draft',
            self::PENJUALAN_SELESAI => 'Selesai',
            self::PENJUALAN_BATAL => 'Dibatalkan',
            self::PEMBELIAN_DRAFT => 'Draft',
            self::PEMBELIAN_SELESAI => 'Selesai',
            self::PEMBELIAN_BATAL => 'Dibatalkan',
        ][$key] ?? $key;
    }

    public static function badgeClass(string $key): string
    {
        return [
            self::PENJUALAN_DRAFT => 'badge text-bg-secondary',
            self::PENJUALAN_SELESAI => 'badge text-bg-success',
            self::PENJUALAN_BATAL => 'badge text-bg-danger',
            self::PEMBELIAN_DRAFT => 'badge text-bg-secondary',
            self::PEMBELIAN_SELESAI => 'badge text-bg-primary',
            self::PEMBELIAN_BATAL => 'badge text-bg-danger',
        ][$key] ?? 'badge text-bg-light';
    }
}
