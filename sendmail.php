<?php
// Définition des constantes globales
define('COMPANY_NAME', 'NomDeVotreEntrepriseIci');
define('COMPANY_EMAIL', 'MailDeVotreEntrepriseIci');
define('COMPANY_PHONE', 'NuméroDeTelephoneAvecDesEspaces');
define('COMPANY_PHONE_LINK', 'NuméroDeTelephoneSansLesEspacesPourLeHref');
define('COMPANY_ADDRESS', 'VotreCodePostalEtVille');
define('SMTP_PASSWORD', 'MotDePasseApplication'); // Mot de passe d'application

// Vérifie si la session est déjà démarrée
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.cookie_secure', 1);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_samesite', 'Strict');
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

// Récupération et nettoyage des données POST
$name = trim($_POST['name'] ?? '');
$name = preg_replace("/[^a-zA-Z0-9 .'-]/", '', $name);  // Autorise lettres, chiffres, espace, point, apostrophe, tiret
$name = htmlspecialchars($name);

$email = trim($_POST['email'] ?? '');
$email = filter_var($email, FILTER_VALIDATE_EMAIL) ? htmlspecialchars($email) : '';

$message = trim($_POST['message'] ?? '');
$message = htmlspecialchars($message);

$token = trim($_POST['csrf_token'] ?? '');  // Juste trim, PAS de htmlspecialchars !

if ($token !== $_SESSION['csrf_token']) {
    die('Erreur CSRF - jeton invalide <br>Le Token Session ici : ' . $_SESSION['csrf_token'] . "<br>Le Token Post ici : " . $token);
}

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = COMPANY_EMAIL;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom(COMPANY_EMAIL, $name);
    $mail->addAddress(COMPANY_EMAIL, COMPANY_NAME);
    $mail->isHTML(true);
    $mail->Subject = "Nouveau message via " . COMPANY_NAME;
    
    $mail->Body = '
    <div style="width: 100%; background-color: #1B2E35; padding: 40px 0; font-family: Poppins, sans-serif;">
        <div style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
            
            <!-- En-tête -->
            <div style="background-color: #009C86; color: white; padding: 20px;">
                <h1 style="margin: 0; font-size: 24px;">' . COMPANY_NAME . '</h1>
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
                <p style="margin: 10px 0;">📍 ' . COMPANY_ADDRESS . '</p>
                <p style="margin: 10px 0;">📞 <a href="tel:' . COMPANY_PHONE_LINK . '" style="color: #009C86;">' . COMPANY_PHONE . '</a></p>
                <p style="margin: 10px 0;">📧 <a href="mailto:' . COMPANY_EMAIL . '" style="color: #009C86;">' . COMPANY_EMAIL . '</a></p>
            </div>
        </div>
    
        <!-- Footer global -->
        <p style="text-align: center; font-size: 12px; color: #ccc; margin-top: 20px;">
            Ce message a été généré automatiquement depuis <strong style="color: #00aaff;">' . COMPANY_NAME . '.fr</strong>
        </p>
    </div>';

    $mail->send();
    $_SESSION['success'] = true;
    header("Location: /contact");
    exit;
} catch (Exception $e) {
    echo "Erreur d'envoi : {$mail->ErrorInfo}";
}
