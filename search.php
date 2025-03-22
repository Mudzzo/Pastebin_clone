<?php 
require_once "config/db.php";
require_once "includes/header.php";
require_once "includes/navbar.php";

if(!isset($_SESSION['IsLoggedIn'])){
    header('Location:index.php');
}

if(isset($_GET['query']) && !empty($_GET['query'])){
    $search = isset($_GET['query']) ? trim($_GET['query']) : "";

    $limit = 6;
    $current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($current_page - 1) * $limit;

    $total_stmt = $connect->prepare("SELECT COUNT(*) FROM snippets WHERE title LIKE :search");
    $total_stmt->execute([':search' => "%$search%"]);
    $total_snippets = $total_stmt->fetchColumn();
    $total_pages = ceil($total_snippets / $limit);

    $stmt = $connect->prepare("SELECT * FROM snippets WHERE title LIKE :search ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}else{
    header('Location:index.php');
}
?>

<?php if (!empty($results)): ?>
    <div class="container-fluid mt-auto ms-auto py-3 vh-100">
        <div class="container-lg">
            <div class="row d-flex vh-100 justify-content-center align-items-center">
                <div class="col-8  posts-container">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col">Syntax</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($results as $snippet):
                            ?>
                                <a>
                                    <tr data-href="index.php?action=show&id=<?=$snippet['post_id']?>">
                                    <td><?= $snippet['title']?></td>
                                    <td><?php
                                        $content = htmlspecialchars($snippet['content']);
                                        $lines = explode("\n", $content);
                                        $limitedText = implode("", array_slice($lines, 0, 3));
                                        echo nl2br($limitedText);
                                        ?>
                                    </td>
                                    <td><?= $snippet['code_lang']?></td>
                                    </tr>
                                </a>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?query=<?= urlencode($search) ?>&page=<?= $current_page - 1 ?>">Previous</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= ($i === $current_page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?query=<?= urlencode($search) ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?query=<?= urlencode($search) ?>&page=<?= $current_page + 1 ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    
                </div>
                <?php require_once "includes/search_bar.php";?>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll("tr[data-href]").forEach(row => {
                    row.addEventListener("click", function () {
                        window.location.href = this.getAttribute("data-href");
                    });
                });
            });
        </script>


<?php elseif ($page == 'show'): ?>
    <?php 
        $snippetId = intval($_GET['id']) ? $_GET['id'] : header("Location: index.php");
        $stmt = $connect->prepare("SELECT * FROM `snippets` WHERE `post_id` =?");
        $stmt->execute([$snippetId]);
        $snippet = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <div class="container-fluid  snippet-container d-flex justify-content-center align-items-center flex-column vh-100">
        <h1 class="title mb-3"><?= htmlspecialchars($snippet[0]['title']); ?></h1>
        <div class="content-text p-3 rounded shadow mb-3">
            <p><?= nl2br(htmlspecialchars($snippet[0]['content'])) ; ?></p>
        </div>
        <p class="mb-3"><?= htmlspecialchars($snippet[0]['created_at']); ?></p>
    </div>
<?php else: ?>
    <div class="container-fluid mt-auto ms-auto py-3 vh-100">
        <div class="container-lg">
            <div class="row d-flex vh-100 justify-content-center align-items-center">
                <div class="col-8  posts-container vh-30 d-flex justify-content-center align-items-center">
                    <p>No matching snippets found! </p>
                </div>
                <div class="col-4">
                    <div class="container search-container p-4">
                        <form class="d-flex flex-column" action="search.php" method="GET">
                            <input class="form-control me-2 mb-4" type="search" placeholder="Search" aria-label="Search" name="query">
                            <button class="btn btn-login" type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php endif; ?>
<?php require_once "includes/footer.php";?>