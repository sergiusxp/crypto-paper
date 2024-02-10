function getRandom(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function caricaPagina(pagina, tit, htmlTagId = 'content') {
    const rnd = getRandom(10000000, 99999999);
    const sym = pagina.indexOf('?') === -1 ? "?" : "&";
    fetch(`${pagina}${sym}rnd=` + rnd)
        .then(response => response.text())
        .then(html => {
            setInnerHTML(document.getElementById(htmlTagId), html);
        })
        .catch(error => console.error(`Errore nel caricamento della pagina ${pagina}: `, error));
    if(tit !== undefined) {
        setActiveSection(tit);
    }
}

function setInnerHTML(elm, html) {
    elm.innerHTML = html;
    
    Array.from(elm.querySelectorAll("script"))
      .forEach( oldScriptEl => {
        const newScriptEl = document.createElement("script");
        
        Array.from(oldScriptEl.attributes).forEach( attr => {
          newScriptEl.setAttribute(attr.name, attr.value) 
        });
        
        const scriptText = document.createTextNode(oldScriptEl.innerHTML);
        newScriptEl.appendChild(scriptText);
        
        oldScriptEl.parentNode.replaceChild(newScriptEl, oldScriptEl);
    });
}

function goToHome() {
    const pagina = "index.php";
    window.location = pagina;
    setActiveSection(pagina.substring(0, pagina.indexOf('.')));
}

function setActiveSection(page) {
    $('li').removeClass('active');
    $(`li[tit="${page}"]`).addClass('active');
}

setActiveSection("index");

// mitigations below

function restrictDangerousChars(event) {
    var blockedChars = [60, 62, 34, 39, 38]; // Codici ASCII per <, >, ", ', &
    if (blockedChars.includes(event.which)) {
        event.preventDefault();
    }
}

function removeDangerousChars(text) {
    var sanitizedText = text.replace(/[<>\"'&]/g, function(match) {
        switch (match) {
            case '<': return '&lt;';
            case '>': return '&gt;';
            case '"': return '&quot;';
            case "'": return '&#39;';
            case '&': return '&amp;';
            default: return match;
        }
    });
    return sanitizedText;
}
