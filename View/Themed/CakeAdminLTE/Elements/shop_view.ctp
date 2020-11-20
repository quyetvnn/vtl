<!-- brand -->
<?php if ($shops): ?>
<h2>&nbsp;<i>Shops:</i></h2>
<div class="row">
	<div class="col-xs-12">
        <div class="row">
        <?php foreach ($shops as $shop): ?>
            <div class="col-xs-4">
                <div class="box box-primary">
                    <?php 
                        if (isset($shop_imgs[$shop['shop_detail_id']]) && !empty($shop_imgs[$shop['shop_detail_id']])) {
                            $style = '
                                height: 150px;
                                background:url('.Router::url('/',true).$shop_imgs[$shop['shop_detail_id']].') no-repeat;
                                background-size: cover; 
                            ';
                        }else{
                            $style = '';
                        }
                    ?>
                    <div class="box-header" style="<?php echo $style; ?>" >
                        <div class="box-tools pull-right">
                            <a href="<?php echo Router::url(array('plugin'=>'company','controller'=>'shops','action'=>'view','admin'=>true, $shop['shop_id'])) ?>" class="btn btn-primary">
                                <i class="fa fa-eercast"></i> View
                            </a>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php foreach ($shop_input_fields as $shop_input_field): ?>
                            <?php 

                                $ico = '';
                                $style = '';

                                if ( strpos($shop_input_field, 'name') !== false ) {
                                    $style = 'font-size: 28px; font-weigth:bold;';
                                }

                                if (
                                    strpos($shop_input_field, 'description') !== false
                                    ) {
                                    $style = 'font-size: 16px; font-style:italic; color: #ccc;';
                                }

                                if (
                                    strpos($shop_input_field, 'address') !== false
                                    ) {
                                    $style = 'font-size: 16px; color: #333;';
                                    $ico = '<i class="fa fa-map"></i>';
                                }

                                if (
                                    strpos($shop_input_field, 'content') !== false ||
                                    strpos($shop_input_field, 'terms') !== false ||
                                    strpos($shop_input_field, 'privacy') !== false ||
                                    strpos($shop_input_field, 'about') !== false
                                    ) {
                                    $style = 'font-size: 14px; color: #666;';
                                    $ico = '<i class="fa fa-paragraph"></i> '.ucfirst($shop_input_field);
                                }

                                if (
                                    strpos($shop_input_field, 'time') !== false ||
                                    strpos($shop_input_field, 'open') !== false
                                    ) {
                                    $style = 'font-size: 16px; color: #333;';
                                    $ico = '<i class="fa fa-clock-o"></i> ';
                                }

                                if (
                                    strpos($shop_input_field, 'remark') !== false
                                    ) {
                                    $style = 'font-size: 14px; color: #666;';
                                    $ico = '<p><i class="fa fa-paragraph"></i> '.ucfirst($shop_input_field).'</p>';
                                }

                                if (
                                    strpos($shop_input_field, 'hotline') !== false ||
                                    strpos($shop_input_field, 'phone') !== false
                                    ) {
                                    $style = 'font-size: 16px; color: #333;';
                                    $ico = '<i class="fa fa-phone"></i> ';
                                }

                            ?>
                            <div style="padding: 10px 0; <?php echo $style; ?>">
                                <?php echo $ico; ?> 
                                <?php echo ($shop[$shop_input_field]); ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="box-body">
                        <?php if (isset($_data['link_zho'])) echo  $this->Html->link($_data['link_zho'],$_data['link_zho']); ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
        </div>
    </div>
</div>
<?php endif ?>
<!-- /brand -->


