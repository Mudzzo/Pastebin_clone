
<nav class="navbar navbar-expand-lg nav-bg">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PasteBin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <div class="container-fluid d-flex">
        <ul class="navbar-nav me-4 mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <?php if(isset($_SESSION["IsLoggedIn"])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="create_snippet.php">Create Snippet</a>
                </li>
            <?php else: ?>  
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Create Snippet</a>
                </li>
            <?php endif; ?>
        </ul>

        
    </div>
      <?php if(isset($_SESSION["IsLoggedIn"])): ?>
        
        <form class="d-flex justify-content-evenly align-items-center logout-container" action="logout.php" method="POST">
            <a class="p-1 mb-0 me-4"><?php echo htmlspecialchars($_SESSION['FULL_NAME']);?></a>
            <button class="btn btn-login ms-2" type="submit">LOGOUT</button>
        </form>
      <?php else: ?>  
       <a class="btn btn-login ms-2" href="login.php">LOGIN</a>
      <?php endif; ?>
    </div>
  </div>
</nav>