let timeout;

function resetTimeout() {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        // Call the logout function after 5 minutes of inactivity 
        window.location.href = 'logout.php';
    }, 30000000); // 300000 milliseconds = 5 minutes
}

// Monitor user activity
window.onload = resetTimeout;
document.onmousemove = resetTimeout;
document.onkeypress = resetTimeout;
