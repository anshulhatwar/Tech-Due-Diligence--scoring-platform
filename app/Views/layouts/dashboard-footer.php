  </main>
</div>

<script>
document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
  document.querySelector('.sidebar').classList.toggle('collapsed');
  this.classList.toggle('active');
});

document.getElementById('btn-logout')?.addEventListener('click', async function() {
  await fetch('<?= base_url('api/logout') ?>', { method: 'POST' });
  window.location.href = '<?= base_url('login') ?>';
});
</script>
</body>
</html>