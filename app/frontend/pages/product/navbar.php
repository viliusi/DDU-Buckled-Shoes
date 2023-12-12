<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="index.php">Buckled Shoes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <?php if ($user->isLoggedIn()) : ?>
        <li class="nav-item">
          <a class="nav-link" href="shoes.php">Shoes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">Accessories</a>
        </li>
      <?php endif; ?>
    </ul>

    <?php if ($user->isLoggedIn()) : ?>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="profile.php">
            <span class="glyphicon glyphicon-user"></span> Account
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">
            <span class="glyphicon glyphicon-log-out"></span> 🛒
          </a>
        </li>
      </ul>
    <?php else : ?>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Shoes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">Accessories</a>
          </li>
          </li>
        </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="register.php">
            <span class="glyphicon glyphicon-user"></span> Register
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">
            <span class="glyphicon glyphicon-log-in"></span> Log-in
          </a>
        </li>
      </ul>
    <?php endif; ?>

  </div>
</nav>