<?php


namespace App\Models\Master;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Supplier extends Model
{
   protected $table = '01_supplier';


   protected $fillable = [
       'kode_supplier',
       'nama',
       'telepon',
       'email',
       'alamat',
       'status',
   ];


   protected $casts = [
       'created_at' => 'datetime',
       'updated_at' => 'datetime',
   ];


   /**
    * Relasi ke Restock
    */
   public function restocks(): HasMany
   {
       return $this->hasMany(Restock::class, 'id_supplier');
   }


   /**
    * Scope untuk filter supplier aktif
    */
   public function scopeAktif($query)
   {
       return $query->where('status', 'aktif');
   }
}




