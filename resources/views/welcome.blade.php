<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f8f9fa;
    }
    .card {
      width: 100%;
      max-width: 400px;
    }
  </style>
</head>
<body>

  <div class="card shadow">
    <div class="card-body">
      <h4 class="card-title text-center mb-4">Login</h4>
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="text" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
