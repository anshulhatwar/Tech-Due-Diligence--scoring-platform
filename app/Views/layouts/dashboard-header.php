<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'Credence') ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<header class="navbar">
  <button id="sidebar-toggle" class="hamburger-btn">
    <span class="bar bar1"></span>
    <span class="bar bar2"></span>
    <span class="bar bar3"></span>
  </button>
  <a href="<?= base_url('dashboard') ?>" class="brand-logo">
    <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:34px;">
    <div>
      <div class="brand-title">Tech Due-Diligence & Trust Score</div>
      <span class="brand-sub">Verification & Assessment Platform</span>
    </div>
  </a>
  <div class="nav-controls">
    <div class="nav-user-info">
      <div class="nav-user-avatar"><?= esc($userInitials ?? 'U') ?></div>
      <span><?= esc($userName ?? 'User') ?></span>
    </div>
    <button class="nav-logout-btn" id="btn-logout">Logout</button>
  </div>
</header>

<div class="app-container">
  <aside class="sidebar">
    <?= $sidebar ?? '' ?>
  </aside>
  <main class="main-content">
    