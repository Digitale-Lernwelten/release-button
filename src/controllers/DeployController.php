<?php
/**
 * release plugin for Craft CMS 3.x
 *
 * craft plugin for releases and statistics
 *
 * @link      https://dilewe.de
 * @copyright Copyright (c) 2021 Digitale-Lernwelten
 */

namespace dilewe\release\controllers;

use Craft;

/**
 * @author    Digitale-Lernwelten
 * @package   Release
 * @since     1.0.0
 */
class DeployController extends \craft\web\Controller {
    protected $allowAnonymous = [];

    public function actionIndex() {
        $this->requirePostRequest();
        $this->requirePermission("deployment");

        if(!$_ENV['CRAFT_RELEASE_SECRET']){
            return $this->asJson(["deployment" => false, "error" => true, "textError" => "Missing secret"]);
        }
        if(!$_ENV['CRAFT_RELEASE_URL']){
            return $this->asJson(["deployment" => false, "error" => true, "textError" => "Missing URL"]);
        }

        $secret = $_ENV['CRAFT_RELEASE_SECRET'];
        $payload = json_encode(["action" => "released"]);
        $signature = hash_hmac('sha1', $payload, $secret);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$_ENV['CRAFT_RELEASE_URL']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "X-Hub-Signature: " . $signature
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close ($ch);

        return $this->asJson(["deployment" => true, "error" => false]);
    }
}
