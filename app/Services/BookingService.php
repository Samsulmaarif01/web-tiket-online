<?php

namespace App\Services;

use App\Repositories\Contracts\TicketRepositoryInterface;
use App\Repositories\Contracts\BookingRepositoryInterface;
use Illuminate\Contracts\Support\ValidatedData;

class BookingService
{
    protected $ticketRepository;
    protected $bookingRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository, BookingRepositoryInterface $bookingRepository)
    {
        $this->ticketRepository = $ticketRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function calculateTotals($ticketId, $totalParticipant)
    {
        $Ppn = 0.11;
        $price = $this->ticketRepository->getPrice($ticketId);

        $subTotal = $totalParticipant * $price;
        $totalPpn = $Ppn * $subTotal;
        $totalAmount = $subTotal + $totalPpn;

        return [
            'sub_total' => $subTotal,
            'total_ppn' => $totalPpn,
            'total_amount' => $totalAmount,
        ];
    }

    public function storeBookingInSession($ticket, $validatedData, $totals)
    {
        session()->put('booking', 
        [
            'ticket_id' => $ticket->id,
            'name' =>   $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'started_at' => $validatedData['started_at'],
            'total_participant' => $validatedData['total_participant'],
            'sub_total' => $totals['sub_total'],
            'total_ppn' => $totals['total_ppn'],
            'total_amount' => $totals['total_amount'],


        ]);
    }


}