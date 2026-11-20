<div class="role-nav role-startup">
  <div class="sidebar-title">Startup Portal</div>
  <a class="nav-link <?= $active === 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
    Dashboard & Status
  </a>
  <a class="nav-link <?= $active === 'profile' ? 'active' : '' ?>" href="<?= base_url('profile') ?>">
    Company Profile
  </a>
  <a class="nav-link <?= $active === 'documents' ? 'active' : '' ?>" href="<?= base_url('documents') ?>">
    Document Manager
  </a>
  <a class="nav-link <?= $active === 'apply' ? 'active' : '' ?>" href="<?= base_url('apply') ?>">
    Assessment Application
  </a>
</div>