<?php

namespace T3G\AgencyPack\Blog\Form\Wizards;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class SocialImageWizardController
 *
 * @package T3G\AgencyPack\Blog\Form\Wizards
 */
class SocialImageWizardController
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response)
    {
        $markup = '
        
        <div class="container">
            <input type="text" placeholder="Enter Social Text here">
        </div>
        <div class="container-fluid">
            <div class="col-sm-12 col-lg-4 preview-facebook">
                <h3>Facebook / Twitter</h3>
                <canvas id="preview-facebook" width="512" height="256" style="border: 1px solid grey"></canvas>
            </div>
            <div class="col-sm-12 col-lg-2 preview-linkedin">
                <h3>LinkedIn</h3>
                <canvas id="preview-linkedin" width="350" height="250" style="border: 1px solid grey"></canvas>
            </div>
            <div class="col-sm-12 col-lg-3 preview-googleplus">
                <h3>Google+</h3>
                <canvas id="preview-googleplus" width="426" height="213" style="border: 1px solid grey"></canvas>
            </div>
        </div>
        
        ';

        $response->getBody()->write($markup);
        return $response;
    }
}