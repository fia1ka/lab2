<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Прямой доступ запрещен');
}

$statusMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surname    = trim($_POST['surname'] ?? '');
    $name       = trim($_POST['name'] ?? '');
    $patronymic = trim($_POST['patronymic'] ?? '');
    $gender     = trim($_POST['gender'] ?? '');
    $birthdate  = trim($_POST['birthdate'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $comment    = trim($_POST['comment'] ?? '');

    if ($surname !== '' && $name !== '' && $birthdate !== '' && $phone !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (surname, name, patronymic, gender, birthdate, phone, address, email, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$surname, $name, $patronymic, $gender, $birthdate, $phone, $address, $email, $comment]);
            $statusMessage = '<p class="msg-success">Запись добавлена</p>';
        } catch (Exception $e) {
            $statusMessage = '<p class="msg-error">Ошибка: запись не добавлена</p>';
        }
    } else {
        $statusMessage = '<p class="msg-error">Ошибка: запись не добавлена</p>';
    }
}
?>

<h2>Добавление записи</h2>
<?= $statusMessage ?>

<form method="POST" action="index.php?action=add" class="contact-form">
    <label>Фамилия: <input type="text" name="surname" required></label>
    <label>Имя: <input type="text" name="name" required></label>
    <label>Отчество: <input type="text" name="patronymic"></label>
    <label>Пол:
        <select name="gender">
            <option value="Мужской">Мужской</option>
            <option value="Женский">Женский</option>
        </select>
    </label>
    <label>Дата рождения: <input type="date" name="birthdate" required></label>
    <label>Телефон: <input type="text" name="phone" required></label>
    <label>Адрес: <input type="text" name="address"></label>
    <label>E-mail: <input type="email" name="email"></label>
    <label>Комментарий: <textarea name="comment" rows="3"></textarea></label>
    <button type="submit" class="submit-btn">Добавить</button>
</form>
