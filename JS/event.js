document.querySelectorAll('.editBtn').forEach(btn => {
   btn.addEventListener('click', () => {
      document.getElementById('edit_event_code').value = btn.dataset.code;
      document.getElementById('edit_event_title').value = btn.dataset.title;
      document.getElementById('edit_event_date').value = btn.dataset.date;
      document.getElementById('edit_event_venue').value = btn.dataset.venue;
      document.getElementById('edit_event_description').value = btn.dataset.description;
      document.getElementById('editEventModal').style.display = 'block';
   });
});
document.querySelectorAll('.close_btn a').forEach(btn => {
   btn.addEventListener('click', e => {
      e.preventDefault();
      btn.closest('.modal').style.display = 'none';
   });
});
document.getElementById('addEventBtn').onclick = () => {
   document.getElementById('addEventModal').style.display = 'block';
};