<?php 
require_once "config/db.php";
require_once "includes/header.php";
require_once "includes/navbar.php";

if(!isset($_SESSION['IsLoggedIn'])){
    header('Location:index.php');
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $code_lang = trim($_POST["code_lang"]);

    if (!empty($title) && !empty($content) && !empty($code_lang)) {
        $stmt = $connect->prepare("INSERT INTO snippets (user_id, title, content, code_lang, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$user_id ,$title, $content, $code_lang]);
        $success = "Snippet added successfully!";
    } else {
        $error = "All fields are required!";
    }
}
?>


<div class="container-fluid mt-auto vh-100">
    <div class="container-lg">
        <div class="row d-flex vh-100 justify-content-center align-items-center">
            <div class="col-8">
                <div class="card bg-dark text-light p-4 rounded-3 shadow-lg">
                    <h2 class="text-center mb-4">Create New Snippet</h2>

                    <!-- Display success or error message -->
                    <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?= $success ?></div>
                    <?php elseif (isset($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Title</label>
                            <input type="text" name="title" class="form-control bg-secondary text-light border-0"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Content</label>
                            <textarea name="content" class="form-control bg-secondary text-light border-0" rows="5"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Syntax</label>
                            <select name="code_lang" class="form-control bg-secondary text-light border-0" required>
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

                        <button type="submit" class="btn btn-login w-100 fw-bold">Submit Snippet</button>
                    </form>

                    <a href="index.php" class="btn btn-login mt-3 w-100 fw-bold" >Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>