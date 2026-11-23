<?php
define('APP_ACCESS', true);
require_once 'db.php';
require_once 'menu.php';

$pageType = $_GET['p'] ?? 'view';
if (!in_array($pageType, ['view', 'add', 'edit', 'delete'])) {
    $pageType = 'view';
}

$sort = $_GET['sort'] ?? 'id';
if (!in_array($sort, ['id', 'surname', 'date'])) {
    $sort = 'id';
}

$pageNum = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?= getMenu() ?>

<main>
    <?php
    if ($pageType === 'view') {
        require_once 'viewer.php';
        echo getContactsTable($pdo, $sort, $pageNum);
    } elseif ($pageType === 'add') {
        require_once 'add.php';
    } elseif ($pageType === 'edit') {
        require_once 'edit.php';
    } elseif ($pageType === 'delete') {
        require_once 'delete.php';
    }
    ?>
</main>

<footer></footer>

</body>
</html>
