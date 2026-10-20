<?php
require "config.php";
require "games.php";
$favoritos = [];
if (usuarioLogado()) {
    $stmt = $pdo->prepare("SELECT jogo_id FROM favoritos WHERE usuario_id = ?");
    $stmt->execute([$_SESSION["usuario_id"]]);
    $favoritos = array_column($stmt->fetchAll(), "jogo_id");
}
$categorias = ["Indie","Ação","Esportes","Corrida","Aventura","RPG"];
?>
<!DOCTYPE html><html lang="pt-BR"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Asobu — seu próximo jogo começa aqui</title><link rel="stylesheet" href="style.css">
</head><body>
<header class="topbar"><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a>
<nav><a class="active" href="index.php">Início</a><a href="#catalogo">Explorar</a>
<?php if (usuarioLogado()): ?><a href="favoritos.php">♡ Favoritos</a><span class="hello">Olá, <?= htmlspecialchars($_SESSION["usuario_nome"]) ?></span><a class="nav-button" href="logout.php">Sair</a>
<?php else: ?><a href="login.php">Entrar</a><a class="nav-button" href="cadastro.php">Criar conta</a><?php endif; ?></nav></header>
<main>
<section class="hero"><div class="hero-content"><span class="eyebrow">SEU UNIVERSO GAMER</span><h1>O próximo jogo<br>que vai te <em>marcar.</em></h1>
<p>Descubra aventuras, indies surpreendentes e mundos que merecem ser explorados. Tudo em um só lugar.</p><a class="primary-button" href="#catalogo">Explorar catálogo <span>↗</span></a><div class="hero-stats"><div><b><?= count($games) ?></b><small>jogos no catálogo</small></div><div><b>6</b><small>categorias</small></div><div><b>100%</b><small>feito para gamers</small></div></div></div>
<div class="hero-art"><video class="hero-video" autoplay muted loop playsinline preload="metadata" aria-label="Animação da logo Asobu"><source src="assets/asobu-intro.mp4" type="video/mp4">Seu navegador não consegue reproduzir este vídeo.</video><div class="floating-card">✦ <span>DESCUBRA ALGO NOVO</span></div></div></section>
<section id="catalogo" class="catalog-section"><div class="section-heading"><div><span class="eyebrow">BIBLIOTECA ASOBU</span><h2>Explore o catálogo</h2><p>Seu próximo favorito está a um clique de distância.</p></div><div class="catalog-count"><b><?= count($games) ?></b> jogos disponíveis</div></div>
<div class="filters"><label class="search-box"><span>⌕</span><input id="gameSearch" type="search" placeholder="Buscar jogo..." aria-label="Buscar jogo"></label>
<div class="category-pills" id="categoryFilters"><button class="pill selected" data-category="Todos">Todos</button><?php foreach ($categorias as $cat): ?><button class="pill" data-category="<?= $cat ?>"><?= $cat ?></button><?php endforeach; ?></div></div>
<div class="game-grid" id="gameGrid">
<?php foreach ($games as $g): ?><article class="game-card" data-title="<?= htmlspecialchars(strtolower($g["titulo"])) ?>" data-category="<?= $g["categoria"] ?>">
<a class="game-image" href="detalhe.php?id=<?= $g["id"] ?>" style="--game-color:<?= $g["cor"] ?>;background-image:linear-gradient(0deg,rgba(9,11,19,.8),rgba(9,11,19,.05)),url('<?= htmlspecialchars($g["imagem"]) ?>')">
<span class="game-category"><?= htmlspecialchars($g["categoria"]) ?></span><span class="image-arrow">↗</span><span class="image-title"><?= htmlspecialchars($g["titulo"]) ?></span></a>
<div class="game-info"><div><h3><a href="detalhe.php?id=<?= $g["id"] ?>"><?= htmlspecialchars($g["titulo"]) ?></a></h3><p><?= htmlspecialchars($g["descricao"]) ?></p></div>
<div class="card-bottom"><span class="rating">★ <?= $g["nota"] ?></span><a class="play-button" href="detalhe.php?id=<?= $g["id"] ?>">▶ Jogar</a><?php if (usuarioLogado()): ?><form method="post" action="favorito.php"><input type="hidden" name="jogo_id" value="<?= $g["id"] ?>"><input type="hidden" name="origem" value="index.php"><button class="heart <?= in_array($g["id"],$favoritos) ? "is-favorite" : "" ?>" title="Adicionar/remover dos favoritos" aria-label="Favoritar"><?= in_array($g["id"],$favoritos) ? "♥" : "♡" ?></button></form><?php else: ?><a class="heart" href="login.php" title="Entre para favoritar">♡</a><?php endif; ?></div></div></article><?php endforeach; ?>
</div><div id="emptyState" class="empty-state" hidden>Nenhum jogo encontrado. Tente outro nome ou categoria.</div></section>
<section class="join-banner"><div><span class="eyebrow">A COMUNIDADE TE ESPERA</span><h2>Salve seus favoritos.<br>Monte sua próxima jornada.</h2></div><a class="primary-button" href="<?= usuarioLogado() ? "favoritos.php" : "cadastro.php" ?>"><?= usuarioLogado() ? "Ver favoritos" : "Criar minha conta" ?> ↗</a></section>
</main><footer><a class="brand" href="index.php"><img class="brand-logo" src="logo-asobu.png" alt="Asobu"></a><p>Feito para quem vive cada partida como uma nova história.</p><span>© 2026 Asobu · Projeto acadêmico</span></footer><script src="script.js"></script></body></html>
