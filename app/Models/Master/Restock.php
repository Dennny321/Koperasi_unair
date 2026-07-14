<?php


namespace App\Models\Master;


use App\Models\Data\RestockDetail;
use App\Models\Master\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Restock extends Model
{
   protected $table = '01_restock';


   protected $fillable = [
       'kode_restock',
       'tanggal_restock',
       'id_supplier',
       'id_user',
       'keterangan',
       'total_biaya',
       'status',
   ];


   protected $casts = [
       'tanggal_restock' => 'date',
       'total_biaya' => 'decimal:2',
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
   ];


   /**
    * Relasi ke Supplier
    */
   public function supplier(): BelongsTo
   {
       return $this->belongsTo(Supplier::class, 'id_supplier');
   }


   /**
    * Relasi ke User
    */
   public function user(): BelongsTo
   {
       return $this->belongsTo(User::class, 'id_user');
   }


   /**
    * Relasi ke Detail Restock
    */
   public function details(): HasMany
   {
       return $this->hasMany(RestockDetail::class, 'id_restock');
   }


   /**
    * Scope untuk filter berdasarkan status
    */
   public function scopeByStatus($query, $status)
   {
       return $query->where('status', $status);
   }


   /**
    * Scope untuk filter berdasarkan tanggal
    */
   public function scopeByPeriode($query, $startDate, $endDate)
   {
       return $query->whereBetween('tanggal_restock', [$startDate, $endDate]);
   }


   /**
    * Accessor untuk format total biaya
    */
   public function getTotalBiayaFormattedAttribute(): string
   {
       return 'Rp ' . number_format($this->total_biaya, 2, ',', '.');
   }


   /**
    * Generate kode restock otomatis
    */
   public static function generateKodeRestock(): string
   {
       $date = now()->format('Ymd');
       $lastRestock = self::whereDate('created_at', now())
                         ->latest()
                         ->first();


       $number = $lastRestock ? (int) substr($lastRestock->kode_restock, -4) + 1 : 1;


       return 'RST-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
   }
}






