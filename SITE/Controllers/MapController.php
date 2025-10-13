<?php
namespace Controllers;

use Core\Controller;

/**
 * MapController - Plan du site
 *
 * @package DashMed
 * @version 2.0
 */
final class MapController extends Controller
{
    public function show(): void
    {
        $this->view('map', [
            'pageTitle' => 'Plan du site',
            'pageDescription' => 'Plan du site de DashMed',
        ], 'base');
    }
}