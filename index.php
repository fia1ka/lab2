<?php
define('APP_ACCESS', true);
require_once 'db.php';
require_once 'menu.php';

$action = $_GET['action'] ?? 'view';
$allowed_actions = ['view', 'add', 'edit', 'delete'];
if (!in_array($action, $allowed_actions)) {
    $action = 'view';
}

$sort = $_GET['sort'] ?? 'id';
$allowed_sorts = ['id', 'surname', 'birthdate'];
if (!in_array($sort, $allowed_sorts)) {
    $sort = 'id';
}

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <?= renderMenu($action, $sort) ?>
</header>

<main>
    <?php
    if ($action === 'view') {
        require_once 'viewer.php';
        echo renderContacts($pdo, $sort, $page);
    } elseif ($action === 'add') {
        require_once 'add.php';
    } elseif ($action === 'edit') {
        require_once 'edit.php';
    } elseif ($action === 'delete') {
        require_once 'delete.php';
    }
    ?>
</main>

</body>
</html>
