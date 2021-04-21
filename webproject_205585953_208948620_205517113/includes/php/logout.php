 <?php
session_start();
unset($_SESSION['loggedin']);
unset($_SESSION['user_id']);
unset($_SESSION['name']);
unset($_SESSION['last_name']);

echo '<script>
        sessionStorage.clear();
        window.location = "/index.html";
    </script>';
?>