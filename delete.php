<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Доступ запрещен');
}

$msg = '';

if (isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT surname FROM contacts WHERE id = ?");
    $stmt->execute([$delId]);
    $found = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($found) {
        $surname = $found['surname'];
        $pdo->prepare("DELETE FROM contacts WHERE id = ?")->execute([$delId]);
        $msg = '<div class="success">Запись с фамилией ' . htmlspecialchars($surname) . ' удалена</div>';
    }
}

$list = $pdo->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC")->fetchAll(PDO::FETCH_ASSOC);

echo $msg;

if (empty($list)) {
    echo '<p>Нет записей для удаления.</p>';
    return;
}

echo '<div class="div-edit">';
foreach ($list as $item) {
    $nInit = $item['name'] !== '' ? mb_substr($item['name'], 0, 1) . '.' : '';
    $lInit = $item['lastname'] !== '' ? mb_substr($item['lastname'], 0, 1) . '.' : '';
    $text = trim($item['surname'] . ' ' . $nInit . $lInit);
    echo '<a href="index.php?p=delete&id=' . $item['id'] . '">' . htmlspecialchars($text) . '</a>';
}
echo '</div>';
?>
