<?php
require "config.php";
$erro = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = strtolower(trim($_POST["email"] ?? ""));
    $senha = $_POST["senha"] ?? "";
    $stmt = $pdo->prepare("SELECT id, nome, email, senha FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();
    if ($usuario && password_verify($senha, $usuario["senha"])) {
        session_regenerate_id(true);
        $_SESSION["usuario_id"] = (int)$usuario["id"];
        $_SESSION["usuario_nome"] = $usuario["nome"];
        $_SESSION["usuario_email"] = $usuario["email"];
        header("Location: index.php");
        exit;
    }
    $erro = "E-mail ou senha incorretos.";
}
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Entrar | Asobu</title><link rel="stylesheet" href="style.css"></head><body>
<header class="topbar"><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><nav><a href="index.php">Início</a><a href="cadastro.php">Criar conta</a></nav></header>
<main class="auth-page"><section class="auth-card"><span class="eyebrow">QUE BOM TER VOCÊ AQUI</span><h1>Entre na Asobu.</h1><p>Acesse sua conta para encontrar seus favoritos.</p>
<?php if (isset($_GET["cadastro"])): ?><div class="message">Conta criada! Agora entre com seu e-mail e senha.</div><?php endif; ?>
<?php if (isset($_GET["aviso"])): ?><div class="message error">Você precisa entrar para acessar essa página.</div><?php endif; ?>
<?php if ($erro): ?><div class="message error"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<form method="post"><div class="form-field"><label for="email">E-mail</label><input id="email" type="email" name="email" autocomplete="email" required></div><div class="form-field"><label for="senha">Senha</label><input id="senha" type="password" name="senha" autocomplete="current-password" required></div><button class="primary-button full-button" type="submit">Entrar na minha conta ↗</button></form>
<div class="auth-links"><a href="recuperar.php">Esqueci minha senha</a><a href="cadastro.php">Criar conta</a></div></section></main><footer><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><p>Feito para quem vive cada partida como uma nova história.</p><span>© 2026 Asobu</span></footer></body></html>
