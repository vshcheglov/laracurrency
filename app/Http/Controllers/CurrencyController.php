<?php

namespace App\Http\Controllers;

use App\Services\CurrencyProvider\CurrencyProviderInterface;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function __construct(private readonly CurrencyProviderInterface $currencyProvider)
    {
    }

    public function getCurrencyInfo($currencyCode, Request $request)
    {
        $request->validate([
            'fromDate' => 'sometimes|date',
            'toDate' => 'sometimes|date|after_or_equal:fromDate'
        ]);

        $fromDate = $this->getDateTime($request, 'fromDate');
        $toDate = $this->getDateTime($request, 'toDate');

        $info = $this->currencyProvider->getCurrencyInfo($currencyCode, $fromDate, $toDate);
        return response()->json($info);
    }

    private function getDateTime(Request $request, string $dateKey): ?\DateTime
    {
        $date = $request->input($dateKey);
        return $date ? \DateTime::createFromFormat(\DateTimeInterface::ATOM, $date . 'T00:00:00+00:00'): null;
    }
}
