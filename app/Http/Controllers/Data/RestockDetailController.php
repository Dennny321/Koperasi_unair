<?php


namespace App\Http\Controllers\Data;


use App\Http\Controllers\Controller;
use App\Models\Data\RestockDetail;
use App\Models\Master\Produk;
use Illuminate\Http\Request;


class RestockDetailController extends Controller
{
   /**
    * Display a listing of restock details by product
    */
   public function index(Request $request)
   {
       $query = RestockDetail::with(['restock.supplier', 'restock.user', 'produk.kategori']);


       // Filter berdasarkan produk
       if ($request->filled('produk')) {
           $query->where('id_produk', $request->produk);
       }


       // Filter berdasarkan periode
       if ($request->filled('start_date') && $request->filled('end_date')) {
           $query->whereHas('restock', function($q) use ($request) {
               $q->whereBetween('tanggal_restock', [$request->start_date, $request->end_date]);
           });
       }


       // Filter hanya restock yang selesai
       $query->whereHas('restock', function($q) {
           $q->where('status', 'selesai');
       });


       // Search
       if ($request->filled('search')) {
           $search = $request->search;
           $query->whereHas('produk', function($q) use ($search) {
               $q->where('nama', 'like', "%{$search}%")
                 ->orWhere('kode_produk', 'like', "%{$search}%");
           });
       }


       $details = $query->latest()->paginate(15);
       $produks = Produk::aktif()->get();


       return view('data.restock-detail.index', compact('details', 'produks'));
   }


   /**
    * Display restock history for specific product
    */
   public function historyByProduct(Produk $produk)
   {
       $details = RestockDetail::with(['restock.supplier', 'restock.user'])
           ->where('id_produk', $produk->id)
           ->whereHas('restock', function($q) {
               $q->where('status', 'selesai');
           })
           ->latest()
           ->paginate(15);


       return view('data.restock-detail.history', compact('produk', 'details'));
   }


   /**
    * Get restock statistics for product
    */
   public function statistics(Request $request)
   {
       $startDate = $request->get('start_date', now()->subMonths(6));
       $endDate = $request->get('end_date', now());


       $statistics = RestockDetail::selectRaw('
               id_produk,
               COUNT(*) as total_restock,
               SUM(jumlah) as total_quantity,
               AVG(harga_beli) as avg_price,
               MIN(harga_beli) as min_price,
               MAX(harga_beli) as max_price,
               SUM(subtotal) as total_cost
           ')
           ->whereHas('restock', function($q) use ($startDate, $endDate) {
               $q->where('status', 'selesai')
                 ->whereBetween('tanggal_restock', [$startDate, $endDate]);
           })
           ->with('produk:id,kode_produk,nama,satuan')
           ->groupBy('id_produk')
           ->orderBy('total_cost', 'desc')
           ->get();


       return view('data.restock-detail.statistics', compact('statistics', 'startDate', 'endDate'));
   }


   /**
    * Export restock details
    */
   public function export(Request $request)
   {
       // Implementation untuk export ke Excel/PDF
       // Bisa menggunakan Laravel Excel package


       return response()->json([
           'message' => 'Export feature coming soon'
       ]);
   }


   /**
    * Get restock details data for charts/reports
    */
   public function getChartData(Request $request)
   {
       $produkId = $request->get('produk_id');
       $period = $request->get('period', 'monthly'); // daily, weekly, monthly


       $query = RestockDetail::selectRaw('
               DATE(restock.tanggal_restock) as date,
               SUM(01_restock_detail.jumlah) as total_quantity,
               SUM(01_restock_detail.subtotal) as total_cost
           ')
           ->join('01_restock as restock', '01_restock_detail.id_restock', '=', 'restock.id')
           ->where('restock.status', 'selesai')
           ->when($produkId, function($q) use ($produkId) {
               $q->where('01_restock_detail.id_produk', $produkId);
           })
           ->groupBy('date')
           ->orderBy('date')
           ->get();


       return response()->json($query);
   }
}




