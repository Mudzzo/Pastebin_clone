<?php
require_once "config/db.php";
require_once "includes/header.php";
$page = isset($_GET['action']) ? $_GET['action'] : 'index';
?>

<?php require_once "includes/navbar.php";?>
<?php 
$stmt = $connect->prepare('SELECT * FROM `snippets` ORDER BY `created_at` DESC');
$stmt->execute();
$snippets = $stmt->fetchAll(PDO::FETCH_ASSOC);
//  print_r($snippets);
?>
<?php if($page == "index"): ?>
    <div class="container-fluid p-3 ms-3">
        <div class="row snippets-container">
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
                            foreach($snippets as $index => $snippet):
                        ?>
                            <a>
                                <tr data-href="?action=show&id=<?=$snippet['post_id']?>">
                                <td><?= $snippet['title']?></td>
                                <td><?= htmlspecialchars($snippet['content']) ?></td>
                                <td><?= $snippet['code_lang']?></td>
                                </tr>
                            </a>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="col-4">
                <div class="container posts-container p-4">
                    <form class="d-flex flex-column" action="search.php">
                        <input class="form-control me-2 mb-4" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-login " type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Step 2: Add click event listeners to table rows
        document.addEventListener("DOMContentLoaded", function() {
            const rows = document.querySelectorAll("tr[data-href]");

            rows.forEach(row => {
                row.addEventListener("click", function() {
                    window.location.href = this.dataset.href;
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
    <div class="container-fluid  snippet-container">
        <h1 class="title"><?= htmlspecialchars($snippet[0]['title']); ?></h1>
        <p><?= htmlspecialchars($snippet[0]['content']); ?></p>
        <p><?= htmlspecialchars($snippet[0]['created_at']); ?></p>
    </div>
<?php endif; ?>    
<?php require_once "includes/footer.php";?>