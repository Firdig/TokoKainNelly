<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Helper private untuk mendapatkan/membuat keranjang berdasarkan Session ID
     */
    private function getCart()
    {
        // Gunakan session ID yang ada atau buat baru
        if (!Session::has('cart_id')) {
            Session::put('cart_id', Str::uuid()->toString());
        }

        $sessionId = Session::get('cart_id');

        // Cari keranjang dengan session ini, jika tidak ada, buat baru
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    /**
     * Tampilkan isi keranjang
     */
    public function index()
    {
        $cart = $this->getCart();
        // Muat (Eager Load) item keranjang beserta data produknya
        $cart->load('items.productVariant.product');

        return view('cart.index', compact('cart'));
    }

    /**
     * Tambahkan produk ke keranjang
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|numeric|min:0.5',
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = $product->variants()->findOrFail($request->product_variant_id);
        
        // Validasi stok awal dari varian warna spesifik
        if ($variant->stock < $request->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Maaf, kuantitas melebihi stok warna yang tersedia.']);
        }

        $cart = $this->getCart();

        // Cek apakah item ini (produk + warna spesifik) sudah ada di keranjang
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_variant_id', $variant->id)
                            ->first();

        if ($cartItem) {
            // Update quantity jika sudah ada
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            // Validasi lagi stok gabungan varian
            if ($variant->stock < $newQuantity) {
                 return redirect()->back()->withErrors(['quantity' => 'Total pesanan ini di keranjang melebihi stok warna yang tersedia.']);
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Buat item baru di keranjang
            CartItem::create([
                'cart_id' => $cart->id,
                'product_variant_id' => $variant->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update jumlah spesifik item keranjang (contoh: di halaman Cart user nge-klik + / -)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.5',
        ]);

        $cartItem = CartItem::findOrFail($id);
        $variant = $cartItem->productVariant;

        if ($variant->stock < $request->quantity) {
             return redirect()->back()->withErrors(['quantity_update' => "Stok untuk warna {$variant->color_name} tidak mencukupi."]);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Keranjang diperbarui.');
    }

    /**
     * Hapus spesifik item dari keranjang
     */
    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
