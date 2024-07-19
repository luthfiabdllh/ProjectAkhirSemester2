<nav class="navbar navbar-dark navbar-expand-lg bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item align-items-center">
            <a class="nav-link" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ticket.php">Ticket</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="schedule.php">Schedule</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="route.php">Route</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="transport.php">Transport</a>
          </li>
          <li class="nav-item">
            <a href="logout.php"><button class="btn btn-danger">Logout</button></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>