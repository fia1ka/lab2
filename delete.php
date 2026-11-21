<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Прямой доступ запрещен');
}

$statusMessage = '';

if (isset($_GET['id'])) {
    $delId = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT surname FROM contacts WHERE id = ?");
    $stmt->execute([$delId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $surname = $row['surname'];
        $delStmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
        $delStmt->execute([$delId]);
        $statusMessage = '<p class="msg-success">Запись с фамилией ' . htmlspecialchars($surname) . ' удалена</p>';
    }
}

$listStmt = $pdo->query("SELECT id, surname, name, patronymic FROM contacts ORDER BY surname ASC, name ASC");
$contactsList = $listStmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h2>Удаление записи</h2>';
echo $statusMessage;

if (empty($contactsList)) {
    echo '<p>Нет записей для удаления.</p>';
    return;
}

echo '<div class="delete-links">';
foreach ($contactsList as $item) {
    $nInit = $item['name'] !== '' ? mb_substr($item['name'], 0, 1) . '.' : '';
    $pInit = $item['patronymic'] !== '' ? mb_substr($item['patronymic'], 0, 1) . '.' : '';
    $label = trim($item['surname'] . ' ' . $nInit . $pInit);
    echo '<a href="index.php?action=delete&id=' . $item['id'] . '" class="delete-link">' . htmlspecialchars($label) . '</a><br>';
}
echo '</div>';
?>
