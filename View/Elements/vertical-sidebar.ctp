<?php if( isset($dashboard_admin_menu) && !empty($dashboard_admin_menu) ){ ?>
	<ul>
		<?php
			foreach ($dashboard_admin_menu as $plugin => $controllers) {
				$plugin_active = ""; 

				if( isset($controllers['active']) ){
					$plugin_active = "active";
				}
				unset( $controllers['active'] );
		?>
				<li <?php if( !empty($plugin_active) ){ print ' class="'.$plugin_active.'"'; } ?>>
					<a href="#" alt="<?php print $plugin; ?>" title="<?php print $plugin; ?>">
						<span class="hidden-xs hidden-sm"><?php print ucfirst($plugin); ?></span>
					</a>

					<ul class="submenu">
		<?php
						foreach ($controllers as $controller) {
							$controller_active = "";
							if( isset($controller['active']) && ($controller['active'] == true) ){
								$controller_active = "active";
							}
		?>
							<li <?php if( !empty($controller_active) ){ print ' class="'.$controller_active.'"'; } ?>>
								<?php
									foreach ($controller['routes'] as $route) {
										$_route = $route;
										unset( $_route['active'] );

										$action_link = '<span class="hidden-xs hidden-sm">'. $controller['display_name'] . '</span>';

										print $this->Html->link( $action_link , $route, array(
											'alt' => $controller['display_name'],
											'title' => $controller['display_name'],
											'escape' => false
										) );

									}
								?>
							</li>
		<?php
						}
		?>
					</ul>
				</li>
		<?php
			}
		?>
	</ul>
<?php } ?>