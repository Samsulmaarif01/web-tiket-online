<?php

namespace App\Repositories;

use App\Models\BookingTransaction;
use App\Repositories\Contracts\BookingRepositoryInterface;

class BookingRepository implements BookingRepositoryInterface
{
    public function createBooking(array $data)
    {
        return BookingTransaction::create($data);
    }

    public function findByTrxAndPhoneNumber($bookingtrxId, $phoneNumber)
    {
        return BookingTransaction::where('booking_trx_id', $bookingtrxId)->where('phone_number', $phoneNumber)->first();
    }
}