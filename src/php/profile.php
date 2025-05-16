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
                            <img src="<?php echo isset($_SESSION['profile_picture']) ? '../uploads/'.$_SESSION['profile_picture'] : '../images/profileAvatar.png'; ?>" alt="Profile Picture" class="profile-pic" id="profilePicture">
                            <form id="profilePicForm" enctype="multipart/form-data" style="display:none;">
                                <input type="file" id="profilePicInput" name="profile_picture" accept="image/*">
                            </form>
                            <div class="change-photo" id="changePhotoBtn">
                                <span>Change Photo</span>
                                <img src="../images/pencil-icon.png" alt="Edit" class="edit-icon" id="photoEditIcon">
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
    const profilePicInput = document.getElementById('profilePicInput');
    const profilePicForm = document.getElementById('profilePicForm');
    const profilePicture = document.getElementById('profilePicture');
    
    let isEditMode = false;
    

    editSaveBtn.addEventListener('click', function() {
        isEditMode = !isEditMode;
        
        if (isEditMode) {
            editSaveBtn.textContent = 'Save';

            editIcons.forEach(icon => {
                icon.style.display = 'inline-block';
            });
            photoEditIcon.style.display = 'inline-block';
            

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
        editSaveBtn.textContent = 'Edit';
        // Hide all edit icons
        editIcons.forEach(icon => {
            icon.style.display = 'none';
        });
        photoEditIcon.style.display = 'none';
        
        // Save values and switch back to text display
        const updatedData = {};
        infoValues.forEach(value => {
            const label = value.closest('.info-group').querySelector('.info-label span').textContent;
            const input = value.querySelector('input');
            
            if (label === 'Birthdate' && input.type === 'date') {
                // Format the date input value for display and database
                const date = new Date(input.value);
                const formattedDate = isNaN(date.getTime()) ? '' : 
                    date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                value.innerHTML = `<span>${formattedDate}</span><img src="../images/pencil-icon.png" alt="Edit" class="edit-icon">`;
                updatedData[label.toLowerCase().replace(/[^a-z]/g, '')] = input.value; // Store as YYYY-MM-DD for database
            } else {
                const inputValue = input.value;
                value.innerHTML = `<span>${inputValue}</span><img src="../images/pencil-icon.png" alt="Edit" class="edit-icon">`;
                updatedData[label.toLowerCase().replace(/[^a-z]/g, '')] = inputValue;
            }
            value.classList.remove('editable');
        });
        
        // Send updated data to server
        fetch('update_profile.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                ...updatedData,
                user_id: <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error saving profile: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while saving your profile.');
        });
    }
});
    

    editIcons.forEach(icon => {
        icon.style.display = 'none';
    });
    photoEditIcon.style.display = 'none';
    
    // Change photo functionality
    changePhotoBtn.addEventListener('click', function() {
        profilePicInput.click();
    });
    
    profilePicInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {

            const reader = new FileReader();
            reader.onload = function(e) {
                profilePicture.src = e.target.result;
            }
            reader.readAsDataURL(this.files[0]);
            
            // Upload to server
            const formData = new FormData(profilePicForm);
            
            fetch('upload_profile_picture.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the avatar in the header if needed
                    const headerAvatar = document.querySelector('.profile-avatar');
                    if (headerAvatar) {
                        headerAvatar.src = '../uploads/' + data.filename + '?t=' + new Date().getTime();
                    }

                    alert('Profile picture updated successfully!');
                } else {
                    alert('Error: ' + data.message);
                    // Revert to previous image if upload failed
                    profilePicture.src = '<?php echo isset($_SESSION['profile_picture']) ? '../uploads/'.$_SESSION['profile_picture'] : '../images/profileAvatar.png'; ?>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the image.');
                profilePicture.src = '<?php echo isset($_SESSION['profile_picture']) ? '../uploads/'.$_SESSION['profile_picture'] : '../images/profileAvatar.png'; ?>';
            });
        }
    });
    

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