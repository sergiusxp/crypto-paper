function loadComments(id) {
    fetch(`comments.php?id=${id}`)
        .then(response => response.text())
        .then(html => {
            setInnerHTML(document.getElementById("comments"), html);
            // Dopo aver aggiornato il DOM, riassegna il listener al bottone di invio
            assignCommentSubmitListener(id);
            // evito XSS
            $('#comments').on('keypress', function(event) {
                restrictDangerousChars(event);
            });
        })
        .catch(error => console.error('Errore nel caricamento dei commenti: ', error));
}

function assignCommentSubmitListener(pageId) {
    // Rimuovi il listener precedente per evitare duplicati
    const button = document.getElementById('add-comment-button');
    if (button) {
        button.removeEventListener('click', submitCommentHandler);
        button.addEventListener('click', () => submitCommentHandler(pageId));
    }
}

function submitCommentHandler(pageId) {
    const commentText = document.getElementById('new-comment-text').value.trim();
    if (commentText !== "") {
        addComment(pageId, commentText);
    } else {
        alert("Il commento non può essere vuoto.");
    }
}

function addComment(pageId, commentText) {
    // La logica per inviare il commento rimane invariata
    fetch('comments.php?id=' + pageId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `commento=${removeDangerousChars(commentText)}`
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Commento aggiunto con successo!');
            document.getElementById('new-comment-text').value = "";
            loadComments(pageId); // Ricarica i commenti
        } else {
            alert('Errore nel salvataggio del commento.');
        }
    })
    .catch(error => console.error('Errore:', error));
}

function dropComment(pageId, id) {
    fetch('comments.php?id=' + pageId, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        // body: `id_comment=${id}` // pericoloso in quanto id può essere una stringa
        body: `id_comment=${+id}` // safe perché forza la conversione a numero
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Commento eliminato con successo!');
            document.getElementById('new-comment-text').value = "";
            loadComments(pageId);
        } else {
            alert('Errore nell\'eliminazione  del commento.');
        }
    })
    .catch(error => console.error('Errore:', error));
}