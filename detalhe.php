<?php
require "config.php";
require "games.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$jogo = null;
foreach ($games as $g) if ($g["id"] === $id) { $jogo = $g; break; }
if (!$jogo) { http_response_code(404); $titulo = "Jogo não encontrado"; } else { $titulo = $jogo["titulo"]; }
$favorito = false;
if ($jogo && usuarioLogado()) {
    $stmt = $pdo->prepare("SELECT id FROM favoritos WHERE usuario_id = ? AND jogo_id = ?");
    $stmt->execute([$_SESSION["usuario_id"], $jogo["id"]]);
    $favorito = (bool)$stmt->fetch();
}
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= htmlspecialchars($titulo) ?> | Asobu</title><link rel="stylesheet" href="style.css"></head><body>
<header class="topbar"><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><nav><a href="index.php">Início</a><?php if (usuarioLogado()): ?><a href="favoritos.php">♡ Favoritos</a><a class="nav-button" href="logout.php">Sair</a><?php else: ?><a href="login.php">Entrar</a><?php endif; ?></nav></header>
<main class="detail-wrap"><a class="back-link" href="index.php">← Voltar ao catálogo</a>
<?php if (!$jogo): ?><div class="notice">Esse jogo não foi encontrado. <a href="index.php">Voltar para o catálogo</a>.</div>
<?php else: ?><section class="detail-hero" style="background-image:linear-gradient(90deg,rgba(7,9,15,.94),rgba(7,9,15,.4)),url('<?= htmlspecialchars($jogo["imagem"]) ?>')"><div><span class="eyebrow"><?= htmlspecialchars($jogo["categoria"]) ?> · DESTAQUE ASOBU</span><h1><?= htmlspecialchars($jogo["titulo"]) ?></h1><div class="detail-meta"><span>★ <?= $jogo["nota"] ?>/10</span><span>•</span><span><?= $jogo["ano"] ?></span><span>•</span><span><?= htmlspecialchars($jogo["categoria"]) ?></span></div><p><?= htmlspecialchars($jogo["descricao"]) ?></p><a class="primary-button play-detail" href="https://store.steampowered.com/search/?term=<?= urlencode($jogo["titulo"]) ?>" target="_blank" rel="noopener noreferrer">▶ Jogar <span>↗</span></a>
<?php if (usuarioLogado()): ?><form method="post" action="favorito.php"><input type="hidden" name="jogo_id" value="<?= $jogo["id"] ?>"><input type="hidden" name="origem" value="detalhe.php?id=<?= $jogo["id"] ?>"><button class="primary-button" type="submit"><?= $favorito ? "♥ Remover dos favoritos" : "♡ Adicionar aos favoritos" ?></button></form><?php else: ?><a class="primary-button" href="login.php">Entre para favoritar ↗</a><?php endif; ?></div></section>
<section class="detail-content"><h2>Sobre o jogo</h2><p><?= htmlspecialchars($jogo["descricao"]) ?> A Asobu reúne informações para ajudar você a descobrir novos títulos e encontrar sua próxima experiência gamer.</p><div class="notice">Este projeto é um catálogo demonstrativo para fins acadêmicos. Não transmite jogos nem hospeda conteúdo protegido por direitos autorais.</div></section><?php endif; ?></main>
<footer><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><p>Feito para quem vive cada partida como uma nova história.</p><span>© 2026 Asobu</span></footer></body></html>
