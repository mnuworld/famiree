<?php
	$this->set('title_for_layout', __('Dashboard', true));
?>
	<div id="DashboardSidebar">
		<div class="panel">
		<div class="inner">
		<div class="legend"><?php __('Search'); ?></div>
		<?php
			echo $this->Form->create('Profile', array(
				'url' => array(
					'controller' => 'profiles',
					'action' => 'search'
				),
			));
			echo '<fieldset class="center" id="DashboardSearchFieldset">';
			echo $this->Form->input('criterio', array('div' => false, 'label' => false, 'size' => 15));
			echo $this->Form->submit('Go', array('div' => false));
			echo '</fieldset>';
			echo $this->Form->end();
		?>
		</div>
		</div>
	</div>
<div id="DashboardMain">
	<div>
		<div class="message" id="WelcomeMessage">
			<br />
			<?php
				echo '<b>';
				__('Welcome to Famiree!');
				echo '</b>';
				echo '<br />';
				__('This is a private place for your family to build your family tree, preserve your history and share your lives.');
			?>
			<br /><br />
		</div>
		
		<div id="DashboardDates">
			<?php
				$hasToday = false;
				$hasTomorrow = false;
				$thisMonth = false;
				$nextMonth = false;
				$inFuture = false;
				
				foreach ($dates as $month => $d) {
					foreach ($d as $day => $dt) {
						$bdShowDate = true;
						$oneIfFuture = 1;
						
						if ($month == strftime('%m') && $day == strftime('%d')) {
							echo '<div class="date_title">'.__('Today', true).'</div>'.PHP_EOL;
							$bdShowDate = false;
							$oneIfFuture = 0;
						} else if ($month == strftime('%m') && $day == strftime('%d', strtotime('+1 day'))) {
							echo '<div class="date_title">'.__('Tomorrow', true).'</div>'.PHP_EOL;
							$bdShowDate = false;
						} else if (!$thisMonth && $month == strftime('%m')) {
							echo '<div class="date_title">'.__('This month', true).'</div>'.PHP_EOL;
							$thisMonth = true;
						} else if (!$nextMonth && $month == strftime('%m', strtotime('+1 month'))) {
							echo '<div class="date_title">'.__('Next month', true).'</div>'.PHP_EOL;
							$nextMonth = true;
						} else if (!$inFuture && $month != strftime('%m') && $month != strftime('%m', strtotime('+1 month'))) {
							echo '<div class="date_title">'.__('Furher on', true).'</div>'.PHP_EOL;
							$inFuture = true;
						}
						
						if (isset($dt['Birthdays'])) foreach ($dt['Birthdays'] as $bd) {
							echo '<div class="date_birthday">';
							echo $this->Html->image('ico_cake.gif');
							if ($bdShowDate) {
								$bd_string = __('%1$s celebrates %2$s %3$d birthday on %4$s.', true);
							} else {
								$bd_string = __('%1$s celebrates %2$s %3$d birthday.', true);
							}
							printf($bd_string,
								$this->Html->link($bd['d_n'], array(
									'controller' => 'profiles',
									'action'     => 'view',
									$bd['id']
								)),
								($bd['g']=='m')?__('his', true):__('her', true),
								$this->Date->age($bd['dob_y'] . '-' . str_pad($month, 2 , '0', STR_PAD_LEFT) . '-' . str_pad($day, 2 , '0', STR_PAD_LEFT)) + $oneIfFuture,
								'<b>'.$this->Date->format(
									Configure::read('noYearDateFormat'),
									$bd['dob_y'] . 
									'-' . 
									str_pad($month, 2 , '0', STR_PAD_LEFT) . 
									'-' . 
									str_pad($day, 2 , '0', STR_PAD_LEFT)
								).'</b>'
							);
							echo '</div>'.PHP_EOL;
						}
					}
				}
			?>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script('jquery.corner-2.03.min', true);
?>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#WelcomeMessage').corner();
	});
</script>