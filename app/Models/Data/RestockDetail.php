<?php


namespace App\Models\Data;


use App\Models\Master\Produk;
use App\Models\Master\Restock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class RestockDetail extends Model
{
   protected $table = '02_restock_detail';


   protected $fillable = [
       'id_restock',
       'id_produk',
       'jumlah',
       'harga_beli',
       'subtotal',
       'catatan',
   ];


   protected $casts = [
       'jumlah' => 'integer',
       'harga_beli' => 'decimal:2',
       'subtotal' => 'decimal:2',
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
   ];


   /**
    * Relasi ke Restock Header
    */
   public function restock(): BelongsTo
   {
       return $this->belongsTo(Restock::class, 'id_restock');
   }


   /**
    * Relasi ke Produk
    */
   public function produk(): BelongsTo
   {
       return $this->belongsTo(Produk::class, 'id_produk');
   }


   /**
    * Accessor untuk format harga beli
    */
   public function getHargaBeliFormattedAttribute(): string
   {
       return 'Rp ' . number_format($this->harga_beli, 2, ',', '.');
   }


   /**
    * Accessor untuk format subtotal
    */
   public function getSubtotalFormattedAttribute(): string
   {
       return 'Rp ' . number_format($this->subtotal, 2, ',', '.');
   }
}






