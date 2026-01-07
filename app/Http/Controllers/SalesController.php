<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Property;
use App\Models\SalesProcess;
use App\Services\SalesService;
use Illuminate\Http\Request;
use Inertia\Inertia; // Assuming usage, or JSON response if API

class SalesController extends Controller
{
    protected $salesService;

    public function __construct(SalesService $salesService)
    {
        $this->salesService = $salesService;
    }

    public function index()
    {
        $leads = Client::where('status', 'lead')->get();
        return response()->json($leads);
        // If using Inertia: return Inertia::render('CRM/LeadsList', ['leads' => $leads]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'property_id' => 'required|exists:properties,id',
        ]);

        $client = Client::findOrFail($validated['client_id']);
        $property = Property::findOrFail($validated['property_id']);

        try {
            $process = $this->salesService->initiateSale($client, $property);
            return response()->json(['message' => 'Sale initiated', 'data' => $process], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(Client $client)
    {
        return response()->json($client->load('salesProcesses.property'));
    }
}
