<?php
if (!defined('APP_ACCESS')) {
    http_response_code(403);
    exit('Доступ запрещен');
}

function getContactsTable($pdo, $sort = 'id', $page = 1) {
    $limit = 10;
    $offset = ($page - 1) * $limit;

    $orderMap = [
        'id'      => 'id ASC',
        'surname' => 'surname ASC, name ASC',
        'date'    => 'date ASC'
    ];
    $orderBy = $orderMap[$sort] ?? 'id ASC';

    $totalRows = (int)$pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
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

    if (empty($rows)) {
        return '<p>В записной книжке пока нет записей.</p>';
    }

    $html = '<table>
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Пол</th>
            <th>Дата рождения</th>
            <th>Телефон</th>
            <th>Адрес</th>
            <th>Email</th>
            <th>Комментарий</th>
        </tr>';

    foreach ($rows as $row) {
        $html .= '<tr>
            <td>' . htmlspecialchars($row['surname']) . '</td>
            <td>' . htmlspecialchars($row['name']) . '</td>
            <td>' . htmlspecialchars($row['lastname']) . '</td>
            <td>' . htmlspecialchars($row['gender']) . '</td>
            <td>' . htmlspecialchars($row['date']) . '</td>
            <td>' . htmlspecialchars($row['phone']) . '</td>
            <td>' . htmlspecialchars($row['location']) . '</td>
            <td>' . htmlspecialchars($row['email']) . '</td>
            <td>' . htmlspecialchars($row['comment']) . '</td>
        </tr>';
    }
    $html .= '</table>';

    if ($totalRows > $limit) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $sel = ($i === $page) ? ' class="select"' : '';
            $html .= '<a href="index.php?p=view&sort=' . $sort . '&page=' . $i . '"' . $sel . '>' . $i . '</a>';
        }
        $html .= '</div>';
    }

    return $html;
}
?>
