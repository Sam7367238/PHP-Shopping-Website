<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="Utilities/Images/Logo.png" alt="Logo" width="40" height="40" class="me-2">
            RubyStore
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (empty($_SESSION["User"])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                <?php elseif (!empty($_SESSION["User"])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout"><?= $_SESSION["User"]["Username"] ?> > Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/new">Create Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cart">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/orders">Pending Orders</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>