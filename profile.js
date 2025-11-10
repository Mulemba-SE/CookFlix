document.addEventListener('DOMContentLoaded', function() {
  // --- Element Selections ---
  const avatarLargeContainer = document.getElementById('avatarLargeContainer');
  const avatarOptionsMenu = document.getElementById('avatarOptionsMenu');
  const viewAvatarBtn = document.getElementById('viewAvatarBtn');
  const changeAvatarBtn = document.getElementById('changeAvatarBtn');
  const removeAvatarBtn = document.getElementById('removeAvatarBtn');
  const avatarUploadInput = document.getElementById('avatarUploadInput');
  const avatarViewModal = document.getElementById('avatarViewModal');
  const closeViewBtn = document.getElementById('closeViewBtn');
  const changeFromViewBtn = document.getElementById('changeFromViewBtn');
  const profileAvatarLarge = document.getElementById('profileAvatarLarge');
  const avatarViewImage = document.getElementById('avatarViewImage');
  const editProfileBtn = document.getElementById('editProfileBtn');
  const avatarUploadIcon = document.getElementById('avatarUploadIcon');

  // --- Event Listeners ---

  // Toggle avatar options menu
  avatarLargeContainer?.addEventListener('click', (e) => {
    e.stopPropagation();
    avatarLargeContainer.classList.toggle('active');
  });

  // Close menu if clicking outside
  document.addEventListener('click', () => {
    if (avatarLargeContainer) {
      avatarLargeContainer.classList.remove('active');
    }
  });

  // Make the camera icon trigger the file upload
  avatarUploadIcon?.addEventListener('click', (e) => {
    e.stopPropagation(); // Prevent the main container's click event
    avatarUploadInput.click();
  });

  // --- Avatar Management ---

  // 1. View Avatar
  viewAvatarBtn?.addEventListener('click', () => {
    const currentAvatarImg = profileAvatarLarge.querySelector('img');
    if (currentAvatarImg) {
      avatarViewImage.src = currentAvatarImg.src;
      avatarViewModal.style.display = 'flex';
    } else {
      alert("No avatar to view. Please upload one first.");
    }
    avatarLargeContainer.classList.remove('active');
  });

  // Close view modal
  closeViewBtn?.addEventListener('click', () => avatarViewModal.style.display = 'none');
  changeFromViewBtn?.addEventListener('click', () => {
    avatarViewModal.style.display = 'none';
    avatarUploadInput.click();
  });

  // 2. Change Avatar (Trigger file input)
  changeAvatarBtn?.addEventListener('click', () => {
    avatarUploadInput.click();
    avatarLargeContainer.classList.remove('active');
  });

  // Handle file upload (this was already implemented in a previous step)
  avatarUploadInput?.addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const formData = new FormData();
    formData.append('avatar', file);

    try {
      const response = await fetch('upload_avatar.php', { method: 'POST', body: formData });
      const result = await response.json();
      if (response.ok && result.success) {
        updateAllAvatars(result.avatar_url + '?t=' + new Date().getTime());
      } else {
        alert(`Upload failed: ${result.error}`);
      }
    } catch (error) {
      alert('An error occurred during upload.');
    }
  });

  // 3. Remove Avatar
  removeAvatarBtn?.addEventListener('click', async () => {
    if (!confirm("Are you sure you want to remove your avatar?")) {
      return;
    }
    avatarLargeContainer.classList.remove('active');

    try {
      const response = await fetch('remove_avatar.php', { method: 'POST' });
      const result = await response.json();

      if (response.ok && result.success) {
        const userInitial = document.getElementById('profileName').textContent.charAt(0).toUpperCase();
        updateAllAvatars(null, userInitial);
      } else {
        alert(`Error: ${result.error}`);
      }
    } catch (error) {
      alert('An error occurred while removing the avatar.');
    }
  });

  function updateAllAvatars(url, initial = null) {
    const headerAvatar = document.querySelector('header .user-avatar');
    let content;

    if (url) {
      content = `<img src="${url}" alt="User Avatar" style="width:100%; height:100%; object-fit:cover;">`;
    } else {
      content = initial || '';
    }

    if (profileAvatarLarge) profileAvatarLarge.innerHTML = content;
    if (headerAvatar) headerAvatar.innerHTML = content;
  }

  // --- Other Page Logic ---

  // Edit Profile Modal (from previous step)
  const editProfileModal = document.getElementById('editProfileModal');
  const closeEditModalBtn = document.getElementById('closeEditModal');
  const cancelEditBtn = document.getElementById('cancelEditBtn');
  const editProfileForm = document.getElementById('editProfileForm');

  const openEditModal = () => editProfileModal.style.display = 'flex';
  const closeEditModal = () => editProfileModal.style.display = 'none';

  editProfileBtn?.addEventListener('click', openEditModal);
  closeEditModalBtn?.addEventListener('click', closeEditModal);
  cancelEditBtn?.addEventListener('click', closeEditModal);

  editProfileModal?.addEventListener('click', (e) => {
    if (e.target === editProfileModal) {
      closeEditModal();
    }
  });

  editProfileForm?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const messageDiv = document.getElementById('editProfileMessage');

    try {
        const response = await fetch('update_profile.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (response.ok && result.success) {
            // Update the page with new data
            document.getElementById('profileName').textContent = result.data.username;
            document.getElementById('personalName').textContent = result.data.username;
            document.getElementById('personalEmail').textContent = result.data.email;
            document.getElementById('profileBio').textContent = result.data.bio || 'Click "Edit Profile" to add a bio!';
            document.getElementById('personalPhone').textContent = result.data.phone || 'Not specified';
            document.getElementById('personalLocation').textContent = result.data.location || 'Not specified';
            
            // Update header if it shows user info
            const headerUsername = document.querySelector('.user-name');
            if(headerUsername) headerUsername.textContent = result.data.username;

            closeEditModal();
        } else {
            messageDiv.textContent = result.error || 'An unknown error occurred.';
            messageDiv.className = 'message error';
            messageDiv.style.display = 'block';
        }
    } catch (error) {
        messageDiv.textContent = 'A network error occurred. Please try again.';
        messageDiv.className = 'message error';
        messageDiv.style.display = 'block';
    }
  });

  // Change Password Form
  const changePasswordForm = document.getElementById('changePasswordForm');
  changePasswordForm?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const messageDiv = document.getElementById('passwordChangeMessage');
    const formData = new FormData(this);

    // Basic client-side validation
    if (formData.get('new_password') !== formData.get('confirm_password')) {
        messageDiv.textContent = 'New passwords do not match.';
        messageDiv.className = 'message error';
        messageDiv.style.display = 'block';
        return;
    }

    try {
        const response = await fetch('change_password.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (response.ok && result.success) {
            messageDiv.textContent = result.message;
            messageDiv.className = 'message success';
            changePasswordForm.reset();
        } else {
            messageDiv.textContent = result.error || 'An unknown error occurred.';
            messageDiv.className = 'message error';
        }
    } catch (error) {
        messageDiv.textContent = 'A network error occurred. Please try again.';
        messageDiv.className = 'message error';
    } finally {
        messageDiv.style.display = 'block';
    }
  });

  // Delete Account Modal
  const deleteAccountBtn = document.getElementById('deleteAccountBtn');
  const deleteAccountModal = document.getElementById('deleteAccountModal');
  const closeDeleteModalBtn = document.getElementById('closeDeleteModal');
  const deleteAccountForm = document.getElementById('deleteAccountForm');
  const deleteConfirmInput = document.getElementById('deleteConfirmInput');
  const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
  const currentUsername = document.getElementById('profileName').textContent;

  deleteAccountBtn?.addEventListener('click', () => {
    deleteAccountModal.style.display = 'flex';
  });

  closeDeleteModalBtn?.addEventListener('click', () => {
    deleteAccountModal.style.display = 'none';
    deleteAccountForm.reset();
    confirmDeleteBtn.disabled = true;
  });

  deleteConfirmInput?.addEventListener('input', () => {
    if (deleteConfirmInput.value === currentUsername) {
      confirmDeleteBtn.disabled = false;
    } else {
      confirmDeleteBtn.disabled = true;
    }
  });

  deleteAccountForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (deleteConfirmInput.value !== currentUsername) return;

    try {
      const response = await fetch('delete_account.php', { method: 'POST' });
      const result = await response.json();

      if (response.ok && result.success) {
        alert('Your account has been successfully deleted.');
        window.location.href = 'logout.php'; // Redirect to logout
      } else {
        alert(`Error: ${result.error || 'Could not delete account.'}`);
      }
    } catch (error) {
      alert('A network error occurred. Please try again.');
    }
  });


  // Tab functionality
  const tabs = document.querySelectorAll('.profile-tab');
  const tabContents = document.querySelectorAll('.tab-content');

  tabs.forEach(tab => {
    tab.addEventListener('click', function() {
      tabs.forEach(t => t.classList.remove('active'));
      tabContents.forEach(c => c.classList.remove('active'));
      this.classList.add('active');
      const activeTabContent = document.getElementById(this.dataset.tab);
      if (activeTabContent) {
        activeTabContent.classList.add('active');
      }
    });
  });
});