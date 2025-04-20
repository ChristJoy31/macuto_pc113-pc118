
<!-- footer.php -->
<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">Are you sure you want to log out?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button id="confirmLogout" type="button" class="btn btn-danger">Logout</button>
      </div>
    </div>
  </div>
</div>

<!-- Logout Script -->
<script>
document.getElementById("confirmLogout").addEventListener("click", function () {
    localStorage.removeItem("token");
    window.location.href = "login.php";
});
</script>




<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>


<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap JS (Required for dropdown functionality) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/js/dropify.min.js"></script>


</body>
</html>
