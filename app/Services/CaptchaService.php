<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\IpUtils;
use Illuminate\Support\Facades\Http;

class CaptchaService
{
    public function verifyCaptcha($request)
    {
        if ($request->reviewer_id) {
            return 1;
        }
        $recaptcha = $request->{'g-recaptcha-response'};
        if (is_null($recaptcha)) {
            return [
                'error' => 1,
                'captchaErrorMessage' => 'Please complete the recaptcha again to proceed'
            ];
        }

        $url = "https://www.google.com/recaptcha/api/siteverify";

        $body = [
            'secret' => config('services.recaptcha.secret'),
            'response' => $recaptcha,
            'remoteip' => IpUtils::anonymize($request->ip()) //anonymize the ip to be GDPR compliant. Otherwise just pass the default ip address
        ];

        $response = Http::asForm()->post($url, $body);

        $result = json_decode($response);

        if (!$response->successful() || $result->success !== true) {
            return [
                'error' => 1,
                'captchaErrorMessage' => 'Please complete the recaptcha again to proceed'
            ];
        }
        return 1;
    }
}
