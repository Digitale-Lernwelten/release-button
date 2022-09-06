<?php
/**
 * release plugin for Craft CMS 3.x
 *
 * craft plugin for releases and statistics
 *
 * @link      https://dilewe.de
 * @copyright Copyright (c) 2021 Digitale-Lernwelten
 */

namespace dilewe\release;


use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Release
 *
 * @author    Digitale-Lernwelten
 * @package   Release
 * @since     1.0.0
 *
 */
class Release extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Release
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = true;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;


        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['release-deploy'] = \dilewe\release\controllers\ReleaseController::class;
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            static function(RegisterUrlRulesEvent $event) {
                // Field Layouts
                $event->rules['release/deploy'] = 'release/deploy';
            }
        );

        Event::on(
            UserPermissions::class,
            UserPermissions::EVENT_REGISTER_PERMISSIONS,
            function(RegisterUserPermissionsEvent $event) {
                $event->permissions['Dilewe'] = [
                    'deployment' => [
                        'label' => 'Veröffentlichen',
                    ],
                ];
            }
        );

        Craft::info(
            Craft::t(
                'release',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    //Craft
    public function getCpNavItem()
    {
      $item = parent::getCpNavItem();
      $item['label'] = "Veröffentlichen";

      return $item;
    }

}
