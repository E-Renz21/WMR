function showPanel(panelId) {
  const panels = document.querySelectorAll('.content-panel');
  panels.forEach(panel => panel.style.display = 'none');
  document.getElementById(panelId).style.display = 'block';
}

// Modal functionality
function initModal() {
  const modal = document.getElementById('deliveryDetailsModal');
  const closeBtn = document.querySelector('.close-btn');
  
  // Open modal when 3-dot button is clicked
  document.querySelectorAll('.more-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      modal.style.display = 'block';
    });
  });
  
  // Close modal when X is clicked
  closeBtn.addEventListener('click', function() {
    modal.style.display = 'none';
  });
  
  // Close modal when clicking outside
  window.addEventListener('click', function(event) {
    if (event.target === modal) {
      modal.style.display = 'none';
    }
  });
}

// Load external HTML components
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
      initModal(); // Initialize modal after content loads
      initTableButtons();
    })
    .catch(err => console.error('Error loading requests:', err));

  fetch('status.html')
    .then(res => res.text())
    .then(data => document.getElementById('status').innerHTML = data)
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

function initTableButtons() {
  document.querySelectorAll('.approve-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const row = this.closest('tr');
      console.log("Delivery approved for:", row.cells[2].textContent);
      row.style.backgroundColor = '#e8f5e9';
    });
  });
  
  document.querySelectorAll('.reject-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const row = this.closest('tr');
      console.log("Delivery rejected for:", row.cells[2].textContent);
      row.style.backgroundColor = '#ffebee';
    });
  });
}