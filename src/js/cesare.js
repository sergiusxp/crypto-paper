function cifraCesare() {
    const text = document.getElementById('inputText').value;
    const shift = parseInt(document.getElementById('shift').value, 10);
    document.getElementById('outputText').value = applicaCesare(text, shift, true);
    updateFormulaExplanationCesare(text, shift, true);
}

function decifraCesare() {
    const text = document.getElementById('inputText').value;
    const shift = parseInt(document.getElementById('shift').value, 10);
    document.getElementById('outputText').value = applicaCesare(text, shift, false);
    updateFormulaExplanationCesare(text, shift, false);
}

function applicaCesare(str, amount, cifra) {
    if (!cifra) amount = (26 - amount) % 26;
    return str.replace(/[a-zA-Z]/g, function(char) {
        var startCode = char <= 'Z' ? 65 : 97;
        return String.fromCharCode(((char.charCodeAt(0) - startCode + amount) % 26) + startCode);
    });
}

function updateFormulaExplanationCesare(text, shift, isEncryption) {
    let explanation = `<h3>Spiegazione delle Formule</h3>`;
    explanation += `<p>${isEncryption ? "Crittazione" : "Decrittazione"} di "${text}" con shift ${shift}</p>`;
    explanation += `<p>Formula di ${isEncryption ? "Crittazione" : "Decrittazione"}: ${isEncryption ? "C<sub>i</sub> = (P<sub>i</sub> + shift) mod 26" : "P<sub>i</sub> = (C<sub>i</sub> - shift + 26) mod 26"}</p>`;

    explanation += "<ul>";

    for (let i = 0; i < text.length; i++) {
        const charCode = text[i].charCodeAt(0);
        const first = charCode <= 'Z'.charCodeAt(0) ? 'A' : 'a';
        // Ignora i caratteri non alfabetici considerando i maiuscoli e minuscoli
        if((charCode >= 'a'.charCodeAt(0) && charCode <= 'z'.charCodeAt(0)) || (charCode >= 'A'.charCodeAt(0) && charCode <= 'Z'.charCodeAt(0))) {
            const charIndex = charCode - first.charCodeAt(0);
            const shiftedIndex = isEncryption ? (charIndex + shift) % 26 : (charIndex - shift + 26) % 26;
            const resultChar = String.fromCharCode(shiftedIndex + first.charCodeAt(0));
    
            explanation += `<li>${text[i]} (${charIndex}) ${isEncryption ? "con" : "diventa"} ${resultChar} (${shiftedIndex}): ${isEncryption ? "(" + charIndex + " + " + shift + ") mod 26" : "(" + charIndex + " - " + shift + " + 26) mod 26"} = ${shiftedIndex} (${resultChar})</li>`;
        }
    }

    explanation += "</ul>";
    document.getElementById('formulaExplanation').innerHTML = explanation;
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