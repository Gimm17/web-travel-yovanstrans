<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login — Admin YovansTranss</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
</head>
<body class="login-page">
  <div class="login-card">
    <div style="text-align:center;margin-bottom:1.5rem">
      <i class="fas fa-shuttle-van" style="font-size:2.5rem;color:var(--blue-500)"></i>
    </div>
    <h1 class="login-title">YOVANS<span style="color:var(--yellow-500)">TRANS</span></h1>
    <p class="login-subtitle">Login ke panel admin</p>

    <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error; ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/login'); ?>">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="admin@example.com" required>
      </div>
      <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-blue btn-lg btn-block" style="margin-top:1rem">
        <i class="fas fa-sign-in-alt"></i> Login
      </button>
    </form>
    <p style="text-align:center;margin-top:1.5rem;font-size:.85rem;color:var(--gray-400)">
      <a href="<?= base_url(); ?>" style="color:var(--blue-500)"><i class="fas fa-arrow-left"></i> Kembali ke website</a>
    </p>
  </div>
</body>
</html>
