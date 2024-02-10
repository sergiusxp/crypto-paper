<script src="js/vigenere.js"></script>
<script>loadComments("vigenere");</script>

<h1>Cifrario di Vigenère</h1>
<div class="form-group">
    <textarea id="inputText" class="text-input" placeholder="Testo da cifrare/decifrare"></textarea>
</div>
<div class="form-group">
    <input type="text" id="key" class="text-input" placeholder="Chiave di cifratura">
    <label for="key">Chiave</label>
</div>
<textarea id="outputText" class="text-output" placeholder="Testo risultante" readonly></textarea>
<br><br>
<button class="action-btn" onclick="cifraVigenere()">Cifra</button>
<button class="action-btn" onclick="decifraVigenere()">Decifra</button>
<button class="action-btn" onclick="copyCipherInPlain()">Copia il Cifrato nel Testo in Chiaro</button>
<br>
<div id="formulaExplanation"></div>
<br>
<div id="comments"></div>
