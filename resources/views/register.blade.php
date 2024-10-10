<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vaccination Portal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Vaccination Portal</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <button id="searchButton" class="btn btn-outline-primary">Search Status</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="registerSection" class="card mb-4">
            <div class="card-body">
                <h4>Register for Vaccination</h4>
                <form id="registerForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback" id="nameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                        <div class="invalid-feedback" id="phoneError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="nid" class="form-label">NID</label>
                        <input type="text" class="form-control" id="nid" name="nid" required>
                        <div class="invalid-feedback" id="nidError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="center" class="form-label">Vaccine Center</label>
                        <select class="form-select" id="center" name="vaccine_center_id" required></select>
                        <div class="invalid-feedback" id="centerError"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <div id="registerResponse" class="mt-3"></div>
            </div>
        </div>

        <div id="searchSection" class="card mb-4 d-none">
            <div class="card-body">
                <h4>Search Vaccination Status</h4>
                <form id="searchForm">
                    <div class="mb-3">
                        <label for="searchNid" class="form-label">Enter NID</label>
                        <input type="text" class="form-control" id="searchNid" name="searchNid" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Search Status</button>
                </form>
                <div id="searchResponse" class="mt-3"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
