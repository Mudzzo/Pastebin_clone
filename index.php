<?php
require_once "config/db.php";
require_once "includes/header.php";
require_once "includes/pagination.php";

$page = isset($_GET['action']) ? $_GET['action'] : 'index';
?>

<?php require_once "includes/navbar.php";?>

<?php if($page == "index"): ?>
<div class="container-fluid mt-auto ms-auto vh-100">
    <div class="container-lg">
        <div class="row d-flex vh-100 justify-content-center align-items-center">
            <div class="col-8  posts-container">
                <table class="table table-dark table-hover snippets-table">
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
                <?php require_once "includes/pagination_bar.php";?>
            </div>
            <?php require_once "includes/search_bar.php";?>
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
<div class="container-fluid  snippet-container d-flex justify-content-center align-items-center flex-column vh-100">
    <h1 class="title mb-3"><?= htmlspecialchars($snippet[0]['title']); ?></h1>
    <div class="content-text p-3 rounded shadow mb-3 d-flex justify-content-center align-items-center">
        <p><?= nl2br(htmlspecialchars($snippet[0]['content'])) ; ?></p>
    </div>
    <h3 class="mb-3">Syntax: <?= htmlspecialchars($snippet[0]['code_lang']); ?></h3>
    <a href="index.php" class="btn btn-login">Back to Home</a>
</div>
<?php endif; ?>
<?php require_once "includes/footer.php";?>