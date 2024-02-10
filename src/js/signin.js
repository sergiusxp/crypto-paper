document.getElementById('login-button').addEventListener('click', function() {
    event.preventDefault(); 

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    fetch('signin.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('login-result').innerHTML = '<br><br>Login riuscito! Redirect in 2 secondi...';
            setTimeout(function() {
                window.location = 'index.php';
            }, 2000);
        } else {
            document.getElementById('login-result').innerHTML = '<br><br>Login fallito: ' + data.message;
        }
    })
    .catch(error => {
        console.error('Errore:', error);
        document.getElementById('login-result').innerHTML = '<br><br>Errore di login';
    });
});
