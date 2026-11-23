<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Доступ запрещен');
}

function getMenu() {
    $current = $_GET['p'] ?? 'view';
    if (!in_array($current, ['view', 'add', 'edit', 'delete'])) {
        $current = 'view';
    }

    $sort = $_GET['sort'] ?? 'id';
    if (!in_array($sort, ['id', 'surname', 'date'])) {
        $sort = 'id';
    }

    $items = [
        'view'   => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];

    $html = '<header>';
    foreach ($items as $key => $title) {
        $class = ($current === $key) ? ' class="select"' : '';
        $html .= '<a href="index.php?p=' . $key . '"' . $class . '>' . $title . '</a>';
    }
    $html .= '</header>';

    if ($current === 'view') {
        $subItems = [
            'id'      => 'По порядку добавления',
            'surname' => 'По фамилии',
            'date'    => 'По дате рождения'
        ];
        $html .= '<div class="submenu">';
        foreach ($subItems as $sKey => $sTitle) {
            $sClass = ($sort === $sKey) ? ' class="select"' : '';
            $html .= '<a href="index.php?p=view&sort=' . $sKey . '"' . $sClass . '>' . $sTitle . '</a>';
        }
        $html .= '</div>';
    }

    return $html;
}
?>
