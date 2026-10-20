<?php
require "config.php";
exigirLogin();
require "games.php";
$stmt = $pdo->prepare("SELECT jogo_id FROM favoritos WHERE usuario_id = ?");
$stmt->execute([$_SESSION["usuario_id"]]);
$ids = array_column($stmt->fetchAll(), "jogo_id");
$favoritos = array_values(array_filter($games, fn($g) => in_array($g["id"], $ids)));
?>
<!DOCTYPE html><html lang="pt-BR"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Favoritos | Asobu</title><link rel="stylesheet" href="style.css"></head><body>
<header class="topbar"><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><nav><a href="index.php">Início</a><a class="active" href="favoritos.php">♡ Favoritos</a><span class="hello">Olá, <?= htmlspecialchars($_SESSION["usuario_nome"]) ?></span><a class="nav-button" href="logout.php">Sair</a></nav></header>
<main class="favorites-list"><span class="eyebrow">SUA COLEÇÃO PESSOAL</span><h1>Jogos favoritos<span style="color:var(--accent)">.</span></h1><p>Uma lista só sua, para não esquecer o que quer jogar.</p>
<?php if (!$favoritos): ?><div class="notice">Você ainda não salvou nenhum jogo. Explore o catálogo e toque no coração dos seus favoritos.<br><br><a class="primary-button" href="index.php#catalogo">Explorar jogos ↗</a></div><?php else: ?><div class="game-grid"><?php foreach ($favoritos as $g): ?><article class="game-card"><a class="game-image" href="detalhe.php?id=<?= $g["id"] ?>" style="background-image:linear-gradient(0deg,rgba(9,11,19,.8),rgba(9,11,19,.05)),url('<?= htmlspecialchars($g["imagem"]) ?>');background-color:<?= $g["cor"] ?>"><span class="game-category"><?= htmlspecialchars($g["categoria"]) ?></span><span class="image-title"><?= htmlspecialchars($g["titulo"]) ?></span></a><div class="game-info"><h3><a href="detalhe.php?id=<?= $g["id"] ?>"><?= htmlspecialchars($g["titulo"]) ?></a></h3><p><?= htmlspecialchars($g["descricao"]) ?></p><div class="card-bottom"><span class="rating">★ <?= $g["nota"] ?></span><form method="post" action="favorito.php"><input type="hidden" name="jogo_id" value="<?= $g["id"] ?>"><input type="hidden" name="origem" value="favoritos.php"><button class="heart is-favorite" type="submit" aria-label="Remover favorito">♥</button></form></div></div></article><?php endforeach; ?></div><?php endif; ?></main>
<footer><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><p>Feito para quem vive cada partida como uma nova história.</p><span>© 2026 Asobu</span></footer></body></html>
