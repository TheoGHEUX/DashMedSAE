<?php
use Core\View;

$currentYear = date('Y');
?>
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>DashMed</h3>
                <p>Votre solution de gestion médicale</p>
            </div>

            <div class="footer-section">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/map">Plan du site</a></li>
                    <li><a href="/legal-notices">Mentions légales</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Contact</h4>
                <p>Email : contact@dashmed.fr</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?= $currentYear ?> DashMed. Tous droits réservés.</p>
        </div>
    </div>
</footer>