<?php
namespace Controllers;

use Models\Activation;
use Models\User;

final class ActivationController
{
    public function activate(): void
    {
        $token = (string)($_GET['token'] ?? '');
        if ($token === '') {
            \View::render('auth/activation-result', [
                'success' => false,
                'message' => 'Lien d’activation invalide.'
            ]);
            return;
        }

        $row = Activation::findByToken($token);
        if (!$row) {
            \View::render('auth/activation-result', [
                'success' => false,
                'message' => 'Lien invalide ou expiré.'
            ]);
            return;
        }

        $userId = (int)$row['user_id'];
        // Activer l’utilisateur (ajout du champ is_active requis côté BDD)
        if (!User::activateById($userId)) {
            \View::render('auth/activation-result', [
                'success' => false,
                'message' => 'Activation impossible pour le moment.'
            ]);
            return;
        }

        Activation::markUsedById((int)$row['id']);

        \View::render('auth/activation-result', [
            'success' => true,
            'message' => 'Votre compte est activé. Vous pouvez maintenant vous connecter.'
        ]);
    }
}
