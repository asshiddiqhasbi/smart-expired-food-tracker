<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Generate notifikasi otomatis berdasarkan kondisi produk
        $this->generateNotifications();

        $notifications = Notification::with('product')
                                     ->orderBy('is_read')
                                     ->orderBy('sisa_hari')
                                     ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        Notification::where('id', $notification->id)->update(['is_read' => true]);

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        Notification::where('is_read', false)->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    private function generateNotifications()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $sisaHari = now()->diffInDays($product->tgl_kadaluarsa, false);

            if ($sisaHari < 0) {
                Notification::updateOrCreate(
                    ['product_id' => $product->id, 'tipe' => 'kadaluarsa'],
                    ['sisa_hari' => $sisaHari]
                );
            } elseif ($sisaHari <= 30) {
                Notification::updateOrCreate(
                    ['product_id' => $product->id, 'tipe' => 'mendekati_kadaluarsa'],
                    ['sisa_hari' => $sisaHari]
                );
            } else {
                // Hapus notifikasi kalau produk sudah aman
                Notification::where('product_id', $product->id)->delete();
            }
        }
    }
}