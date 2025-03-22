<?php if(isset($_SESSION["IsLoggedIn"])): ?>
<div class="col-4">
    <div class="container search-container p-4">
        <form class="d-flex flex-column" action="search.php" method="GET">
            <input class="form-control me-2 mb-4" type="search" placeholder="Search By Title"
                aria-label="Search" name="query">
            <button class="btn btn-login " type="submit">Search</button>
        </form>
    </div>
</div>
<?php endif; ?>