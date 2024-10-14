<?php if (isset($_SESSION['message'])): ?>
    <div class="notification-container">
        <div class="notification <?php echo $_SESSION['msg_type']; ?>">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']) ?>
        </div>
    </div>
<?php endif; ?>