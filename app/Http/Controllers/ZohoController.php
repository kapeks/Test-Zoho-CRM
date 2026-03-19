<?php

namespace App\Http\Controllers;

use App\Services\ZohoService;
use Inertia\Inertia;
use App\Http\Requests\StoreZohoRequest;
use App\Enums\ZohoDealStage;

class ZohoController extends Controller
{
    public function __construct(protected ZohoService $zoho) {}

    public function index()
    {
        return Inertia::render('ZohoForm', [
        'stages' => ZohoDealStage::values()
        ]);
    }

    public function store(StoreZohoRequest $request)
    {
        try {
            $this->zoho->createAccountWithDeal($request->validated());

            return back();
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors([
                'error' => 'Произошла ошибка при связи с Zoho CRM. Попробуйте позже.'
            ]);
        }
    }
}
