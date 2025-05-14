<?php
// Vérifie si la session est déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    // Démarre la session avec des paramètres sécurisés
    ini_set('session.cookie_secure', 1); // Le cookie ne sera envoyé que sur HTTPS
    ini_set('session.cookie_httponly', 1); // Empêche l'accès JavaScript au cookie
    ini_set('session.cookie_samesite', 'Strict'); // Prévient les attaques CSRF en limitant l'envoi des cookies aux mêmes sites
    session_start();
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/Exception.php';
require '../phpmailer/PHPMailer.php';
require '../phpmailer/SMTP.php';

// Si tu ne fais pas encore de vérification reCAPTCHA, tu peux commenter la partie ci-dessous
// $responseData->success = true;

// if (true) {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    $token = htmlspecialchars($_POST['csrf_token'] ?? '');

    if ($token != $_SESSION['csrf_token']) {
        die('Erreur CSRF - jeton invalide <br>Le Token Session ici : ' . $_SESSION['csrf_token'] . "<br>Le Token Post ici : " . $token);
    }
    
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'VOTRE EMAIL ICI';
        $mail->Password = 'VOTRE CODE API ICI'; // Mot de passe d'application gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom("VOTRE EMAIL ICI", $name);
        $mail->addAddress("VOTRE EMAIL ICI", "VOTRE NOM D'ENTREPRISE ICI"); // Adresse de destination
        $mail->isHTML(true);
        $mail->Subject = "Nouveau message via VOTRE NOM D'ENTREPRISE ICI";
        
        $mail->Body = '
        <div style="width: 100%; background-color: #1B2E35; padding: 40px 0; font-family: Poppins, sans-serif;">
            <div style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                
                <!-- En-tête -->
                <div style="background-color: #009C86; color: white; padding: 20px;">
                    <h1 style="margin: 0; font-size: 24px;">VOTRE NOM D ENTREPRISE ICI</h1>
                    <p style="margin: 5px 0 0;">Votre web master en ligne</p>
                </div>
        
                <!-- Contenu principal -->
                <div style="padding: 20px; color: #111;">
                    <h2 style="color: #009C86; font-size: 1.2em;">📬 Nouveau message reçu</h2>
                    <p style="font-size: 1.2em;"><strong>👤 Nom :</strong> ' . htmlspecialchars($name) . '</p>
                    <p style="font-size: 1.2em;"><strong>📧 Email :</strong> <a href="mailto:' . htmlspecialchars($email) . '" style="color: #00aaff; font-size: 1.2em;">' . htmlspecialchars($email) . '</a></p>
                    <p style="font-size: 1.2em;"><strong>📝 Message :</strong><br>' . nl2br(htmlspecialchars($message)) . '</p>
                </div>
        
                <!-- Pied -->
                <div style="background-color: #f0f0f0; padding: 15px 20px; font-size: 13px; color: #333;">
                    <p style="margin: 10px 0;">📍 Ribérac 24600</p>
                    <p style="margin: 10px 0;">📞 <a href="tel:VOTRE TEL ICI" style="color: #009C86;">VOTRE TEL ICI</a></p>
                    <p style="margin: 10px 0;">📧 <a href="mailto:VOTRE MAIL ICI" style="color: #009C86;">VOTRE MAIL ICI</a></p>
                </div>
            </div>
        
            <!-- Footer global -->
            <p style="text-align: center; font-size: 12px; color: #ccc; margin-top: 20px;">
                Ce message a été généré automatiquement depuis <strong style="color: #00aaff;">VOTRE NOM D ENTREPRISE ICI</strong>
            </p>
        </div>';
        
        

        $mail->send();
        // Après avoir envoyé l'email avec succès
        $_SESSION['success'] = true; // Indique que l'email a été envoyé avec succès
        header("Location: /contact");
        exit;
    } catch (Exception $e) {
        echo "Erreur d'envoi : {$mail->ErrorInfo}";
    }

// } else {
//     echo 'Échec de la vérification reCAPTCHA.';
// }
