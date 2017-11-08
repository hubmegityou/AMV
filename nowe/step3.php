
	<i class="fa fa-check-circle" aria-hidden="true"></i>
	<div id="step3">
            <div class="flights">
                <h1>Dokumenty</h1>
                <h2>Przesłane dokumenty muszą być czytelne<br> i z widocznymi krawędziami</h2>
            </div>
            <div class="question">
                Rezerwacja / Karta pokładowa
            </div>
			<img src='grafika_projektowa/rezerwacjaskan_info.png'>
            <div class="flights" id='a1'>
                <div class="documents" id='1'><!-- each passenger in another div-->
					 rezerwacja
					<label class="custom-file-upload ">
					<input type="file" id='r'  accept="image/*" capture="camera"/>
						+ Dodaj dokument
					</label>
   
					karta pokładowa
                    <label class="custom-file-upload" id='xddd'>					
				    <input type="file" id='k' accept="image/*" capture="camera" />  
						+ Dodaj dokument
					</label>
                </div>
            </div>
            <div class="question">
                Paszport
            </div>
			<img src='grafika_projektowa/skan_info.png'>
            <div class="flights" id='a2'>
                <div class="documents" id='2'><!-- each passenger in another div-->
				
				<label class="custom-file-upload"> 
				<input type="file" id='p' accept="image/*" capture="camera" /> 
				   + Dodaj dokument
				</label>
                                     
                </div>
            </div>
            <div class="question">
                Dowód osobisty
            </div>
			<img src='grafika_projektowa/skan_info2.png'>
            <div class="flights" id='a3'>
                <div class="documents" id='3'><!-- each passenger in another div-->
					przód 
					<label class="custom-file-upload"> 
					<input type="file" id='dp' accept="image/*" capture="camera" />
						+ Dodaj dokument
					</label>
                    
					tył
					<label class="custom-file-upload">					
					<input type="file" id='dt' accept="image/*" capture="camera" />
						+ Dodaj dokument
					</label>
                                    
                </div>
            </div>
            <div class="flights">
                <button class="btn_next" type="button">Dalej &rarr;</button>
                <button class="btn_prev" type="button">&larr; Wróć</button>
            </div>
        </div>