<?php 
include "step1_load.php";
?>

<div id="step1">
			
		<div class="flights">
			<h1>Weryfikacja lotu</h1>
			Miejsce wylotu
			<input type="text" name="departure" autocomplete="off" value = "<?php echo $departure_name ?>" 
			data-code = "<?php echo $departure_data_code ?>"
			data-name = "<?php echo $departure_data_name ?>"
			required/>
			Miejsce przylotu
			<input type="text" name="destination" autocomplete="off" value = "<?php echo $destination_name ?>" 
			data-code = "<?php echo $destination_data_code ?>"
			data-name = "<?php echo $destination_data_name ?>"
			required/>
		</div>
		
		<div class="question">
			Czy lot był z przesiadką?
		</div>
		<div class="flights" id = "buttons">
			<button id="Y" class="btn_yn <?php echo $rows > 1 ? 'active' : '' ?>" type="button" >TAK</button>
			<button id="N" class="btn_yn <?php echo $rows == 1 ? 'active' : '' ?>" type="button">NIE</button>
		</div>
		<div id="transfer" <?php echo $rows > 1 ? '' : 'hidden' ?>>
			<div id="airports" class="flights">
				<br>Lotniska<br>
				<div id="waypoints">
					<input name="waypoint" type="text" autocomplete="off" hidden/>
					<?php foreach($waypoints as $waypoint){
						echo("<input name='waypoint' type='text' autocomplete='off' value = '".$waypoint['name']."' 
						data-code = '".$waypoint['data_code']."'
						data-name = '".$waypoint['data_name']."'
						/>");
						}
					?>
				</div>
				<a id = "add_waypoint">+ dodaj następną przesiadkę</a>
			</div>
		
			<div class="question">
			Jakie było opóźnienie w porcie docelowym?
			</div>
			<form name="final" data-index = "-3">
			<div class="answer">
				<div class="part">
					<label>
						<input type="radio" name="finaldelay" value = "lt3" <?php echo $final_delay == 1 ?'checked':'' ?> hidden/>
						<img src="grafika_testowa/1.png">
						mniej niż 3 godziny
					</label>
				</div>
				<div class="part">
					<label>
						<input type="radio" name="finaldelay" value = "mt3" <?php echo $final_delay == 2 ?'checked':'' ?> hidden/>
						<img src="grafika_testowa/2.png" />
						ponad 3 godziny
					</label>
				</div>
				<div class="end">
					<label>
						<input type="radio" name="finaldelay" value = "havent_arrived" <?php echo $final_delay == 3 ?'checked':'' ?> hidden/>
						<img src="grafika_testowa/3.png" />
						nie dotarłem na miejsce
					</label>
				</div>
			</div>
			</form>
				
		</div>
		<div id="trips">
			<div class="question">
				Z którym lotem wystąpił problem?
			</div>
			<div class="answer">
				<input type="button" name="flight" class="btn" hidden/>
				<?php 
					if($rows > 1){
						$index = 0;						
						foreach($data as $flight){
							if($flight["id"]){
								$active = "active_btn";
							}else{
								$active = "";
							}
							echo("<input type='button' name='flight' class='btn ".$active."' value = '".($index + 1).". ".$flight['dep_city']." (".$flight['dep_IATA'].") - ".$flight['dest_city']." (".$flight['dest_IATA'].")' "."data-dep-code='".$flight['dep_IATA']."' data-dest-code='".$flight['dest_IATA']."' data-index='".$index."' />");
							$index++;
						}
					}
				?>
			</div>
		</div>
		<form name = "all" data-index = "-2" hidden>
			<input type='hidden' name='flights[]' />
			<?php 
				foreach($data as $flight){
					echo("<input type='hidden' name='flights[]' value = '".$flight['dep_IATA']."-".$flight['dest_IATA']."'/>");
				}
			?>
		</form>
		<?php 
			$index = -1;
			unset($flight);
			include("_form.php");
			$index = 0;	
			foreach($data as $flight){
				if($flight["id"] != NULL){
					include("_form.php");
				}
				$index++;
			}
		?>
	</div>
	<div class="navigation" <?php $rows > 0 ? "" : "hidden" ?> >
			<button class="btn_next" type="button">Dalej &rarr;</button>
	</div>