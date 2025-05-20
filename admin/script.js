document.addEventListener('DOMContentLoaded', function() {
  showPanel('status'); // Show the status panel by default
  initModal(); // Initialize modal functionality
  initTableButtons(); // Initialize any table buttons
});

// Function to show specific content panels
function showPanel(panelId) {
  const panels = document.querySelectorAll('.content-panel');
  panels.forEach(panel => {
    panel.style.display = 'none';
  });
  
  const activePanel = document.getElementById(panelId);
  if (activePanel) {
    activePanel.style.display = 'block';
  } else {
    console.error(`Panel with ID ${panelId} not found`);
  }
}

// Function to initialize modal functionality
function initModal() {
  // Support both static and dynamically loaded modal/buttons
  const modal = document.getElementById('deliveryDetailsModal');
  const openBtn = document.getElementById('detailsBtn');
  const closeBtn = document.getElementById('closeModalBtn');
  const moreBtns = document.querySelectorAll('.more-btn');

  // Debugging logs
  console.log('Modal element:', modal);
  console.log('Open button:', openBtn);
  console.log('Close button:', closeBtn);

  // Open modal when 3-dot button or .more-btn is clicked
  if (openBtn) {
    openBtn.addEventListener('click', function() {
      console.log('3-dot button clicked');
      if (modal) modal.style.display = 'block';
    });
  }
  // For all .more-btns (if present)
  moreBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      console.log('More button clicked');
      if (modal) modal.style.display = 'block';
    });
  });

  // Close modal when X is clicked
  if (closeBtn) {
    closeBtn.addEventListener('click', function() {
      if (modal) modal.style.display = 'none';
    });
  }

  // Close modal when clicking outside
  window.addEventListener('click', function(event) {
    if (modal && event.target === modal) {
      modal.style.display = 'none';
    }
  });
}

// Function to initialize table buttons
function initTableButtons() {
  // Add event listeners to edit buttons
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      console.log('Edit button clicked');
      // Add your edit functionality here
    });
  });

  // Approve button
  document.querySelectorAll('.approve-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const row = this.closest('tr');
      row.style.backgroundColor = '#e8f5e9';
    });
  });

  // Reject button
  document.querySelectorAll('.reject-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const row = this.closest('tr');
      row.style.backgroundColor = '#ffebee';
    });
  });
}

// Function to initialize status buttons
function initStatusButtons() {
  document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      // Edit status functionality
    });
  });
}

// Debugging function to check if elements exist
function checkElements() {
  console.log('Checking important elements:');
  console.log('Modal:', document.getElementById('deliveryDetailsModal'));
  console.log('More buttons:', document.querySelectorAll('.more-btn'));
  console.log('Close button:', document.querySelector('.close-btn'));
  console.log('Edit buttons:', document.querySelectorAll('.edit-btn'));
}

// Run element check (for debugging)
checkElements();

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
      initModal(); // Re-initialize modal after loading requests
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