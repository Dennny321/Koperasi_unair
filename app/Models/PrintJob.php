<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintJob extends Model
{
    protected $fillable = [
        'id_transaksi',
        'no_nota',
        'kasir_id',
        'status',
        'escpos_base64',
        'printer_target',
        'printed_at',
        'error_message',
    ];

    protected $casts = [
        'printed_at' => 'datetime',
    ];

    public function transaksi()
    {
        return $this->belongsTo(\App\Models\Data\Transaksi::class, 'id_transaksi');
    }

    // ── Scopes ──────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForPrinter($query, ?string $printerTarget)
    {
        if ($printerTarget) {
            return $query->where(function ($q) use ($printerTarget) {
                $q->where('printer_target', $printerTarget)
                  ->orWhereNull('printer_target');
            });
        }
        return $query;
    }
}