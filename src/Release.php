<?php

namespace dilewe\release;

use Craft;
use craft\base\Plugin;
use craft\events\RegisterUrlRulesEvent;
use craft\events\RegisterUserPermissionsEvent;
use craft\services\UserPermissions;
use craft\web\UrlManager;
use yii\base\Event;

class Release extends Plugin
{
    public string $schemaVersion = '1.2.1';
    public bool $hasCpSettings = false;
    public bool $hasCpSection = true;

    public function init(): void
    {
        parent::init();

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            static function(RegisterUrlRulesEvent $event): void {
                $event->rules['release'] = 'release/deploy/page';
            }
        );

        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            static function(RegisterUserPermissionsEvent $event): void {
                $event->permissions[] = [
                    'heading' => 'Dilewe',
                    'permissions' => [
                        'deployment' => ['label' => 'Veröffentlichen'],
                    ],
                ];
            }
        );
    }

    public function getCpNavItem(): ?array
    {
        if (!Craft::$app->getUser()->checkPermission('deployment')) {
            return null;
        }

        $item = parent::getCpNavItem();
        $item['label'] = 'Veröffentlichen';
        return $item;
    }
}
