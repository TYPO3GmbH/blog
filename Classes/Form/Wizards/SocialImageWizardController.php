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
        <style>
            .preview-container {
                overflow: hidden;
            }
            .preview {
                background-color: #515151;
                margin-bottom: 1.5em;
                width: 100%;
                position: relative;
            }
            .preview:before {
                display: block;
                content: "";
            }
            .preview canvas {
                position: absolute;
                top: 0;
                left: 0;
            }
            .preview-facebook {
                max-width: 512px;
            }
            .preview-facebook:before {
                padding-top: 50%;
            }
            .preview-linkedin {
                max-width: 350px;
            }
            .preview-linkedin:before {
                padding-top: 71.42857142857143%;
            }
            .preview-googleplus {
                max-width: 426px;
            }
            .preview-googleplus:before {
                padding-top: 50%;
            }
        </style>
        <div class="preview-container">
            <input type="text" class="form-control" placeholder="Enter Social Text here">
        </div>
        <div class="preview-container">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <h3>Facebook / Twitter (512x256)</h3>
                    <div class="preview preview-facebook">
                        <canvas id="preview-facebook" width="512" height="256"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <h3>LinkedIn (350x250)</h3>
                    <div class="preview preview-linkedin">
                        <canvas id="preview-linkedin" width="350" height="250"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <h3>Google+ (426x213)</h3>
                    <div class="preview preview-googleplus">
                        <canvas id="preview-googleplus" width="426" height="213"></canvas>
                    </div>
                </div>
            </div>
        </div>
        ';

        $response->getBody()->write($markup);
        return $response;
    }
}
