<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $tableNumber = $request->query('meja');
        if ($tableNumber) {
            Session::put('tableNumber', $tableNumber);
        }

        $items = Item::where('is_active', 1)->orderBy('name', 'asc')->get();
        return view('customer.menu', compact('items', 'tableNumber'));
    }

    public function cart()
    {
        $cart = Session::get('cart');
        return view('customer.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $menuId = $request->input('id');
        $menu = Item::find($menuId);

        if (!$menu) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Menu not found.'
            ]);
        }

        $cart = Session::get('cart', []); // tambah default [] agar tidak null

        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] += 1;
        } else {
            $cart[$menuId] = [
                'id'    => $menu->id,
                'name'  => $menu->name,
                'price' => $menu->price,
                'image' => $menu->img,
                'qty'   => 1,
            ];
        }

        Session::put('cart', $cart);

        // Hitung total
        $cartTotal = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));

        return response()->json([
            'status'     => 'success',
            'message'    => 'Menu added to cart.',
            'cart'       => $cart,
            'cart_count' => count($cart),  // jumlah item unik
            'cart_total' => $cartTotal,    // total harga
        ]);
    }

    public function updateCart(Request $request)
    {
        $itemId = $request->input('id');
        $newQty = $request->input('qty');

        if ($newQty <= 0) {
            return response()->json([
                'success' => false,
            ]);
        }

        $cart = Session::get('cart');
        if (isset($cart[$itemId])) {
            $cart[$itemId]['qty'] = $newQty;
            Session::put('cart', $cart);

            session::flash('success', 'Cart updated successfully.');
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $itemId = $request->input('id');
        $cart = Session::get('cart');

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            Session::put('cart', $cart);

            session::flash('success', 'Item removed from cart successfully.');
            return response()->json([
                'success' => true,
            ]);
        }

        return response()->json([
            'success' => false,
        ]);
    }

    public function clearCart()
    {
        Session::forget('cart');
        session::flash('success', 'Cart cleared successfully.');
        return redirect()->route('cart');
    }


    public function checkout()
    {
        $cart = Session::get('cart');

        if(empty($cart)) {
            return redirect()->route('menu')->with('error', 'Your cart is empty.');
        }

        $tableNumber = Session::get('tableNumber');

        return view('customer.checkout', compact('cart', 'tableNumber'));
    }

    public function storeOrder(Request $request)
    {
        $cart        = Session::get('cart');
        $tableNumber = Session::get('tableNumber');

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang masih kosong');
        }

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'phone'    => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return redirect()->route('checkout')->withErrors($validator);
        }

        // ─── Konstanta tax (seragam dengan blade) ───────────────────
        $TAX_RATE = 0.11;

        // ─── Hitung subtotal & build itemDetails ────────────────────
        $subtotal    = 0;
        $itemDetails = [];

        foreach ($cart as $item) {
            $itemSubtotal = $item['price'] * $item['qty'];
            $subtotal    += $itemSubtotal;

            // price di itemDetails harus EXCLUDE tax
            // karena gross_amount = subtotal + tax (dihitung terpisah)
            $itemDetails[] = [
                'id'       => $item['id'],
                'price'    => (int) $item['price'],   // ← harga asli, tanpa tax
                'quantity' => $item['qty'],
                'name'     => substr($item['name'], 0, 50),
            ];
        }

        $tax        = (int) round($subtotal * $TAX_RATE);
        $grandTotal = $subtotal + $tax;

        // ─── Tambahkan tax sebagai 1 baris item di Midtrans ─────────
        // Supaya SUM(itemDetails) == gross_amount (wajib di Midtrans)
        $itemDetails[] = [
            'id'       => 'TAX',
            'price'    => $tax,
            'quantity' => 1,
            'name'     => 'PPN 11%',
        ];

        // ─── Simpan Order ────────────────────────────────────────────
        $order = Order::create([
            'order_code'      => 'ORD-' . $tableNumber . '-' . time(),
            'customer_name'   => $request->input('fullname'),
            'customer_phone'  => $request->input('phone'),
            'subtotal'        => (int) $subtotal,
            'tax'             => $tax,
            'grand_total'     => $grandTotal,
            'status'          => 'pending',
            'table_number'    => $tableNumber,
            'payment_method'  => $request->payment_method,
            'note'            => $request->note,
        ]);

        // ─── Simpan OrderItems ───────────────────────────────────────
        foreach ($cart as $item) {
            $itemSubtotal = (int) ($item['price'] * $item['qty']);
            $itemTax      = (int) round($itemSubtotal * $TAX_RATE);

            OrderItem::create([
                'order_id'    => $order->id,
                'item_id'     => $item['id'],
                'quantity'    => $item['qty'],
                'price'       => $itemSubtotal,
                'tax'         => $itemTax,
                'total_price' => $itemSubtotal + $itemTax,
            ]);
        }

        Session::forget('cart');

        // ─── Tunai ───────────────────────────────────────────────────
        if ($request->payment_method == 'tunai') {
            return redirect()
                ->route('checkout.success', ['orderId' => $order->order_code])
                ->with('success', 'Pesanan berhasil dibuat');
        }

        // ─── QRIS via Midtrans ───────────────────────────────────────
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_code,
                'gross_amount' => $grandTotal,  // ← sama persis dengan SUM(itemDetails)
            ],
            'item_details'     => $itemDetails,
            'customer_details' => [
                'first_name' => $order->customer_name ?? 'Guest',
                'phone'      => $order->customer_phone,
            ],
            'payment_type' => 'qris',
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            return response()->json([
                'status'     => 'success',
                'snap_token' => $snapToken,
                'order_code' => $order->order_code,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membuat pesanan. Silakan coba lagi.',
            ]);
        }
    }

    public function checkoutSuccess($orderId)
    {
        $order = Order::where('order_code', $orderId)->first();

        if (!$order) {
            return redirect()->route('menu')->with('error', 'Pesanan tidak ditemukan');
        }

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        if ($order->payment_method == 'qris') {
            $order->status  = 'settlement';
            $order->save();
        }

        return view('customer.success', compact('order', 'orderItems'));
    }

    public function tracking($orderCode)
    {
        $order = Order::with('orderItems.item')
                    ->where('order_code', $orderCode)
                    ->firstOrFail();
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        return view('customer.tracking', compact('order', 'orderItems'));
    }
}