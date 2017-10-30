<form name = '<?php echo isset($flight) ? "" : "default" ?>' data-index = '<?php echo $index ?>' <?php echo isset($flight) ? "" : "hidden" ?>>
                <input type='hidden' name='departure-code' value='<?php echo isset($flight["dep_IATA"]) ? $flight["dep_IATA"] : "" ?>' />
                <input type='hidden' name='destination-code' value='<?php echo isset($flight["dest_IATA"]) ? $flight["dest_IATA"] : "" ?>' />
			<div class="question">
				<p><?php echo isset($flight["dep_IATA"]) ? ($index + 1).". ".$flight["dep_city"]." (".$flight["dep_IATA"].") - ".$flight["dest_city"]." (".$flight["dest_IATA"].")" : "" ?></p>
				Co się wydarzyło z tym lotem?
			</div>
			<div class="answer variants">
				<div class="part" >
					<label>
						<input type="radio" name="reason" value = "delayed" <?php echo isset($flight["incident"]) && $flight["incident"] == 1 ? "checked" : "" ?> hidden/>
						<img name = "delayed" src="grafika_testowa/13.png" />
						<br>opóźniony								
					</label>
				</div>
				<div class="part" >
					<label>
						<input type="radio" name="reason" value = "cancelled" <?php echo isset($flight["incident"]) && $flight["incident"] == 2 ? "checked" : "" ?> hidden/>
						<img name = "cancelled" src="grafika_testowa/4.png" />
						<br>odwołany								
					</label>
				</div>
				<div class="end" >
					<label>
						<input type="radio" name="reason" value = "overbooked" <?php echo isset($flight["incident"]) && $flight["incident"] == 3 ? "checked" : "" ?> hidden/>
						<img name = "overbooked" src="grafika_testowa/5.png" />
						<br>odmowa wejścia na pokład								
					</label>
					
				</div>
			</div>
			
			<div name="delayed" <?php echo isset($flight["incident"]) && $flight["incident"] == 1 ? "" : "hidden" ?> >	<!-- delayed -->
				<div class="question">
					Jaki był powód opóźnienia?
				</div>
				<div class="answer">
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "technical" <?php echo isset($flight["cause"]) && $flight["cause"] == 1 ? "checked" : "" ?> hidden/>
							<img name = "technical" src="grafika_testowa/6.png" />
							Problemy techniczne
						</label>
<!--                                                <img src="grafika_testowa/6.png" />
						Problemy techniczne-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "weather" <?php echo isset($flight["cause"]) && $flight["cause"] == 2 ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/7.png" />
							Złe warunki atmosferyczne
						</label>
<!--                                                <img src="grafika_testowa/7.png" />
						Złe warunki atmosferyczne-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value="other_flights" <?php echo isset($flight["cause"]) && $flight["cause"] == 3 ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/8.png" />
							Wpływ innych lotów
						</label>
<!--                                                <img src="grafika_testowa/8.png" />
						Wpływ innych lotów-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "airport" <?php echo isset($flight["cause"]) && $flight["cause"] == 4 ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/9.png" />
							Kłopoty portu lotniczego
						</label>
<!--						<img src="grafika_testowa/9.png" />
						Kłopoty portu lotniczego-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "strike" <?php echo isset($flight["cause"]) && $flight["cause"] == 5 ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/10.png" />
							Strajk
						</label>
<!--						<img src="grafika_testowa/10.png" />
						Strajk-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "not_known" <?php echo isset($flight["cause"]) && $flight["cause"] == 6 ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/11.png" />
							Nie podano
						</label>
<!--						<img src="grafika_testowa/11.png" />
						Nie podano-->
					</div>
					<div class="end">
						<label>
							<input type="radio" name="delayreason" value = "i_dont_know" <?php echo isset($flight["cause"]) && $flight["cause"] == 7 ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/12.png" />
							Nie wiem
						</label>
<!--						<img src="grafika_testowa/12.png" />
						<br>Nie wiem-->
					</div>
				</div>
				<div class="question">
					Jakie było opóźnienie?
				</div>
				<div class="answer">
					<div class="part">
						<label>
							<input type="radio" name="delaytime" value = "lt3" <?php echo (isset($flight["incident"]) && $flight["incident"] == 1 && isset($flight["delay"]) && $flight["delay"] == 1) ? "checked" : "" ?>  hidden/>
							<img src="grafika_testowa/1.png" />
							Mniej niż 3 godziny
						</label>
<!--                                                <img src="grafika_testowa/1.png" />
						Mniej niż 3 godziny-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delaytime" value = "mt3" <?php echo (isset($flight["incident"]) && $flight["incident"] == 1 && isset($flight["delay"]) && $flight["delay"] == 2) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/1.png" />
							Więcej niż 3 godziny
						</label>
<!--                                                <img src="grafika_testowa/1.png" />
						Więcej niż 3 godziny-->
					</div>
					<div class="end">
						<label>
							<input type="radio" name="delaytime" value = "havent_arrived" <?php echo (isset($flight["incident"]) && $flight["incident"] == 1 && isset($flight["delay"]) && $flight["delay"] == 3) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/3.png" />
							<br>Nie dotarłem na miejsce
						</label>
<!--                                                <img src="grafika_testowa/3.png" />
						<br>Nie dotarłem na miejsce-->
					</div>
				</div>
			</div>
			
			<div name="cancelled" <?php echo isset($flight["incident"]) && $flight["incident"] == 2 ? "" : "hidden" ?> >	<!-- cancellation -->
				<div class="question">
					Kiedy linia lotnicza poinformowała o odwołaniu lotu?
				</div>
				<div class="answer">
					<div class="part">
						<label>
							<input type="radio" name="cancellationinfo" value = "lt14" <?php echo isset($flight["cancellation_information"]) && $flight["cancellation_information"] == 1 ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/14.png" />
							<br>Mniej niż 14 dni przed wylotem
						</label>
<!--                                                <img src="grafika_testowa/14.png" />
						<br>Mniej niż 14 dni przed wylotem-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="cancellationinfo" value = "mt14" <?php echo isset($flight["cancellation_information"]) && $flight["cancellation_information"] == 2 ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/15.png" />
							<br>Więcej niż 14 dni przed wylotem
						</label>
<!--						<img src="grafika_testowa/15.png" />
						<br>Więcej niż 14 dni przed wylotem-->
					</div>
				</div>
				<div class="question">
					Jaki był powód odwołania lotu?
				</div>
				<div class="answer">
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "technical" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["cause"]) && $flight["cause"] == 1) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/6.png" />
							Problemy techniczne
						</label>
<!--						<img src="grafika_testowa/6.png" />
						Problemy techniczne-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "weather" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["cause"]) && $flight["cause"] == 2) ? "checked" : "" ?>  hidden/>
							<img src="grafika_testowa/7.png" />
							Złe warunki atmosferyczne
						</label>
<!--                                                <img src="grafika_testowa/7.png" />
						Złe warunki atmosferyczne-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "other_flights" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["cause"]) && $flight["cause"] == 3) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/8.png" />
							Wpływ innych lotów
						</label>
<!--                                                <img src="grafika_testowa/8.png" />
						Wpływ innych lotów-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "airport" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["cause"]) && $flight["cause"] == 4) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/9.png" />
							Kłopoty portu lotniczego
						</label>
<!--                                                <img src="grafika_testowa/9.png" />
						Kłopoty portu lotniczego-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "strike" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["cause"]) && $flight["cause"] == 5) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/10.png" />
							Strajk
						</label>
<!--						<img src="grafika_testowa/10.png" />
						Strajk-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="delayreason" value = "not_known" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["cause"]) && $flight["cause"] == 6) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/11.png" />
							Nie podano
						</label>
<!--						<img src="grafika_testowa/11.png" />
						Nie podano-->
					</div>
					<div class="end">
						<label>
							<input type="radio" name="delayreason" value = "i_dont_know" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["cause"]) && $flight["cause"] == 7) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/12.png" />
							<br>Nie wiem
						</label>
<!--						<img src="grafika_testowa/12.png" />
						<br>Nie wiem-->
					</div>
				</div>
				<div class="question">
					Jakie było opóźnienie?
				</div>
				<div class="answer">
					<div class="part">
						<label>
							<input type="radio" name="cancellationtime" value = "lt2" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["delay"]) && $flight["delay"] == 1) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/16.png" />
							Mniej niż 2 godziny
						</label>
<!--                                                <img src="grafika_testowa/16.png" />
						Mniej niż 2 godziny-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="cancellationtime" value = "2_3" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["delay"]) && $flight["delay"] == 2) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/17.png" />
							2 - 3 godziny
						</label>
<!--						<img src="grafika_testowa/17.png" />
						2 - 3 godziny-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="cancellationtime" value = "3_4" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["delay"]) && $flight["delay"] == 3) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/18.png" />
							3 - 4 godziny
						</label>
<!--						<img src="grafika_testowa/18.png" />
						3 - 4 godziny-->
					</div>
					<div class="part">
						<label>
							<input type="radio" name="cancellationtime" value = "mt4" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["delay"]) && $flight["delay"] == 4) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/19.png" />
							Powyżej 4 godzin
						</label>
<!--						<img src="grafika_testowa/19.png" />
						Powyżej 4 godzin-->
					</div>
					<div class="end">
						<label>
							<input type="radio" name="cancellationtime" value = "i_dont_know" <?php echo (isset($flight["incident"]) && $flight["incident"] == 2 && isset($flight["delay"]) && $flight["delay"] == 5) ? "checked" : "" ?> hidden/>
							<img src="grafika_testowa/12.png" />
							<br>Nie wiem
						</label>
<!--						<img src="grafika_testowa/12.png" />
						<br>Nie wiem-->
					</div>
				</div>
			</div>
			
			<div name="overbooked" <?php echo isset($flight["incident"]) && $flight["incident"] == 3 ? "" : "hidden" ?> >	<!-- overbooking -->
				
				<div class="question">
					Czy dobrowolnie zrezygnowałeś z lotu w zamian za bilet na lot późniejszy albo otrzymałeś inną rekompensatę od linii lotniczej?
				</div>
				<div class="answer">
					<input type="radio" id = "ory" name="overbookingresignation" value = "yes" <?php echo isset($flight["resignation"]) && $flight["resignation"] == 1 ? "checked" : "" ?> hidden/>
					<label for = "ory" class = "btn_yes">
						<h1>TAK</h1>
					</label>
					<input type="radio" id = "orn" name="overbookingresignation" value = "no" <?php echo isset($flight["resignation"]) && $flight["resignation"] == 2 ? "checked" : "" ?> hidden/>
					<label for = "orn" class = "btn_no">
						<h1>NIE</h1>
					</label>
				</div>
			</div>
			
			
			<div class="flights" <?php echo isset($flight["airline_IATA"]) || isset($flight["flight_number"]) ?  "" : "hidden" ?> >
				<input type='hidden' name='airline-code' value = '<?php echo isset($flight["airline_IATA"]) ? $flight["airline_IATA"] : "" ?> ' />
				Nazwa lini lotniczej<br>
				<input type="text" name="airlines" placeholder="Podaj nazwę linii" autocomplete="off" value = '<?php echo isset($flight["airline_name"]) ? $flight["airline_name"] : "" ?>'/>
				Numer lotu<br>
				<input type="text" name="fnumber" placeholder="Podaj numer lotu" autocomplete="off" value = '<?php echo isset($flight["flight_number"]) ? $flight["flight_number"] : "" ?>' />
				Data lotu<br>
				<input type="date" name="date" placeholder="Dodaj datę" autocomplete="off" value = '<?php echo isset($flight["flight_date"]) ? $flight["flight_date"] : "" ?>' />
			</div>
		</form>