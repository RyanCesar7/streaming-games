<?php
require "config.php";
exigirLogin();
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: favoritos.php"); exit; }
$jogoId = filter_input(INPUT_POST, "jogo_id", FILTER_VALIDATE_INT);
require "games.php";
$valido = false;
foreach ($games as $g) if ($g["id"] === $jogoId) $valido = true;
if ($valido) {
    $stmt = $pdo->prepare("SELECT id FROM favoritos WHERE usuario_id = ? AND jogo_id = ?");
    $stmt->execute([$_SESSION["usuario_id"], $jogoId]);
    if ($stmt->fetch()) {
        $stmt = $pdo->prepare("DELETE FROM favoritos WHERE usuario_id = ? AND jogo_id = ?");
        $stmt->execute([$_SESSION["usuario_id"], $jogoId]);
    } else {
        $stmt = $pdo->prepare("INSERT IGNORE INTO favoritos (usuario_id, jogo_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION["usuario_id"], $jogoId]);
    }
}
$origem = $_POST["origem"] ?? "favoritos.php";
if (!preg_match('/^(index\.php|favoritos\.php|detalhe\.php\?id=\d+)$/', $origem)) $origem = "favoritos.php";
header("Location: " . $origem);
exit;
?>
