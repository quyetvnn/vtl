<?= $this->element('menu/top_menu') ?>
<?= $this->element('school_common/top_menu') ?>
<div class="school-left-sidebar">
	<?= $this->element('school_common/left_sidebar');?>
</div>
<div class="school-content">
	<div class="row mt-10 ">
		<table id="table_teacher_group" class="table a4l-table table-no-thead table-transpose table-teacher-group">
			<thead>
				<tr>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<?php
	echo $this->Html->script('pages/school/group.js?v='.date('U'));
?>
<script type="text/javascript">
	$(document).ready(function() {
		SCHOOL_GROUP.init_page();
		SCHOOL_GROUP.init_table_teacher('<?=$group_id?>');
	});
</script>