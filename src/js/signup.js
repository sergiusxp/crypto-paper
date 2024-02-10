document.getElementById('signup-button').addEventListener('click', function() {
    event.preventDefault(); 

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    fetch('signup.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `email=${encodeURIComponent(email)}&username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('signup-result').innerHTML = '<br><br>Utente creato con successo! Redirect in 2 secondi...';
            setTimeout(function() {
                caricaPagina('signin.php', 'login');
            }, 2000);
        } else {
            document.getElementById('signup-result').innerHTML = '<br><br>Registrazione fallita: ' + data.message;
        }
    })
    .catch(error => {
        console.error('Errore:', error);
        document.getElementById('signup-result').innerHTML = '<br><br>Errore nella registrazione.';
    });
});
