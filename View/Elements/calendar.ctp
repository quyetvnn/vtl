<div class="a4l-calendar">
	<div class="header-switcher">
		<ul class="switcher">
			<li class="item mode-calendar" id="mode-week" onclick="switch_mode_calendar('week')"><?=__d('member', 'week')?></li>
			<li class="item mode-calendar active" id="mode-month" onclick="switch_mode_calendar('month')"><?=__d('member', 'month')?></li>
		</ul>
	</div>
	<div class="function">
		<div class="item flex-start">
			<span class="date-summary" id="month_year_info">2020年4月</span>
		</div>
		<div class="item flex-end">
			<button class="btn btn-w-radius btn-grey btn-today"><?=__d('member', 'today')?></button>
			<i class="fa fa-angle-left text-grey-light arrow arrow-left pointer" onclick="render_prev_calendar()" aria-hidden="true"></i>
			<i class="fa fa-angle-right text-grey-light arrow arrow-right pointer" onclick="render_next_calendar()" aria-hidden="true"></i>
		</div>
	</div>
	<div class="calendar-render ">
		<div class="row-data header">
			<div class="col"><?=__d('member', 'sunday')?></div>
			<div class="col"><?=__d('member', 'monday')?></div>
			<div class="col"><?=__d('member', 'tuesday')?></div>
			<div class="col"><?=__d('member', 'wednesday')?></div>
			<div class="col"><?=__d('member', 'thursday')?></div>
			<div class="col"><?=__d('member', 'fri')?>T6</div>
			<div class="col"><?=__d('member', 'saturday')?></div>
		</div>
		<div class="date-render " id="date-render"></div>
	</div>
</div>
<?php
	echo $this->Html->script('a4l-calendar.js?v='.date('U'));
?>