<?php
require_once 'config/db.php';
require_once "includes/header.php";
require_once "includes/navbar.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: user.php");
    exit();
}

$snippet_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$stmt = $connect->prepare("SELECT title, content, code_lang FROM snippets WHERE post_id = :id AND user_id = :user_id");
$stmt->execute([':id' => $snippet_id, ':user_id' => $user_id]);
$snippet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$snippet) {
    $_SESSION['error_msg'] = "Snippet not found or you don't have permission to edit it.";
    header("Location: user.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $syntax = $_POST['code_lang'];

    if (!empty($title) && !empty($content) && !empty($syntax)) {
        $update_stmt = $connect->prepare("UPDATE snippets SET title = :title, content = :content, code_lang = :syntax WHERE post_id = :id AND user_id = :user_id");
        $update_stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':syntax' => $syntax,
            ':id' => $snippet_id,
            ':user_id' => $user_id
        ]);
        $_SESSION['success_msg'] = "Snippet updated successfully.";
        header("Location: profile.php");
        exit();
    } else {
        $error = "All fields are required.";
    }
}
?>

<div class="container-fluid mt-auto py-3 vh-100">
    <div class="container-lg">
        <div class="row d-flex vh-100 justify-content-center align-items-center">
            <div class="col-8">
                <div class="card bg-dark text-light p-4 rounded-3 shadow-lg">
                    <h2 class="text-center mb-4">Edit Snippet</h2>
                    <?php if (isset($error)): ?>
                    <div class="alert alert-danger"> <?= $error ?> </div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="title" class="form-control bg-secondary text-light border-0"
                                value="<?= htmlspecialchars($snippet['title']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Content</label>
                            <textarea name="content" class="form-control bg-secondary text-light border-0" rows="5"
                                required><?= htmlspecialchars($snippet['content']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Syntax</label>
                            <select name="code_lang" class="form-control bg-secondary text-light border-0" required>
                                <option value="<?= $snippet['code_lang'] ?>" selected>
                                    <?= ucfirst($snippet['code_lang']) ?></option>
                                    <option value="plaintext">Plain Text</option>
                                <option value="php">PHP</option>
                                <option value="javascript">JavaScript</option>
                                <option value="typescript">TypeScript</option>
                                <option value="python">Python</option>
                                <option value="java">Java</option>
                                <option value="c">C</option>
                                <option value="cpp">C++</option>
                                <option value="csharp">C#</option>
                                <option value="ruby">Ruby</option>
                                <option value="swift">Swift</option>
                                <option value="go">Go</option>
                                <option value="rust">Rust</option>
                                <option value="kotlin">Kotlin</option>
                                <option value="dart">Dart</option>
                                <option value="r">R</option>
                                <option value="scala">Scala</option>
                                <option value="lua">Lua</option>
                                <option value="perl">Perl</option>
                                <option value="shell">Shell Script</option>
                                <option value="powershell">PowerShell</option>
                                <option value="sql">SQL</option>
                                <option value="html">HTML</option>
                                <option value="css">CSS</option>
                                <option value="sass">SASS</option>
                                <option value="less">LESS</option>
                                <option value="json">JSON</option>
                                <option value="xml">XML</option>
                                <option value="yaml">YAML</option>
                                <option value="markdown">Markdown</option>
                                <option value="latex">LaTeX</option>
                                <option value="vb">Visual Basic</option>
                                <option value="assembly">Assembly</option>
                                <option value="matlab">MATLAB</option>
                                <option value="fortran">Fortran</option>
                                <option value="haskell">Haskell</option>
                                <option value="coffeescript">CoffeeScript</option>
                                <option value="elixir">Elixir</option>
                                <option value="erlang">Erlang</option>
                                <option value="clojure">Clojure</option>
                                <option value="fsharp">F#</option>
                                <option value="prolog">Prolog</option>
                                <option value="verilog">Verilog</option>
                                <option value="vhdl">VHDL</option>
                                <option value="abap">ABAP</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-login w-100 fw-bold">Update Snippet</button>
                    </form>
                    <a href="profile.php" class="btn btn-login mt-3 w-100 fw-bold">Back to Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>