<?php 
$limit = 6;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($current_page - 1) * $limit;


$total_stmt = $connect->prepare('SELECT COUNT(*) FROM snippets');
$total_stmt->execute();
$total_snippets = $total_stmt->fetchColumn();
$total_pages = ceil($total_snippets / $limit);

$stmt = $connect->prepare('SELECT * FROM snippets ORDER BY created_at DESC LIMIT :limit OFFSET :offset');
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$snippets = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>