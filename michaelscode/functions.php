<?php

// Sanitize input data to prevent XSS
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Helper function to redirect to another page
function redirect($url) {
    header("Location: $url");
    exit();
}

?>
