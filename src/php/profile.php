    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile Settings</title>
        <link rel="stylesheet" href="../css/profile.css">
        <link rel="stylesheet" href="../css/header.css">
    </head>
    <body>

     <?php include('header.php'); ?> 
        <div class="hero-background"></div>
        <div class="main-container">
            <div class="settings-sidebar">
                <div class="settings-header">
                    <img src="../images/Settings.png" alt="Settings">
                    <h2>SETTINGS</h2>
                </div>
                
                <div class="settings-menu">
                    <div class="menu-item">
                        <img src="../images/profileLogo.png" alt="Profile">
                        <span>Profile</span>
                    </div>

                    
                    <div class="menu-item">
                        <img src="../images/Log_outLogo.png" alt="">
                        <span>Log Out</span>
                    </div>
                </div>
            </div>
            
            <div class="profile-content">
                <div class="profile-header">
                    <div class="profile-pic-container">
                        <img src="../images/profileAvatar.png" alt="Profile Picture" class="profile-pic">
                        <div class="change-photo" id="changePhotoBtn">
                            <span>Change Photo</span>
                            <img src="pencil-icon.png" alt="Edit" class="edit-icon" id="photoEditIcon">
                        </div>
                    </div>
                    
                    <div class="profile-info" id="profileInfo">
                        <div class="info-row">
                            <div class="info-group">
                                <div class="info-label">
                                    <span>Name</span>
                                </div>
                                <div class="info-value">
                                    <span></span>
                                    <img src="pencil-icon.png" alt="Edit" class="edit-icon">
                                </div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">
                                    <span>Nickname</span>
                                </div>
                                <div class="info-value">
                                    <span></span>
                                    <img src="pencil-icon.png" alt="Edit" class="edit-icon">
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-group">
                                <div class="info-label">
                                    <span>Residence (Full Address)</span>
                                </div>
                                <div class="info-value">
                                    <span></span>
                                    <img src="pencil-icon.png" alt="Edit" class="edit-icon">
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-group">
                                <div class="info-label">
                                    <span>Birthdate</span>
                                </div>
                                <div class="info-value">
                                    <span></span>
                                    <img src="pencil-icon.png" alt="Edit" class="edit-icon">
                                </div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">
                                    <span>Company/Business Name</span>
                                </div>
                                <div class="info-value">
                                    <span></span>
                                    <img src="pencil-icon.png" alt="Edit" class="edit-icon">
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-group">
                                <div class="info-label">
                                    <span></span>
                                </div>
                                <div class="info-value">
                                    <span>Type of business</span>
                                    <span></span>
                                    <img src="pencil-icon.png" alt="Edit" class="edit-icon">
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-group">
                                <div class="info-label">
                                    <span>Email</span>
                                </div>
                                <div class="info-value">
                                    <span></span>
                                    <img src="../images/pencil-icon.png" alt="Edit" class="edit-icon">
                                </div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">
                                    <span>Phone Number</span>
                                </div>
                                <div class="info-value">
                                    <span></span>
                                    <img src="pencil-icon.png" alt="Edit" class="edit-icon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="action-btn" id="editSaveBtn">Edit</button>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const editSaveBtn = document.getElementById('editSaveBtn');
                const editIcons = document.querySelectorAll('.edit-icon');
                const infoValues = document.querySelectorAll('.info-value');
                const changePhotoBtn = document.getElementById('changePhotoBtn');
                const photoEditIcon = document.getElementById('photoEditIcon');
                
                let isEditMode = false;
                
                // Toggle edit/save mode
                editSaveBtn.addEventListener('click', function() {
                    isEditMode = !isEditMode;
                    
    // Inside the editSaveBtn click event listener
                if (isEditMode) {
                    // ... existing edit mode code ...
                    
                    // Make fields editable - modified to handle birthday specially
                    infoValues.forEach(value => {
                        const label = value.closest('.info-group').querySelector('.info-label span').textContent;
                        const text = value.querySelector('span').textContent;
                        
                        if (label === 'Birthdate') {
                            // Convert the displayed date to a format suitable for date input (YYYY-MM-DD)
                            const date = new Date(text);
                            const formattedDate = isNaN(date.getTime()) ? '' : 
                                `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
                            value.innerHTML = `<input type="date" value="${formattedDate}">`;
                        } else {
                            value.innerHTML = `<input type="text" value="${text}">`;
                        }
                        value.classList.add('editable');
                    });
                } else {
                    // ... existing view mode code ...
                    
                    // Save values and switch back to text display - modified to handle birthday specially
                    infoValues.forEach(value => {
                        const label = value.closest('.info-group').querySelector('.info-label span').textContent;
                        const input = value.querySelector('input');
                        
                        if (label === 'Birthdate' && input.type === 'date') {
                            // Format the date input value for display
                            const date = new Date(input.value);
                            const formattedDate = isNaN(date.getTime()) ? '' : 
                                date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                            value.innerHTML = `<span>${formattedDate}</span><img src="pencil-icon.png" alt="Edit" class="edit-icon">`;
                        } else {
                            const inputValue = input.value;
                            value.innerHTML = `<span>${inputValue}</span><img src="pencil-icon.png" alt="Edit" class="edit-icon">`;
                        }
                        value.classList.remove('editable');
                    });
                }
                });
                
                // Initially hide all edit icons
                editIcons.forEach(icon => {
                    icon.style.display = 'none';
                });
                photoEditIcon.style.display = 'none';
                
                // Change photo functionality
                changePhotoBtn.addEventListener('click', function() {
                    if (isEditMode) {
                        // In a real app, this would open a file dialog
                        alert('Photo change functionality would go here');
                    }
                });
                
                // Function to make both panels equal height
                function equalizeHeights() {
                    const sidebar = document.querySelector('.settings-sidebar');
                    const content = document.querySelector('.profile-content');
                    
                    if (window.innerWidth > 768) {
                        const contentHeight = content.offsetHeight;
                        sidebar.style.height = `${contentHeight}px`;
                    } else {
                        sidebar.style.height = 'auto';
                    }
                }
                
                // Run on load and resize
                window.addEventListener('load', equalizeHeights);
                window.addEventListener('resize', equalizeHeights);
            });
        </script>
        <script>
            function adjustSidebarHeight() {
        const content = document.querySelector('.profile-content');
        const sidebar = document.querySelector('.settings-sidebar');
        if (window.innerWidth > 768) {
            sidebar.style.height = `${content.offsetHeight}px`;
        } else {
            sidebar.style.height = 'auto';
        }
    }

    window.addEventListener('load', adjustSidebarHeight);
    window.addEventListener('resize', adjustSidebarHeight);
        </script>
    </body>
    </html>