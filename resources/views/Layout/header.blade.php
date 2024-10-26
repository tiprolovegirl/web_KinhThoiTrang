<header class="py-3">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ URL('images/LOGO.png') }}" width="65" alt="Logo" class="">
            </a>
        </div>

        <!-- Authentication Links -->
        <div>
            <a href="#" class="me-2 text-decoration-none text-dark btn btn-outline-secondary border-0">Register</a>
            <a href="#" class="me-2 text-decoration-none text-dark btn btn-outline-secondary border-0">Login</a>
        </div>
    </div>

    <!-- Search and Icons -->
    <div class="container my-3">
        <div class="d-flex align-items-center">

                <form id="searchForm" action="{{ route('product.search') }}" method="GET" class="input-group me-2">
                    <input type="text" name="query" id="searchQuery" class="form-control me-2" placeholder="Search for products..." aria-label="Search">
                    <select class="form-select">
                        <option>All categories</option>
                    </select>
                    <button type="submit" class="btn btn-outline-secondary">🔍</button>
                </form>

            <span class="me-2 position-relative">
                <a href="{{ route('favorite.index') }}"
                    class="text-decoration-none text-dark btn btn-outline-secondary border-0">
                    <i class="bi bi-heart"></i>
                    <span id="favorite-count"
                        class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
                </a>
            </span>
            <span class="position-relative">
                <a href="{{ route('cart.index') }}"
                    class="text-decoration-none text-dark btn btn-outline-secondary border-0">
                    <i class="bi bi-cart"></i>
                    <span id="cart-count"
                        class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
                    <!-- Default to 0 -->
                </a>
            </span>
            <style>
                .position-relative {
                    display: inline-block;
                }

                .position-absolute {
                    position: absolute;
                    border-radius: 50%;
                }

                .top-0 {
                    top: 0;
                }

                .start-100 {
                    left: 100%;
                }

                .translate-middle {
                    transform: translate(-80%, -20%) !important;
                }
            </style>
           <script>
            function fetchCounts() {
                // Fetch cart count
                fetch("{{ route('cart.count') }}")
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('cart-count').innerText = data.count || 0;
                    })
                    .catch(error => console.error('Error fetching cart count:', error));

                // Fetch favorite count
                fetch("{{ route('favorite.count') }}")
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('favorite-count').innerText = data.count || 0;
                    })
                    .catch(error => console.error('Error fetching favorite count:', error));
            }

            // Load counts on window load
            window.onload = fetchCounts;
        </script>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-secondary">
        <div class="container">
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Blog</a>
                </li>

                <!-- Categories with Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="categoriesDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                        <li><a class="dropdown-item" href="#">Category 1</a></li>
                        <li><a class="dropdown-item" href="#">Category 2</a></li>
                        <li><a class="dropdown-item" href="#">Category 3</a></li>
                        <li><a class="dropdown-item" href="#">Category 4</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Contact</a>
                </li>
            </ul>

        </div>
    </nav>

</header>
