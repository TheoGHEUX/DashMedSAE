<?php
namespace Controllers;

use Core\Controller;

/**
 * LegalNoticesController - Mentions légales
 *
 * @package DashMed
 * @version 2.0
 */
final class LegalNoticesController extends Controller
{
    public function show(): void
    {
        $this->view('legal-notices', [
            'pageTitle' => 'Mentions légales',
            'pageDescription' => 'Mentions légales de DashMed',
        ], 'base');
    }
}