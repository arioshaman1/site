
<header>
    <div class="px-3 py-2 bg-dark text-white">
      <div class="container">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
          </a>

          <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
            <li>
              <a href="index.php" class="nav-link text-secondary">
                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#home"></use></svg>
                Home
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#speedometer2"></use></svg>
                Dashboard
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#table"></use></svg>
                Orders
              </a>
            </li>
            <li>
              <a href="#" class="nav-link text-white">
                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#grid"></use></svg>
                Products
              </a>
            </li>
            <li>
              <a href="fake_cart.php" class="nav-link text-white">
                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#people-circle"></use></svg>
                Cart
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="px-3 py-2 border-bottom mb-3">
      <div class="container d-flex flex-wrap justify-content-center">
        

        <div class="text-end">
        <button type="button" class="btn btn-light text-dark me-2" onclick="window.location.href='login.php'">Login</button>
          <button type="button" class="btn btn-primary" onclick="window.location.href = 'registration.php';">Sign-up</button>

        </div>
      </div>
    </div>
  </header>
  <div class="container">
    <div class="row">
    <link rel="stylesheet" type="text/css" href="index.css">

        <?php
        // Подключение к базе данных
        $servername = "localhost";
        $username = "root";
        $password = "mysql";
        $dbname = "autoservice";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Проверка подключения
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL-запрос для извлечения данных о машинах
        $sql = "SELECT * FROM Cars";
        $result = $conn->query($sql);

        // Проверка наличия результатов
        if ($result->num_rows > 0) {
            // Вывод данных о машинах
            while ($row = $result->fetch_assoc()) {
              echo "<div class='col-md-4'>";
              echo "<div class='card h-100'>";
              echo "<img src='" . $row["Photo"] . "' class='card-img-top img-fluid' alt='" . $row["Model"] . "'>";
              echo "<div class='card-body text-center'>";
              echo "<h5 class='card-title'>" . $row["Model"] . "</h5>";
              echo "<p class='card-text'>Year: " . $row["Year"] . "</p>";
              echo "<p class='card-text'>Price: $" . $row["Price"] . "</p>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
              
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        
        ?>






