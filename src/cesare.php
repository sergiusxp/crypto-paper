<script src="/js/cesare.js"></script>
<script>loadComments("cesare");</script>

<h1>Cifrario di Cesare</h1>
<div>
    <textarea id="inputText" placeholder="Testo da cifrare/decifrare"></textarea><br>
    <input type="number" id="shift" placeholder="Shift" min="0" max="25" value="12"> Shift (0-25)<br>
    <textarea id="outputText" placeholder="Testo risultante"></textarea>
</div>
<br>
<button onclick="cifraCesare()">Cifra</button>
<button onclick="decifraCesare()">Decifra</button>
<button onclick="copyCipherInPlain()">Copia il Cifrato nel Testo in Chiaro</button>
<br>
<div id="formulaExplanation"></div>
<br>
<div id="comments"></div>
