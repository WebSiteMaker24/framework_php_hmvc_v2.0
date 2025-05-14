<?php

class ModelUser {
    // 💙 Méthode pour créer un utilisateur
    public function create($email, $password, $ip_address, $user_agent)
    {
        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insertion dans la base de données
        $query = "INSERT INTO users (email, password, ip_address, user_agent) VALUES (:email, :password, :ip_address, :user_agent)";
        $stmt = self::$_pdo->prepare($query);

        // Exécution
        $stmt->execute([
            ':email' => $email,
            ':password' => $hashedPassword,
            ':ip_address' => $ip_address,
            ':user_agent' => $user_agent
        ]);
    }

    // 💙 Méthode pour mettre à jour un utilisateur
    public function update($id, $email, $password, $status)
    {
        // Optionnel : hachage du mot de passe si modifié
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Mise à jour de l'utilisateur dans la base de données
        $query = "UPDATE users SET email = :email, password = :password, status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = self::$_pdo->prepare($query);
        $stmt->execute([
            ':email' => $email,
            ':password' => $hashedPassword,
            ':status' => $status,
            ':id' => $id
        ]);
    }

    // 💙 Méthode pour supprimer un utilisateur
    public function delete($id)
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = self::$_pdo->prepare($query);
        $stmt->execute([':id' => $id]);
    }
    
    // 💙 Méthode pour lire un utilisateur par son email
    public function readByEmail($email)
    {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = self::$_pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    // 💚 Méthode pour se connecter : vérifie le mot de passe et met à jour la dernière connexion
    public function login($email, $password)
    {
        $user = $this->readByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            // Mise à jour de la dernière connexion
            $query = "UPDATE users SET last_login = NOW(), failed_attempts = 0 WHERE email = :email";
            $stmt = self::$_pdo->prepare($query);
            $stmt->execute([':email' => $email]);
            return $user; // Retourne les données de l'utilisateur
        }

        // Incrémentation des tentatives échouées
        $query = "UPDATE users SET failed_attempts = failed_attempts + 1 WHERE email = :email";
        $stmt = self::$_pdo->prepare($query);
        $stmt->execute([':email' => $email]);

        return false; // Si le mot de passe est incorrect
    }

    // 💚 Méthode pour vérifier si l'email existe déjà
    public function emailExists($email)
    {
        $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = self::$_pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }
}