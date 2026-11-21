<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Прямой доступ запрещен');
}

function renderMenu($activeAction = 'view', $activeSort = 'id') {
    $mainItems = [
        'view'   => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];

    $html = '<nav class="main-menu">';
    foreach ($mainItems as $key => $label) {
        $activeClass = ($activeAction === $key) ? ' active' : '';
        $html .= '<a href="index.php?action=' . $key . '" class="menu-btn' . $activeClass . '">' . $label . '</a>';
    }
    $html .= '</nav>';

    if ($activeAction === 'view') {
        $sortItems = [
            'id'        => 'По порядку добавления',
            'surname'   => 'По фамилии',
            'birthdate' => 'По дате рождения'
        ];
        $html .= '<nav class="sub-menu">';
        foreach ($sortItems as $sKey => $sLabel) {
            $subActiveClass = ($activeSort === $sKey) ? ' active' : '';
            $html .= '<a href="index.php?action=view&sort=' . $sKey . '" class="submenu-btn' . $subActiveClass . '">' . $sLabel . '</a>';
        }
        $html .= '</nav>';
    }

    return $html;
}
?>
