<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Доступ запрещен');
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surname  = trim($_POST['surname'] ?? '');
    $name     = trim($_POST['name'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $gender   = trim($_POST['gender'] ?? '');
    $date     = trim($_POST['date'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $comment  = trim($_POST['comment'] ?? '');

    if ($surname !== '' && $name !== '' && $date !== '' && $phone !== '') {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (surname, name, lastname, gender, date, phone, location, email, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$surname, $name, $lastname, $gender, $date, $phone, $location, $email, $comment]);
            $msg = '<div class="success">Запись добавлена</div>';
        } catch (Exception $e) {
            $msg = '<div class="error">Ошибка: запись не добавлена</div>';
        }
    } else {
        $msg = '<div class="error">Ошибка: запись не добавлена</div>';
    }
}

$row = [
    'surname'  => '',
    'name'     => '',
    'lastname' => '',
    'gender'   => '',
    'date'     => '',
    'phone'    => '',
    'location' => '',
    'email'    => '',
    'comment'  => ''
];
$button = 'Добавить';
?>

<?= $msg ?>

<form name="form_add" method="post">
    <div class="column">
        <div class="add">
            <label>Фамилия</label> <input type="text" name="surname" placeholder="Фамилия" value="<?=htmlspecialchars($row['surname']);?>" required>
        </div>
        <div class="add">
            <label>Имя</label> <input type="text" name="name" placeholder="Имя" value="<?=htmlspecialchars($row['name']);?>" required>
        </div>
        <div class="add">
            <label>Отчество</label> <input type="text" name="lastname" placeholder="Отчество" value="<?=htmlspecialchars($row['lastname']);?>">
        </div>
        <div class="add">
            <label>Пол</label> 
            <select name="gender">
                <option value="мужской">мужской</option>
                <option value="женский">женский</option>
            </select>
        </div>
        <div class="add">
            <label>Дата рождения</label> <input type="date" name="date" value="<?=htmlspecialchars($row['date']);?>" required>
        </div>
        <div class="add">
            <label>Телефон</label> <input type="text" name="phone" placeholder="Телефон" value="<?=htmlspecialchars($row['phone']);?>" required>
        </div>
        <div class="add">
            <label>Адрес</label> <input type="text" name="location" placeholder="Адрес" value="<?=htmlspecialchars($row['location']);?>"> 
        </div>
        <div class="add">
            <label>Email</label> <input type="email" name="email" placeholder="Email" value="<?=htmlspecialchars($row['email']);?>">
        </div>
        <div class="add">
            <label>Комментарий</label> <textarea name="comment" placeholder="Краткий комментарий"><?=htmlspecialchars($row['comment']);?></textarea>
        </div>
    
        <button type="submit" value="<?=$button;?>" name="button" class="form-btn"><?=$button;?></button>
    </div>
</form>
