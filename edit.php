<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Прямой доступ запрещен');
}

$statusMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id         = (int)$_POST['id'];
    $surname    = trim($_POST['surname'] ?? '');
    $name       = trim($_POST['name'] ?? '');
    $patronymic = trim($_POST['patronymic'] ?? '');
    $gender     = trim($_POST['gender'] ?? '');
    $birthdate  = trim($_POST['birthdate'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $comment    = trim($_POST['comment'] ?? '');

    try {
        $stmt = $pdo->prepare("UPDATE contacts SET surname=?, name=?, patronymic=?, gender=?, birthdate=?, phone=?, address=?, email=?, comment=? WHERE id=?");
        $stmt->execute([$surname, $name, $patronymic, $gender, $birthdate, $phone, $address, $email, $comment, $id]);
        $statusMessage = '<p class="msg-success">Запись обновлена</p>';
    } catch (Exception $e) {
        $statusMessage = '<p class="msg-error">Ошибка при обновлении записи</p>';
    }
}

$listStmt = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname ASC, name ASC");
$contactsList = $listStmt->fetchAll(PDO::FETCH_ASSOC);

echo '<h2>Редактирование записи</h2>';
echo $statusMessage;

if (empty($contactsList)) {
    echo '<p>Нет записей для редактирования.</p>';
    return;
}

$currentId = isset($_GET['id']) ? (int)$_GET['id'] : (int)$contactsList[0]['id'];

echo '<div class="edit-links">';
foreach ($contactsList as $item) {
    $isCurrent = ((int)$item['id'] === $currentId) ? ' current-item' : '';
    echo '<a href="index.php?action=edit&id=' . $item['id'] . '" class="edit-link' . $isCurrent . '">'
        . htmlspecialchars($item['surname'] . ' ' . $item['name']) . '</a> ';
}
echo '</div>';

$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
$stmt->execute([$currentId]);
$current = $stmt->fetch(PDO::FETCH_ASSOC);

if ($current):
?>
<form method="POST" action="index.php?action=edit&id=<?= $current['id'] ?>" class="contact-form">
    <input type="hidden" name="id" value="<?= $current['id'] ?>">
    <label>Фамилия: <input type="text" name="surname" value="<?= htmlspecialchars($current['surname']) ?>" required></label>
    <label>Имя: <input type="text" name="name" value="<?= htmlspecialchars($current['name']) ?>" required></label>
    <label>Отчество: <input type="text" name="patronymic" value="<?= htmlspecialchars($current['patronymic']) ?>"></label>
    <label>Пол:
        <select name="gender">
            <option value="Мужской" <?= $current['gender'] === 'Мужской' ? 'selected' : '' ?>>Мужской</option>
            <option value="Женский" <?= $current['gender'] === 'Женский' ? 'selected' : '' ?>>Женский</option>
        </select>
    </label>
    <label>Дата рождения: <input type="date" name="birthdate" value="<?= htmlspecialchars($current['birthdate']) ?>" required></label>
    <label>Телефон: <input type="text" name="phone" value="<?= htmlspecialchars($current['phone']) ?>" required></label>
    <label>Адрес: <input type="text" name="address" value="<?= htmlspecialchars($current['address']) ?>"></label>
    <label>E-mail: <input type="email" name="email" value="<?= htmlspecialchars($current['email']) ?>"></label>
    <label>Комментарий: <textarea name="comment" rows="3"><?= htmlspecialchars($current['comment']) ?></textarea></label>
    <button type="submit" class="submit-btn">Сохранить изменения</button>
</form>
<?php endif; ?>
