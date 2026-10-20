<?php
require "config.php";
$erro = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $senha = $_POST["senha"] ?? "";
    if ($nome === "" || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 8) {
        $erro = "Preencha os campos corretamente. A senha precisa ter pelo menos 8 caracteres.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
            enviarEmailCadastro($nome, $email);
            header("Location: login.php?cadastro=sucesso");
            exit;
        } catch (PDOException $e) {
            $erro = $e->getCode() === "23000" ? "Este e-mail já está cadastrado." : "Não foi possível criar a conta. Confira o banco de dados.";
        }
    }
}
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Criar conta | Asobu</title><link rel="stylesheet" href="style.css"></head><body>
<header class="topbar"><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><nav><a href="index.php">Início</a><a href="login.php">Entrar</a></nav></header>
<main class="auth-page"><section class="auth-card"><span class="eyebrow">BEM-VINDO À ASOBU</span><h1>Crie sua conta.</h1><p>Salve seus jogos favoritos e monte uma lista para sua próxima aventura.</p>
<?php if ($erro): ?><div class="message error"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
<form method="post"><div class="form-field"><label for="nome">Nome</label><input id="nome" name="nome" autocomplete="name" required value="<?= htmlspecialchars($_POST["nome"] ?? "") ?>"></div>
<div class="form-field"><label for="email">E-mail</label><input id="email" type="email" name="email" autocomplete="email" required value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"></div>
<div class="form-field"><label for="senha">Senha (mínimo 8 caracteres)</label><input id="senha" type="password" name="senha" minlength="8" autocomplete="new-password" required></div>
<button class="primary-button full-button" type="submit">Criar minha conta ↗</button></form><div class="auth-links"><span>Já tem uma conta?</span><a href="login.php">Entrar</a></div></section></main>
<footer><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><p>Feito para quem vive cada partida como uma nova história.</p><span>© 2026 Asobu</span></footer></body></html>
