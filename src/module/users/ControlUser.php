<?php

require_once __DIR__ . "/../../model/Database.php"; // Inclure la configuration
require_once __DIR__ . "/User.php"; // Inclure le modèle User

class UserController
{
    // Méthode pour créer un utilisateur
    public function createUser($email, $password, $ip_address, $user_agent)
    {
        // Validation de l'email
        if (!$this->validateEmail($email)) {
            return "Email invalide.";
        }

        // Vérifier si l'email existe déjà
        $userModel = new User();
        if ($userModel->emailExists($email)) {
            return "L'email est déjà utilisé.";
        }

        // Validation du mot de passe
        if (!$this->validatePassword($password)) {
            return "Mot de passe invalide.";
        }

        // Créer l'utilisateur
        $userModel->create($email, $password, $ip_address, $user_agent);

        return "Utilisateur créé avec succès!";
    }

    // Méthode pour se connecter
    public function loginUser($email, $password)
    {
        // Validation de l'email
        if (!$this->validateEmail($email)) {
            return "Email invalide.";
        }

        // Vérifier l'email et le mot de passe
        $userModel = new User();
        $user = $userModel->login($email, $password);
        if (!$user) {
            return "Identifiants incorrects.";
        }

        // Retourner les données de l'utilisateur
        return $user;
    }

    // Méthode pour mettre à jour un utilisateur
    public function updateUser($id, $email, $password, $status)
    {
        // Validation de l'email
        if (!$this->validateEmail($email)) {
            return "Email invalide.";
        }

        // Validation du mot de passe
        if (!$this->validatePassword($password)) {
            return "Mot de passe invalide.";
        }

        // Mise à jour de l'utilisateur
        $userModel = new User();
        $userModel->update($id, $email, $password, $status);

        return "Utilisateur mis à jour avec succès!";
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($id)
    {
        $userModel = new User();
        $userModel->delete($id);

        return "Utilisateur supprimé avec succès!";
    }

    // Validation de l'email
    private function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Validation du mot de passe (minimum 8 caractères)
    private function validatePassword($password)
    {
        return strlen($password) >= 8;
    }
}