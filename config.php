<?php
// Configure os dados do seu ambiente local no phpMyAdmin.
$host = "localhost";
$dbname = "asobu";
$dbuser = "root";
$dbpass = "";

// Resend: coloque a chave da API aqui, nunca no HTML/JavaScript.
// No modo de teste, o destinatário precisa ser o e-mail verificado na sua conta Resend.
$resend_api_key = "COLOQUE_SUA_CHAVE_RESEND_AQUI";
$email_dono = "SEU_EMAIL_VERIFICADO@EXEMPLO.COM";
$email_remetente = "Asobu <onboarding@resend.dev>";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbuser,
        $dbpass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die("Não foi possível conectar ao banco. Confira o config.php e importe database.sql no phpMyAdmin.");
}

function usuarioLogado(): bool {
    return isset($_SESSION["usuario_id"]);
}

function exigirLogin(): void {
    if (!usuarioLogado()) {
        header("Location: login.php?aviso=entre");
        exit;
    }
}

function enviarEmailCadastro(string $nome, string $email): void {
    global $resend_api_key, $email_dono, $email_remetente;

    if ($resend_api_key === "COLOQUE_SUA_CHAVE_RESEND_AQUI" ||
        $email_dono === "SEU_EMAIL_VERIFICADO@EXEMPLO.COM" ||
        !function_exists("curl_init")) {
        return; // O site continua funcionando mesmo sem configurar o Resend.
    }

    $payload = [
        "from" => $email_remetente,
        "to" => [$email_dono],
        "subject" => "Novo cadastro na Asobu",
        "html" => "<h2>Novo usuário na Asobu</h2><p><b>Nome:</b> " .
            htmlspecialchars($nome, ENT_QUOTES, "UTF-8") .
            "</p><p><b>E-mail:</b> " .
            htmlspecialchars($email, ENT_QUOTES, "UTF-8") . "</p>"
    ];

    $ch = curl_init("https://api.resend.com/emails");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $resend_api_key,
            "Content-Type: application/json"
        ],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);
    curl_exec($ch);
    curl_close($ch);
}
?>
