<?php

namespace dilewe\release\controllers;

use Craft;
use craft\helpers\App;
use craft\web\Controller;
use craft\web\View;
use GuzzleHttp\Exception\GuzzleException;
use yii\web\Response;

class DeployController extends Controller
{
    public function actionPage(): Response
    {
        $this->requirePermission('deployment');

        return $this->renderTemplate('release/index', [
            'configured' => $this->webhookConfig() !== null,
        ], View::TEMPLATE_MODE_CP);
    }

    public function actionIndex(): Response
    {
        $this->requirePostRequest();
        $this->requirePermission('deployment');
        $this->requireAcceptsJson();

        $config = $this->webhookConfig();
        if ($config === null) {
            return $this->asJson(['deployment' => false, 'error' => 'Configure a valid HTTPS CRAFT_RELEASE_URL and CRAFT_RELEASE_SECRET.']);
        }

        [$url, $secret] = $config;
        $payload = json_encode(['action' => 'released'], JSON_THROW_ON_ERROR);

        try {
            $response = Craft::createGuzzleClient(['timeout' => 10, 'allow_redirects' => false])->post($url, [
                'body' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Hub-Signature' => hash_hmac('sha1', $payload, $secret),
                ],
            ]);
        } catch (GuzzleException $exception) {
            Craft::error('Release webhook failed: ' . get_class($exception), __METHOD__);
            return $this->asJson(['deployment' => false, 'error' => 'The release webhook request failed.']);
        }

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            return $this->asJson(['deployment' => false, 'error' => 'The release webhook did not accept the request.']);
        }

        return $this->asJson(['deployment' => true, 'error' => false]);
    }

    private function webhookConfig(): ?array
    {
        $url = App::env('CRAFT_RELEASE_URL');
        $secret = App::env('CRAFT_RELEASE_SECRET');

        if (!is_string($url) || !is_string($secret) || $secret === '' ||
            filter_var($url, FILTER_VALIDATE_URL) === false ||
            parse_url($url, PHP_URL_SCHEME) !== 'https') {
            return null;
        }

        return [$url, $secret];
    }
}
