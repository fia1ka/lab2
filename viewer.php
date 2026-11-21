<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Прямой доступ запрещен');
}

function renderContacts($pdo, $sort = 'id', $page = 1) {
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $orderMap = [
        'id'        => 'id ASC',
        'surname'   => 'surname ASC, name ASC',
        'birthdate' => 'birthdate ASC'
    ];
    $orderBy = $orderMap[$sort] ?? 'id ASC';

    $totalStmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $totalRows = (int)$totalStmt->fetchColumn();
    $totalPages = max(1, (int)ceil($totalRows / $limit));

    if ($page > $totalPages) {
        $page = $totalPages;
        $offset = ($page - 1) * $limit;
    }

    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY $orderBy LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '<h2>Список контактов</h2>';
    if (empty($rows)) {
        $html .= '<p>Записей пока нет.</p>';
        return $html;
    }

    $html .= '<table>
        <thead>
            <tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Пол</th>
                <th>Дата рождения</th>
                <th>Телефон</th>
                <th>Адрес</th>
                <th>E-mail</th>
                <th>Комментарий</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($rows as $row) {
        $html .= '<tr>
            <td>' . htmlspecialchars($row['surname']) . '</td>
            <td>' . htmlspecialchars($row['name']) . '</td>
            <td>' . htmlspecialchars($row['patronymic']) . '</td>
            <td>' . htmlspecialchars($row['gender']) . '</td>
            <td>' . htmlspecialchars($row['birthdate']) . '</td>
            <td>' . htmlspecialchars($row['phone']) . '</td>
            <td>' . htmlspecialchars($row['address']) . '</td>
            <td>' . htmlspecialchars($row['email']) . '</td>
            <td>' . htmlspecialchars($row['comment']) . '</td>
        </tr>';
    }
    $html .= '</tbody></table>';

    if ($totalRows > $limit) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i === $page) ? ' active-page' : '';
            $html .= '<a href="index.php?action=view&sort=' . $sort . '&page=' . $i . '" class="page-link' . $active . '">' . $i . '</a>';
        }
        $html .= '</div>';
    }

    return $html;
}
?>
