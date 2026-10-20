<?php
require "config.php";
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = strtolower(trim($_POST["email"] ?? ""));
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $mensagem = "Encontramos sua conta. (Simulação) Um pedido de redefinição seria enviado para $email.";
    } else {
        $mensagem = "Se esse e-mail estiver cadastrado, você receberá instruções para recuperar o acesso.";
    }
}
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Recuperar senha | Asobu</title><link rel="stylesheet" href="style.css"></head><body><header class="topbar"><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><nav><a href="login.php">Entrar</a></nav></header>
<main class="auth-page"><section class="auth-card"><span class="eyebrow">RECUPERAÇÃO DE ACESSO</span><h1>Esqueceu a senha?</h1><p>Informe o e-mail usado no cadastro. Esta versão acadêmica simula o pedido de redefinição.</p>
<?php if ($mensagem): ?><div class="message"><?= htmlspecialchars($mensagem) ?></div><?php endif; ?>
<form method="post"><div class="form-field"><label for="email">Seu e-mail</label><input id="email" type="email" name="email" required></div><button class="primary-button full-button" type="submit">Solicitar redefinição ↗</button></form><div class="auth-links"><a href="login.php">Voltar para o login</a></div></section></main><footer><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><p>Feito para quem vive cada partida como uma nova história.</p><span>© 2026 Asobu</span></footer></body></html>
