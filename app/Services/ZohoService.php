<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ZohoService
{
    protected string $baseUrl;
    protected string $accountsUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.zoho.base_url');
        $this->accountsUrl = config('services.zoho.accounts_url');
    }

    public function getAccessToken(): string
    {
        return Cache::remember('zoho_access_token', 3500, function () {
            $response = Http::asForm()->post($this->accountsUrl, [
                'grant_type' => 'refresh_token',
                'client_id' => config('services.zoho.client_id'),
                'client_secret' => config('services.zoho.client_secret'),
                'refresh_token' => config('services.zoho.refresh_token'),
            ]);

            if ($response->failed()) {
                throw new \Exception('Failed to refresh Zoho Token: ' . $response->body());
            }

            return $response->json()['access_token'];
        });
    }

    public function createAccountWithDeal(array $data): void
    {
        $accountResponse = $this->createAccount($data);
        $accountId = $this->extractId($accountResponse);

        $dealResponse = $this->createDeal($data, $accountId);
        $this->extractDealStatus($dealResponse);
    }

    public function createAccount(array $data): array
    {
        $response = Http::withToken($this->getAccessToken())
            ->post("{$this->baseUrl}/Accounts", [
                'data' => [[
                    'Account_Name' => $data['account_name'],
                    'Website'      => $data['website'] ?? '',
                    'Phone'        => $data['phone'] ?? '',
                ]]
            ]);

        $response->throw();

        return $response->json();
    }

    public function createDeal(array $data, string $accountId): array
    {
        $response = Http::withToken($this->getAccessToken())
            ->post("{$this->baseUrl}/Deals", [
                'data' => [[
                    'Deal_Name'    => $data['deal_name'],
                    'Stage'        => $data['stage'],
                    'Closing_Date' => now()->addDays(30)->format('Y-m-d'),
                    'Account_Name' => ['id' => $accountId],
                ]]
            ]);

        $response->throw();

        return $response->json();
    }

    protected function extractId(array $response): string
    {
        return $response['data'][0]['details']['id'] ?? throw new \Exception('Zoho response invalid: no ID');
    }

    protected function extractDealStatus(array $response): void
    {
        if (($response['data'][0]['status'] ?? null) !== 'success') {
            throw new \Exception('Failed to create Deal in Zoho');
        }
    }
}
