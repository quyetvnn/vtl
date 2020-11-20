<?php echo $this->Html->css('datatables/dataTables.bootstrap'); ?>
<?php 
    echo $this->Form->create('Log.filter', array(
        'url' => array(
            'plugin' => 'log', 
            'controller' => 'log_apis', 
            'action' => 'index', 
            'admin' => true, 
            'prefix' => 'admin'
        ),
        'class' => 'form_filter',
        'type' => 'get',
    ));
?>

<?php echo $this->element('Log.log_api_filter', array(
	'data_search' => $data_search
)); ?>
<div class="row">
    <div class="col-xs-12">
        <div  class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo __('Logs'); ?></h3>

                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body table-responsive">
                <table id="Logs" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center"><?php echo $this->Paginator->sort('id', __('id')); ?></th>
                        <th class="text-center"><?php echo __('plugin'); ?></th>
                        <th class="text-center"><?php echo __('controller'); ?></th>
                        <th class="text-center"><?php echo __('action'); ?></th>
                       <th class="text-center"><?php echo $this->Paginator->sort('created', __('created')); ?></th>
                        <th class="text-center"><?php echo __('operation'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="text-center">  
                                <input type="checkbox" name="choose_id[]" value="<?php echo($log['LogApi']['id']); ?>" />
                            </td>
                            <td class="text-center"> <?php echo h($log['LogApi']['id']); ?> </td>
                            
                            <td class="text-center"><?= $log['LogApi']['plugin'] ?></td>
                            <td class="text-center"><?= $log['LogApi']['controller'] ?></td>
                            <td class="text-center"><?= $log['LogApi']['action'] ?></td>
                            <td class="text-center"><?php echo h($log['LogApi']['created']); ?></td>
                            <td class="text-center">
                                <?php echo $this->Html->link(__('<i class="fa fa-eercast"></i>'), array('plugin' => 'log', 'controller' => 'log_apis', 'action' => 'view', $log['LogApi']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'title' => __('view'))); ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /.index -->
    <?php echo $this->element('Paginator'); ?>	</div><!-- /#page-content .col-sm-9 -->
</div><!-- /#page-container .row-fluid -->

<?php echo $this->Form->end(); ?>

<?php
    echo $this->Html->script('plugins/datatables/jquery.dataTables');
    echo $this->Html->script('plugins/datatables/dataTables.bootstrap');
?>


<script type="text/javascript">
	$(document).ready(function(){
		COMMON.module_name = '_log_apis';
		COMMON.url_update_cache = '<?= Router::url(array('prefix' => 'admin', 'plugin' => '', 'controller' => 'redis', 'action' => 'update_column_cache'), true) ?>';
		COMMON.column_cache = <?= $column_cache; ?>;
        COMMON.init_visible_column_table();
    });
</script>