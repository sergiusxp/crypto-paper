function applicaCifrarioVigenere(text, key, cifra) {
    let risultato = '';
    let j = 0;

    // Normalizza la chiave in maiuscolo per uniformità
    key = key.toUpperCase();

    for (let i = 0; i < text.length; i++) {
        const c = text.charCodeAt(i);

        if (c >= 65 && c <= 90) {
            // Lettera maiuscola nel testo
            let keyChar = key.charCodeAt(j % key.length) - 65;
            risultato += String.fromCharCode((c - 65 + (cifra ? keyChar : 26 - keyChar)) % 26 + 65);
        } else if (c >= 97 && c <= 122) {
            // Lettera minuscola nel testo
            let keyChar = key.charCodeAt(j % key.length) - 65; // Usa lo stesso offset di 'A' anche per le minuscole
            risultato += String.fromCharCode((c - 97 + (cifra ? keyChar : 26 - keyChar)) % 26 + 97);
        } else {
            // Carattere non alfabetico, lo si aggiunge al risultato senza modifiche
            risultato += text.charAt(i);
            continue;
        }
        
        j++;
    }

    return risultato;
}

function updateFormulaExplanationVigenere(text, key, isEncryption) {
    let explanation = `<h3>Spiegazione delle Formule</h3>`;
    if (isEncryption) {
        explanation += `<p>Crittazione di "${text}" con la chiave "${key}"</p>`;
        explanation += `<p>Formula di Crittazione: C<sub>i</sub> = (P<sub>i</sub> + K<sub>j mod k</sub>) mod 26</p>`;
    } else {
        explanation += `<p>Decrittazione di "${text}" con la chiave "${key}"</p>`;
        explanation += `<p>Formula di Derittazione: P<sub>i</sub> = (C<sub>i</sub> - K<sub>j mod k</sub> + 26) mod 26</p>`;
    }
    explanation += `<ul>`;

    for (let i = 0, j = 0; i < text.length; i++, j = (j + 1) % key.length) {
        const charCode = text[i].charCodeAt(0);
        const first = charCode <= 'Z'.charCodeAt(0) ? 'A' : 'a';
        const keyLetter = key.charCodeAt(j) - first.charCodeAt(0);
        const letter = charCode - first.charCodeAt(0);

        if((charCode >= 'a'.charCodeAt(0) && charCode <= 'z'.charCodeAt(0)) || (charCode >= 'A'.charCodeAt(0) && charCode <= 'Z'.charCodeAt(0))) {
            if (isEncryption) {
                const c = (letter + keyLetter) % 26;
                explanation += `<li>${text[i]} (${letter}) con ${key[j]} (${keyLetter}): (${letter} + ${keyLetter}) mod 26 = ${c} (${String.fromCharCode(c + first.charCodeAt(0))})</li>`;
            } else {
                const p = (letter - keyLetter + 26) % 26;
                explanation += `<li>${text[i]} (${letter}) con ${key[j]} (${keyLetter}): (${letter} - ${keyLetter} + 26) mod 26 = ${p} (${String.fromCharCode(p + first.charCodeAt(0))})</li>`;
            }
        } else {
            explanation += `<li>Il carattere "${text[i]}" é ignorato nel cifrario.</li>`;
        }
    }

    explanation += `</ul>`;
    document.getElementById('formulaExplanation').innerHTML = explanation;
}

function cifraVigenere() {
    const text = document.getElementById('inputText').value;
    const key = document.getElementById('key').value;
    document.getElementById('outputText').value = applicaCifrarioVigenere(text, key, true);
    updateFormulaExplanationVigenere(text, key, true);
}

function decifraVigenere() {
    const text = document.getElementById('inputText').value;
    const key = document.getElementById('key').value;
    document.getElementById('outputText').value = applicaCifrarioVigenere(text, key, false);
    updateFormulaExplanationVigenere(text, key, false);
}

function copyCipherInPlain() {
    document.getElementById('inputText').value = document.getElementById('outputText').value;
}

// mitigation for XSS
$(document).ready(function() {
    $('#inputText').on('keypress', function(event) {
        restrictDangerousChars(event);
    });
});