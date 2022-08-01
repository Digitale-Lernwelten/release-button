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

use dilewe\release\Release;

use Craft;
use craft\web\Controller;

/**
 * @author    Digitale-Lernwelten
 * @package   Release
 * @since     1.0.0
 */
class ReleaseController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the ReleaseController actionIndex() method';

        return $result;
    }

    /**
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the ReleaseController actionDoSomething() method';

        return $result;
    }

    public function actionDeploy()
    {
        $this->requirePostRequest();
        $request = Craft::$app->getRequest();

        return $this->renderTemplate(
            'craft-deploy/deploy.twig',
            [],
            View::TEMPLATE_MODE_CP
        );
        
        // return $this->redirectToPostedUrl();
    }
}
