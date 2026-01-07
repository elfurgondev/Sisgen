<?php

namespace App\Services;

use App\Models\Client;
use App\Models\SalesProcess;
use App\Models\Property;
use Illuminate\Support\Facades\DB;

class SalesService
{
    /**
     * Create a new sales process for a client and property.
     */
    public function initiateSale(Client $client, Property $property): SalesProcess
    {
        return DB::transaction(function () use ($client, $property) {
            // Check if property is available
            if ($property->status !== 'available') {
                throw new \Exception("Property is not available.");
            }

            // Create Sales Process
            $process = SalesProcess::create([
                'client_id' => $client->id,
                'property_id' => $property->id,
                'status' => 'draft',
                'financial_data' => [
                    'price' => $property->price,
                ],
            ]);

            // Update Property Status
            $property->update(['status' => 'reserved']);

            return $process;
        });
    }

    /**
     * Update financial data and recalculate amortization (placeholder).
     */
    public function updateFinancials(SalesProcess $process, array $data): SalesProcess
    {
        $process->update([
            'financial_data' => array_merge($process->financial_data ?? [], $data),
        ]);

        return $process;
    }
}
