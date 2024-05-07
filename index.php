
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
              <a href="main.html" class="nav-link text-secondary">
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
              <a href="#" class="nav-link text-white">
                <svg class="bi d-block mx-auto mb-1" width="24" height="24"><use xlink:href="#people-circle"></use></svg>
                Customers
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="px-3 py-2 border-bottom mb-3">
      <div class="container d-flex flex-wrap justify-content-center">
        <form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="text-end">
          <button type="button" class="btn btn-light text-dark me-2">Login</button>
          <button type="button" class="btn btn-primary">Sign-up</button>
        </div>
      </div>
    </div>
  </header>
  <div class="container">
    <div class="row">
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
                echo "<div class='card'>";
                echo "<img src='" . $row["Photo"] . "' class='card-img-top' alt='" . $row["Model"] . "'>";
                echo "<div class='card-body'>";
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









<footer id="footer" class="footer-1">
<div class="main-footer widgets-dark typo-light">
<div class="container">
<div class="row">
   
<div class="col-xs-12 col-sm-6 col-md-3">
<div class="widget subscribe no-box">
<h5 class="widget-title">АВТОСЕРВИС<span></span></h5>
<p>Наш АВТОСЕРВИС самый лучший приезжайте мы ваще крутые лучши </p>
</div>
</div>

<div class="col-xs-12 col-sm-6 col-md-3">
<div class="widget no-box">
<h5 class="widget-title">Quick Links<span></span></h5>
<ul class="thumbnail-widget">
<li>
<div class="thumb-content"><a href="#.">Get Started</a></div>  
</li>
<li>
<div class="thumb-content"><a href="#.">Top Leaders</a></div>  
</li>
<li>
<div class="thumb-content"><a href="#.">Success Stories</a></div>  
</li>
<li>
<div class="thumb-content"><a href="#.">Event/Tickets</a></div>  
</li>
<li>
<div class="thumb-content"><a href="#.">News</a></div>  
</li>
<li>
<div class="thumb-content"><a href="#.">Lifestyle</a></div>  
</li>
<li>
<div class="thumb-content"><a href="#.">About</a></div>  
</li>
</ul>
</div>
</div>

<div class="col-xs-12 col-sm-6 col-md-3">
<div class="widget no-box">
<h5 class="widget-title">Get Started<span></span></h5>
<p>Get access to your full Training and Marketing Suite.</p>
<a class="btn" href="#." target="_blank">Register Now</a>
</div>
</div>

<div class="col-xs-12 col-sm-6 col-md-3">

<div class="widget no-box">
<h5 class="widget-title">Contact Us<span></span></h5>

<p><a href="mailto:info@domain.com" title="glorythemes">info@domain.com</a></p>
<ul class="social-footer2">
<li class=""><a title="youtube" target="_blank" href="/"><img alt="youtube" width="30" height="30" src=""></a></li>
<li class=""><a href="/" target="_blank" title="Facebook"><img alt="Facebook" width="30" height="30" src=""></a></li>
<li class=""><a href="/" target="_blank" title="Twitter"><img alt="Twitter" width="30" height="30" src=""></a></li>
<li class=""><a title="instagram" target="_blank" href="/"><img alt="instagram" width="30" height="30" src=""></a></li>
</ul>
</div>
</div>

</div>
</div>
</div>
   
<div class="footer-copyright">
<div class="container">
<div class="row">
<div class="col-md-12 text-center">
<p>Copyright Company Name © 2016. All rights reserved.</p>
</div>
</div>
</div>
</div>
</footer>
