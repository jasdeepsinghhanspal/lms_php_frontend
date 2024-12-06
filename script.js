function accessLMS(event) {
    event.preventDefault();
    const password = document.getElementById('lmsPassword').value;
    if (password === 'password') {
        window.location.href = 'index2.html';
    } else {
        alert('Incorrect password. Please try again.');
    }
}
