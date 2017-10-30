
	<div id="step5">
                       
            <div class="flights">
                <h1>Wypłata odszkodowania</h1>
                <div>
                                    <button type="button" class="btn_comp" id="e"  >
                        <h1>EXPRESS (do 24h)</h1>
                        <h2>wypłacimy (obliczona kwota) &euro;</h2>
                        Odszkodowanie przekażemy na wskazane poniżej konto w 24h od przyjęcia poprawnego zgłoszenia.
                    </button>
                </div>
                <div>
                                    <button type="button" class="btn_comp" id="s" >
                        <h1>STANDARD</h1>
                        <h2>wypłacimy (obliczona kwota) &euro;</h2>
                        Odszkodowanie przekażemy na wskazane poniżej konto po akceptacji roszczenia przez linię lotniczą i otrzymaniu od niej odszkodowania.
                    </button> 
                </div>
            </div>
            <div class="question">
                Wybierz sposób wypłaty odszkodowania
            </div>
            <div class="flights">
                <div style="border: 1px solid #797F93; padding: 20px;">
                    <div>
                        <input type="radio" id="paypal" name='radio'>
                        <div class="payment1">
                            Płatność PayPal
                        </div>
                        <div class="payment2">
                            BEZ OPŁAT
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                    <div style="border-top: 1px solid #797F93; margin-top: 10px; margin-bottom: 10px;"></div>
                    <div>
                        <input type="radio" id="account" name='radio'>
                        <div class="payment1">
                            Płatność na konto
                        </div>
                        <div class="payment2" style="width: auto;">
                            WYBIERZ WALUTĘ
                        </div>
                                                    <select id="select"> 
                            <option>---</option>
                            <option>EURO</option>
                            <option>PLN</option>
                            <option>USD</option>
                            <option>CHF</option>
                            <option>GBP</option>
                            <option>INNA</option>
                            </select>
                                    </div>

                </div>
                <div id="p" hidden>
                    <br>Twoje konto PayPal (adres e-mail) <br>       
                </div>
                <div id="a" hidden>
                    <br>Numer konta bankowego <br>       
                </div>
				<div id="pa" hidden>
				<input type="text" name='num' id="account_num">
				</div>
            </div>
            <div class="flights">
                <button class="btn_next" type="button">Dalej &rarr;</button>
                <button class="btn_prev" type="button">&larr; Wróć</button>
            </div>
        </div>