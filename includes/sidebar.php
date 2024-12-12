
<div class="sidebar" style="width: 250px; background-color: #0B1042; height: 100vh; position: fixed; top: 0; left: 0; box-shadow: 2px 0 5px rgba(0,0,0,0.1);">
    <div class="sidebar-header" style="padding: 20px; text-align: center;">
        <img src="../icons/mainlogo.png" alt="Prayojan" style="width: 80px; height: auto; margin-bottom: 10px;">
        <h4 style="margin: 0; font-family: Arial, sans-serif; font-weight: bold; color: #ffffff;">PRAYOJAN</h4>
    </div>
    <ul class="sidebar-menu" style="list-style: none; padding: 0; margin: 0;">
        <!-- Home -->
        <li style="padding: 10px 20px; cursor: pointer;">
            <a href="index.php" style="text-decoration: none; color: #ffffff; display: flex; align-items: center;">
                <img src="../icons/home.png" alt="Home" style="width: 20px; height: 20px; margin-right: 10px;">
                <span style="font-size: 16px; font-weight: bold;">HOME</span>
            </a>
        </li>
        
        <!-- Manage Polls -->
        <li style="padding: 10px 20px;">
            <a href="manage_polls.php" style="text-decoration: none; color: #ffffff; display: flex; align-items: center;">
                <img src="../icons/managePolls.png" alt="Manage Polls" style="width: 20px; height: 20px; margin-right: 10px;">
                <span style="font-size: 16px; font-weight: bold;">MANAGE POLLS</span>
            </a>
            <ul style="list-style: none; padding-left: 30px; margin-top: 5px;">
                <li style="margin: 5px 0;">
                    <a href="new_poll.php" style="text-decoration: none; color: #ffffff;">
                        <img src="../icons/add.png" alt="New Poll" style="width: 15px; height: 15px; margin-right: 5px;"> 
                        NEW POLL
                    </a>
                </li>
                <li style="margin: 5px 0;">
                    <a href="edit_poll.php" style="text-decoration: none; color: #ffffff;">
                        <img src="../icons/edit.png" alt="Edit Poll" style="width: 15px; height: 15px; margin-right: 5px;"> 
                        EDIT POLL
                    </a>
                </li>
            </ul>
        </li>
        
        <!-- Manage Users -->
        <li style="padding: 10px 20px;">
            <a href="manage_users.php" style="text-decoration: none; color: #ffffff; display: flex; align-items: center;">
                <img src="../icons/manageUser.png" alt="Manage Users" style="width: 20px; height: 20px; margin-right: 10px;">
                <span style="font-size: 16px; font-weight: bold;">MANAGE USERS</span>
            </a>
        </li>
        
        <!-- Notifications -->
        <li style="padding: 10px 20px;">
            <a href="notifications.php" style="text-decoration: none; color: #ffffff; display: flex; align-items: center;">
                <img src="../icons/Notification.png" alt="Notifications" style="width: 20px; height: 20px; margin-right: 10px;">
                <span style="font-size: 16px; font-weight: bold;">NOTIFICATIONS</span>
            </a>
        </li>
    </ul>
</div>

<style>
    .sidebar-menu li a:hover {
    background-color: #ffffff;
    color: #0B1042 !important; /* Ensures text color is applied */
    border-radius: 15px; /* Rounded corners as requested */
    padding: 10px 15px; /* Optional: Add some padding for better appearance */
    transition: background-color 0.3s, color 0.3s; /* Smooth transition effect */
}

.sidebar-menu li a:hover img {
    filter: invert(28%) sepia(96%) saturate(748%) hue-rotate(224deg) brightness(94%) contrast(89%);
    /* Adjusts the image color on hover to match the new theme */
}

</style>
