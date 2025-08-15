<?php
// Ensure session is available for conditional links
if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
  </main>

  <!-- Footer (matches header styling) -->
<!-- Footer -->
<footer class="border-top py-4 mt-5 bg-light">
  <div class="container text-center text-muted small">
    &copy; <?= date('Y') ?> Smart CookBook
  </div>
</footer>
</body>
</html>
