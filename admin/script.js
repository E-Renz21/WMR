function showPanel(panelId) {
  const panels = document.querySelectorAll('.content-panel');
  panels.forEach(panel => panel.style.display = 'none');
  document.getElementById(panelId).style.display = 'block';
}

function initModal() {
  const modal = document.getElementById('deliveryDetailsModal');
  const closeBtn = document.querySelector('.close-btn');
  
  document.querySelectorAll('.more-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      modal.style.display = 'block';
    });
  });
  
  closeBtn.addEventListener('click', function() {
    modal.style.display = 'none';
  });
  
  window.addEventListener('click', function(event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
}

function initTableButtons() {
  document.querySelectorAll('.approve-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const row = this.closest('tr');
      row.style.backgroundColor = '#e8f5e9';
    });
  });
  
  document.querySelectorAll('.reject-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const row = this.closest('tr');
      row.style.backgroundColor = '#ffebee';
    });
  });
}

function initStatusButtons() {
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      // Edit status functionality
    });
  });
}

window.onload = () => {
  showPanel('requests');
  
  fetch('header.html')
    .then(res => res.text())
    .then(data => document.getElementById('header-container').innerHTML = data)
    .catch(err => console.error('Error loading header:', err));

  fetch('menu.html')
    .then(res => res.text())
    .then(data => document.getElementById('menu-container').innerHTML = data)
    .catch(err => console.error('Error loading menu:', err));

  fetch('requests.html')
    .then(res => res.text())
    .then(data => {
      document.getElementById('requests').innerHTML = data;
      initModal();
      initTableButtons();
    })
    .catch(err => console.error('Error loading requests:', err));

  fetch('status.html')
    .then(res => res.text())
    .then(data => {
      document.getElementById('status').innerHTML = data;
      initStatusButtons();
    })
    .catch(err => console.error('Error loading status:', err));

  fetch('inquiries.html')
    .then(res => res.text())
    .then(data => document.getElementById('inquiries').innerHTML = data)
    .catch(err => console.error('Error loading inquiries:', err));

  fetch('clients.html')
    .then(res => res.text())
    .then(data => document.getElementById('clients').innerHTML = data)
    .catch(err => console.error('Error loading clients:', err));
};