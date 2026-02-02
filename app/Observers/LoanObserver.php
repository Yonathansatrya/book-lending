<?php

namespace App\Observers;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;

class LoanObserver
{
    /**
     * Saat peminjaman dibuat
     * → stok buku berkurang
     */
    public function created(Loan $loan): void
    {
        DB::transaction(function () use ($loan) {
            foreach ($loan->details as $detail) {
                $detail->book
                    ->decrement('stok', $detail->qty);
            }
        });
    }

    /**
     * Saat peminjaman DIKEMBALIKAN
     * (status berubah dari dipinjam → dikembalikan)
     */
    public function updated(Loan $loan): void
    {
        if (
            $loan->wasChanged('status')
            && $loan->status === 'dikembalikan'
        ) {
            DB::transaction(function () use ($loan) {
                foreach ($loan->details as $detail) {
                    $detail->book
                        ->increment('stok', $detail->qty);
                }
            });
        }
    }

    /**
     * Jika peminjaman dihapus
     * → rollback stok
     */
    public function deleted(Loan $loan): void
    {
        DB::transaction(function () use ($loan) {
            foreach ($loan->details as $detail) {
                $detail->book
                    ->increment('stok', $detail->qty);
            }
        });
    }
}
