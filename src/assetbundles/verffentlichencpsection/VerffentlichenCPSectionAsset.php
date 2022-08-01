<?php
/**
 * release plugin for Craft CMS 3.x
 *
 * craft plugin for releases and statistics
 *
 * @link      https://dilewe.de
 * @copyright Copyright (c) 2021 Digitale-Lernwelten
 */

namespace dilewe\release\assetbundles\verffentlichencpsection;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Digitale-Lernwelten
 * @package   Release
 * @since     1.0.0
 */
class VerffentlichenCPSectionAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@dilewe/release/assetbundles/verffentlichencpsection/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Verffentlichen.js',
        ];

        $this->css = [
            'css/Verffentlichen.css',
        ];

        parent::init();
    }
}
