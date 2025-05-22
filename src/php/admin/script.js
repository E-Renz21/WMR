document.addEventListener('DOMContentLoaded', function() {
  console.log('Client Lists page loaded');
  
  // Initialize row click functionality
  const rows = document.querySelectorAll('.clients-table tbody tr');
  rows.forEach(row => {
    row.addEventListener('click', (e) => {
      // Skip if clicking on action elements
      if (e.target.tagName === 'BUTTON' || e.target.classList.contains('profile-pic-placeholder')) return;
      
      // Toggle row selection
      rows.forEach(r => r.classList.remove('selected-row'));
      row.classList.toggle('selected-row');
      
      console.log('Selected client:', row.cells[1].textContent);
    });
  });
  
  // Future functionality can be added here
  // Example: View profile picture in modal
  const profilePics = document.querySelectorAll('.profile-pic-placeholder');
  profilePics.forEach(pic => {
    pic.addEventListener('click', (e) => {
      e.stopPropagation();
      console.log('View profile picture');
      // Add modal functionality here
    });
  });
});

document.addEventListener('DOMContentLoaded', function() {
  // Initialize the dashboard
  initDashboard();
});

document.addEventListener('DOMContentLoaded', function() {
  // Future JavaScript functionality can be added here
  console.log('Client Inquiries page loaded');
  
  // Example: Add click event for rows if needed
  const rows = document.querySelectorAll('.inquiries-table tbody tr');
  rows.forEach(row => {
    row.addEventListener('click', () => {
      // Add row click functionality here
    });
  });
});
document.addEventListener('click', function(event) {
      const dropdown = document.querySelector('.status-dropdown');
      if (!dropdown.contains(event.target)) {
        document.getElementById('statusOptions').style.display = 'none';
      }
    });

// Initialize the dashboard
function initDashboard() {
  showPanel('requests'); // Show requests panel by default
  initModal(); // Initialize modal functionality
  initTableButtons(); // Initialize table buttons
  
  // Load all components
  loadComponents();
}

// Function to show specific content panels
function showPanel(panelId) {
  const panels = document.querySelectorAll('.dashboard-content-panel');
  panels.forEach(panel => panel.classList.remove('active'));

  const activePanel = document.getElementById(panelId);
  if (activePanel) activePanel.classList.add('active');

  // Highlight active menu item
  const items = document.querySelectorAll('.dashboard-menu-item');
  items.forEach(item => item.classList.remove('active'));
  items.forEach(item => {
    if (item.getAttribute('onclick')?.includes(panelId)) {
      item.classList.add('active');
    }
  });
}


// Function to initialize modal functionality
function initModal() {
  // Close any open modals first
  const openModals = document.querySelectorAll('.modal');
  openModals.forEach(modal => {
    modal.style.display = 'none';
  });

  // Event delegation for dynamically loaded content
  document.addEventListener('click', function(e) {
    // Handle more buttons (3-dot buttons)
    if (e.target.classList.contains('more-btn')) {
      e.preventDefault();
      const modal = document.getElementById('deliveryDetailsModal');
      if (modal) modal.style.display = 'block';
    }
    
    // Handle close buttons
    if (e.target.classList.contains('close-btn')) {
      e.preventDefault();
      const modal = e.target.closest('.modal');
      if (modal) modal.style.display = 'none';
    }
    
    // Handle clicks outside modal content
    if (e.target.classList.contains('modal')) {
      e.target.style.display = 'none';
    }
  });
}

// Function to initialize table buttons
function initTableButtons() {
  // Event delegation for dynamically loaded content
  document.addEventListener('click', function(e) {
    // Edit buttons
    if (e.target.classList.contains('edit-btn')) {
      e.preventDefault();
      e.stopPropagation();
      console.log('Edit button clicked');
      // Add your edit functionality here
    }
    
    // Approve buttons
    if (e.target.classList.contains('approve-btn')) {
      e.preventDefault();
      e.stopPropagation();
      const row = e.target.closest('tr');
      if (row) row.style.backgroundColor = '#e8f5e9';
    }
    
    // Reject buttons
    if (e.target.classList.contains('reject-btn')) {
      e.preventDefault();
      e.stopPropagation();
      const row = e.target.closest('tr');
      if (row) row.style.backgroundColor = '#ffebee';
    }
  });
}

// Load all dashboard components
function loadComponents() {
  // Load header
  fetch('header.html')
  .then(res => res.text())
  .then(data => {
    document.getElementById('header-container').innerHTML = data;
  })
  .catch(err => console.error('Error loading header:', err));


  // Load requests panel
  fetch('requests.php')
    .then(res => res.text())
    .then(data => {
      document.getElementById('requests').innerHTML = data;
      initModal(); // Re-initialize modal after loading requests
    })
    .catch(err => console.error('Error loading requests:', err));

  // Load status panel
  fetch('status.html')
    .then(res => res.text())
    .then(data => {
      // Remove the inline display:block from the modal in status.html
      const cleanedData = data.replace('style="display: block;"', '');
      document.getElementById('status').innerHTML = cleanedData;
      initModal(); // Re-initialize modal after loading status
    })
    .catch(err => console.error('Error loading status:', err));

  // Load inquiries panel
  fetch('inquiries.php')
    .then(res => res.text())
    .then(data => {
      document.getElementById('inquiries').innerHTML = data;
    })
    .catch(err => console.error('Error loading inquiries:', err));

  // Load clients panel
  fetch('clients.php')
    .then(res => res.text())
    .then(data => {
      document.getElementById('clients').innerHTML = data;
    })
    .catch(err => console.error('Error loading clients:', err));

    // Load edit status panel
  fetch('editstatus.php')
    .then(res => res.text())
    .then(data => {
      document.getElementById('editstatus').innerHTML = data;
    })  
    .catch(err => console.error('Error loading edit status:', err));
}

function toggleStatusDropdown() {
      const options = document.getElementById('statusOptions');
      options.style.display = options.style.display === 'block' ? 'none' : 'block';
    }

  function selectStatus(statusText, statusClass) {
    const select = document.querySelector('.status-select');
    const options = document.getElementById('statusOptions');
    
    // Update selected status
    select.innerHTML = `
      <div class="status-icon"></div>
      <span>${statusText}</span>
    `;
    
    // Update class for color
    select.className = 'status-select ' + statusClass;
    
    // Close dropdown
    options.style.display = 'none';
  }

// Global function for menu items to use
window.showPanel = showPanel;

// script.js (add this to the bottom)

// Show logistics modal
function showDetailsModal(pickupDate, pickupAddress, deliveryAddress, expectedArrival) {
  const modal = document.getElementById('detailsModal');
  const body = document.getElementById('modalDetailsBody');
  if (!modal || !body) return;
  body.innerHTML = `
    <p><strong>Pickup Address:</strong> ${pickupAddress || 'N/A'}</p>
    <p><strong>Pickup Date:</strong> ${pickupDate || 'N/A'}</p><br>

    <p><strong>Delivery Address:</strong> ${deliveryAddress || 'N/A'}</p>
    <p><strong>Estimated Arrival Date:</strong> ${expectedArrival || 'N/A'}</p>
  `;
  modal.style.display = 'flex';
}

// Close modal
function closeDetailsModal() {
  const modal = document.getElementById('detailsModal');
  if (modal) modal.style.display = 'none';
}

// Optional: Close modal if user clicks outside
window.addEventListener('click', function(event) {
  const modal = document.getElementById('detailsModal');
  if (event.target === modal) {
    closeDetailsModal();
  }
});


function showStatusModal(data) {
  const body = document.getElementById('statusModalBody');
  body.innerHTML = `
    <p><strong>Driver's Name:</strong> ${data.driver_name || 'N/A'}</p>
    <p><strong>Plate Number:</strong> ${data.plate_number || 'N/A'}</p>
    <p><strong>Current Location:</strong> ${data.current_location || 'N/A'}</p>
    <p><strong>Departure Date:</strong> ${data.departure_date || 'N/A'}</p>
    <p><strong>Departure Time:</strong> ${data.departure_time || 'N/A'}</p>
    <p><strong>Arrival Date:</strong> ${data.arrival_date || 'N/A'}</p>
    <p><strong>Arrival Time:</strong> ${data.arrival_time || 'N/A'}</p>
    <p><strong>Driver Assistant:</strong> ${data.driver_assistant || 'N/A'}</p>
    <p><strong>Driver/Assistant Contact:</strong> ${data.contact_number || 'N/A'}</p>
    <p><strong>Status:</strong> ${data.status || 'N/A'}</p>
    <p><strong>Expected Arrival Date:</strong> ${data.expected_arrival || 'N/A'}</p>
    <p><strong>Admin Note:</strong> ${data.admin_note || 'N/A'}</p>
  `;
  document.getElementById('statusModal').style.display = 'block';
}

function closeStatusModal() {
  document.getElementById('statusModal').style.display = 'none';
}
