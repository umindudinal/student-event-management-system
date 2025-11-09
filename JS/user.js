document.getElementById('addUserBtn').onclick = () => {
   document.getElementById('addUserModal').style.display = 'block';
};
document.querySelectorAll('.editUserBtn').forEach(btn => {
   btn.addEventListener('click', () => {
      document.getElementById('edit_registration_no').value = btn.dataset.reg;
      document.getElementById('edit_full_name').value = btn.dataset.name;
      document.getElementById('edit_email').value = btn.dataset.email;
      document.getElementById('edit_phone').value = btn.dataset.phone;
      document.getElementById('editUserModal').style.display = 'block';
   });
});
document.querySelectorAll('.close_btn a').forEach(btn => {
   btn.addEventListener('click', e => {
      e.preventDefault();
      btn.closest('.modal').style.display = 'none';
   });
});