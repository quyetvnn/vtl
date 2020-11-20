<div class="row filter-panel">
	<div class="col-md-12">
		<div class="action-buttons-wrapper border-bottom">
			<div class="row">
                <div class="col-md-2 col-xs-4">
                    <div class="form-group">
                        <label for="selectpicker_plugin"><?= __('plugin'); ?></label>
                        <select name="plugin" 
                            id="selectpicker_plugin" 
                            class="form-control selectpicker"
                            data-live-search="true">
                            <option value=""><?= '-- ' . __('all') . ' ' . __('plugin'). ' --' ?></option>
                            <?php foreach($plugins as $item){?>
                                <option value="<?= $item ?>" <?= isset($data_search['plugin']) && $item == $data_search['plugin'] ? 'selected="selected"' : ''; ?>>
                                    <?= $item ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-xs-4">
                    <div class="form-group">
                        <label for="selectpicker_controler"><?= __('controller'); ?></label>
                        <select name="controller" 
                            id="selectpicker_controller" 
                            class="form-control selectpicker"
                            data-live-search="true">
                            <option value=""><?= '-- ' . __('all') . ' ' . __('controller'). ' --' ?></option>
                            <?php foreach($controllers as $item){?>
                                <option value="<?= $item ?>" <?= isset($data_search['controller']) && $item == $data_search['controller'] ? 'selected="selected"' : ''; ?>>
                                    <?= $item ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-xs-4">
                    <div class="form-group">
                        <label for="selectpicker_action"><?= __('action'); ?></label>
                        <select name="action" 
                            id="selectpicker_action" 
                            class="form-control selectpicker"
                            data-live-search="true">
                            <option value=""><?= '-- ' . __('all') . ' ' . __('action'). ' --' ?></option>
                            <?php foreach($actions as $item){?>
                                <option value="<?= $item ?>" <?= isset($data_search['action']) && $item == $data_search['action'] ? 'selected="selected"' : ''; ?>>
                                    <?= $item ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2 col-xs-4">
                    <div class="form-group">
                        <?php
                            // echo $this->Form->input("user_id", array(
                            //     'label' => __('administrator'), 
                            //     'empty' => '-- ' . __('all') . ' ' . __('administrator') . ' --', 
                            //     'default' => '',
                            //     'selected' => isset($data_search['user_id']) ? $data_search['user_id'] : '',
                            //     'class'=>'filter form-control selectpicker',
                            //     'data-live-search' => true
                            // ));
                        ?>
                    </div>
                </div>
                <div class="col-md-4 col-xs-8">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label><?= __d('member', 'start')?></label>
                                <?php
                                    echo $this->element('datetime_picker', array(
                                        'field_name' => 'start_period', 
                                        'label' => false, 
                                        'id' => 'start_period',
                                        'value' => isset($data_search['start_period']) ? $data_search['start_period'] : '',
                                        'class' => 'datepicker'
                                    ));
                                ?>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label ><?= __d('member', 'end')?></label>
                                <?php
                                    echo $this->element('datetime_picker', array(
                                        'field_name' => 'end_period', 
                                        'label' => false, 
                                        'id' => 'end_period',
                                        'value' => isset($data_search['end_period']) ? $data_search['end_period'] : '',
                                        'class' => 'datepicker'
                                    ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
			<div class="row">
				<div class="col-md-12">
                    <div class="pull-right vtl-buttons">
                        <?php
                            echo $this->Form->submit(__('submit'), array(
                                'class' => 'btn btn-primary btn-sm filter-button',
                            ));
                        ?>
                        <?php
                            echo $this->Html->link(__('reset'), array(
                                'plugin' => 'log', 'controller' => 'logs', 'action' => 'index',
                                'admin' => true, 'prefix' => 'admin'
                            ), array(
                                'class' => 'btn btn-danger btn-sm filter-button',
                            ));
                        ?>
                       
                    </div>
				</div> <!-- col-md-4 -->
			</div> <!-- row -->
		</div>
	</div>
</div>
