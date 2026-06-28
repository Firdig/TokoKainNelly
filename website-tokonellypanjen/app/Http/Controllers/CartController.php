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
        if (!\Illuminate\Support\Facades\Auth::check()) {
            Session::put('url.intended', route('cart.index'));
            return redirect()->route('login')->with('error', 'Silakan login atau daftar terlebih dahulu untuk melihat keranjang belanja Anda.');
        }

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
        if (!\Illuminate\Support\Facades\Auth::check()) {
            Session::put('url.intended', url()->previous());
            Session::flash('error', 'Silakan login atau daftar terlebih dahulu untuk menambahkan ke keranjang.');
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['redirect' => route('login')], 401);
            }
            return redirect()->route('login');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|numeric|min:0.5',
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = $product->variants()->findOrFail($request->product_variant_id);
        
        // stock validation from variant color
        if ($variant->stock < $request->quantity) {
            return redirect()->back()->withErrors(['quantity' => 'Maaf, kuantitas melebihi stok warna yang tersedia.']);
        }

        $cart = $this->getCart();

        // check product and variant if already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_variant_id', $variant->id)
                            ->first();

        if ($cartItem) {
            // Quantity if already exist
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            // validating stock
            if ($variant->stock < $newQuantity) {
                 return redirect()->back()->withErrors(['quantity' => 'Total pesanan ini di keranjang melebihi stok warna yang tersedia.']);
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // create new item
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
