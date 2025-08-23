<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Account;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class DomruService
{
    protected static string $USER_AGENT = 'myHomeErth/8 CFNetwork/1209 Darwin/20.2.0';

    public static function login(string $phone): Collection
    {
        return cache()->remember("domru.login.{$phone}", Carbon::now()->endOfHour(), function() use ($phone) {
            $request = Http::acceptJson()
                ->asJson()
                ->withUserAgent(self::$USER_AGENT)
                ->get("https://myhome.novotelecom.ru/auth/v2/login/{$phone}");

            logger()->debug($request->body());

            return collect($request->json());
        });
    }

    public static function request(Account $account): void
    {
        $request = Http::acceptJson()
            ->asJson()
            ->withUserAgent(self::$USER_AGENT)
            ->withBody(json_encode([
                'operatorId' => $account->operator,
                'subscriberId' => $account->subscriber,
                'accountId' => $account->account,
                'placeId' => $account->place,
                'address' => $account->address,
                'profileId' => $account->profile,
            ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR))
            ->post("https://myhome.novotelecom.ru/auth/v2/confirmation/{$account->phone}");

        logger()->debug($request->body());
    }

    public static function confirm(Account $account): array
    {
        $request = Http::acceptJson()
            ->asJson()
            ->withUserAgent(self::$USER_AGENT)
            ->withBody(json_encode([
                'confirm1' => $account->code,
                'subscriberId' => $account->subscriber,
                'login' => $account->phone,
                'operatorId' => $account->operator,
                'accountId' => $account->account,
                'profileId' => $account->profile,
            ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR))
            ->post("https://myhome.novotelecom.ru/auth/v2/auth/{$account->phone}/confirmation");

        logger()->debug($request->body());

        return $request->json();
    }

    public static function places(Account $account): Collection
    {
        return cache()->remember("domru.places.{$account->id}", Carbon::now()->endOfHour(), function() use ($account) {
            $request = Http::acceptJson()
                ->asJson()
                ->withUserAgent(self::$USER_AGENT)
                ->withHeader('Authorization', "Bearer {$account->token}")
                ->withHeader('Operator', $account->operator)
                ->get('https://myhome.novotelecom.ru/rest/v1/subscriberplaces');

            logger()->debug($request->body());

            return collect($request->json('data'));
        });
    }

    public static function cameras(Account $account): Collection
    {
        return cache()->remember("domru.cameras.{$account->id}", Carbon::now()->endOfHour(), function() use ($account) {
            $request = Http::acceptJson()
                ->asJson()
                ->withUserAgent(self::$USER_AGENT)
                ->withHeader('Authorization', "Bearer {$account->token}")
                ->withHeader('Operator', $account->operator)
                ->get('https://myhome.novotelecom.ru/rest/v1/forpost/cameras');

            logger()->debug($request->body());

            return collect($request->json('data'));
        });
    }

    public static function open(Account $account, string $control): void
    {
        $request = Http::acceptJson()
            ->asJson()
            ->withUserAgent(self::$USER_AGENT)
            ->withHeader('Authorization', "Bearer {$account->token}")
            ->withBody(json_encode([
                'name' => 'accessControlOpen',
            ], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR))
            ->post("https://myhome.novotelecom.ru/rest/v1/places/{$account->place}/accesscontrols/{$control}/actions");

        logger()->debug($request->body());

        $error = $request->json('data.errorMessage');

        if ($error !== null) {
            throw new Exception($error);
        }
    }

    public static function snap(Account $account, string $control): string
    {
        $request = Http::acceptJson()
            ->asJson()
            ->withUserAgent(self::$USER_AGENT)
            ->withHeader('Authorization', "Bearer {$account->token}")
            ->get("https://myhome.novotelecom.ru/rest/v1/places/{$account->place}/accesscontrols/{$control}/videosnapshots");

        logger()->debug($request->body());

        $path = storage_path('tmp/snap.jpg');

        file_put_contents($path, $request->body());

        return $path;
    }

    public static function rtsp(Account $account, string $camera): string
    {
        $request = Http::acceptJson()
            ->asJson()
            ->withUserAgent(self::$USER_AGENT)
            ->withHeader('Authorization', "Bearer {$account->token}")
            ->withHeader('Operator', $account->operator)
            ->get("https://myhome.novotelecom.ru/rest/v1/forpost/cameras/{$camera}/video");

        logger()->debug($request->body());

        $error = $request->json('errorMessage');

        if ($error !== null) {
            throw new Exception($error);
        }

        logger()->debug($request->body());

        return $request->json('data.URL');
    }
}
