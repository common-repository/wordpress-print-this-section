<?php
/* 
 * Prints the Admin Settings Page
 */
?>
<div class="wrap">
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<div id="icon-tools" class="icon32"></div><h2><?php _e( 'Print This Plugin Settings', 'print-this-section' ) ?></h2>
                <table class="form-table">
                    <tr><th><?php _e( 'Print This Button Text', 'print-this-section' ) ?></th>
                        <td><input type="text" name="button_text" value="<?php _e(apply_filters('format_to_edit',$this->admin_options['button_text']),'print-this-section'); ?>" /><br />
                            <?php _e( 'Leave blank for no text on print button.', 'print-this-section' ) ?>
                        </td>
                    </tr>
                    <tr><th><?php _e( 'Print This Button Image', 'print-this-section' ) ?></th>
                        <td><?php
					$print_image = $this->admin_options['button_image'];
					$print_image_url = plugins_url( 'wordpress-print-this-section/images' );
					$print_image_path =  WPPTS_PLUGIN_DIR . '/images';
					if ( $handle = @opendir( $print_image_path ) ) {
						while ( false !== ( $filename = readdir( $handle ) ) ) {
							if ( $filename != '.' && $filename != '..' ) {
								if ( is_file( $print_image_path . '/' . $filename ) ) {
									echo '<p>';
									if( $print_image == $filename ) {
										echo '<input type="radio" name="button_image" value="' . $filename . '" checked="checked" />'."\n";
									} else {
										echo '<input type="radio" name="button_image" value="' . $filename . '" />'."\n";
									}
									echo '&nbsp;&nbsp;&nbsp;';
									echo '<img src="' . $print_image_url . '/' . $filename . '" alt="' . $filename . '" />'."\n";
									echo '&nbsp;&nbsp;&nbsp;(' . $filename . ')';
									echo '</p>' . "\n";
								}
							}
						}
						closedir($handle);
					}
                                        echo '<p>';
                                        if ( 'none' == $print_image ) {
                                            echo '<input type="radio" name="button_image" value="none" checked="checked" />' . "\n";
                                        } else {
                                            echo '<input type="radio" name="button_image" value="none" />' . "\n";
                                        }
                                        echo '&nbsp;&nbsp;&nbsp;None</p>' . "\n";
                                        _e( 'If image is set to "none" and there is no button text, button text will default to "Print"', 'print-this-section' );
				?>
                        </td></tr>
                    <tr>
                        <th scope="row" valign="top"><?php _e('Print Post Title', 'print-this-section'); ?></th>
			<td>
				<select name="print_title" size="1">
					<option value="1"<?php selected('1', $this->admin_options['print_title']); ?>><?php _e('Yes', 'print-this-section'); ?></option>
					<option value="0"<?php selected('0', $this->admin_options['print_title']); ?>><?php _e('No', 'print-this-section'); ?></option>
				</select>
			</td>
                    </tr>
                    <tr>
                        <th scope="row" valign="top"><?php _e('Print Posted By Information', 'print-this-section'); ?></th>
			<td>
				<select name="print_by_line" size="1">
					<option value="1"<?php selected('1', $this->admin_options['print_by_line']); ?>><?php _e('Yes', 'print-this-section'); ?></option>
					<option value="0"<?php selected('0', $this->admin_options['print_by_line']); ?>><?php _e('No', 'print-this-section'); ?></option>
				</select>
			</td>
                    </tr>
                    <tr>
                        <th scope="row" valign="top"><?php _e('Print Article From Line', 'print-this-section'); ?></th>
			<td>
				<select name="print_article" size="1">
					<option value="1"<?php selected('1', $this->admin_options['print_article']); ?>><?php _e('Yes', 'print-this-section'); ?></option>
					<option value="0"<?php selected('0', $this->admin_options['print_article']); ?>><?php _e('No', 'print-this-section'); ?></option>
				</select>
			</td>
                    </tr>
                    <tr>
                        <th scope="row" valign="top"><?php _e('Print URL', 'print-this-section'); ?></th>
			<td>
				<select name="print_url" size="1">
					<option value="1"<?php selected('1', $this->admin_options['print_url']); ?>><?php _e('Yes', 'print-this-section'); ?></option>
					<option value="0"<?php selected('0', $this->admin_options['print_url']); ?>><?php _e('No', 'print-this-section'); ?></option>
				</select>
			</td>
                    </tr>
                    <tr>
                        <th scope="row" valign="top"><?php _e('Print Disclaimer or Copyright', 'print-this-section'); ?></th>
			<td>
				<select name="print_disclaimer" size="1">
					<option value="1"<?php selected('1', $this->admin_options['print_disclaimer']); ?>><?php _e('Yes', 'print-this-section'); ?></option>
					<option value="0"<?php selected('0', $this->admin_options['print_disclaimer']); ?>><?php _e('No', 'print-this-section'); ?></option>
				</select>
			</td>
                    </tr>
                    <tr>
			<th scope="row" valign="top"><?php _e('Disclaimer or Copyright Text', 'print-this-section'); ?></th>
			<td>
				<textarea rows="2" cols="80" name="disclaimer" id="print_template_disclaimer"><?php echo htmlspecialchars(stripslashes($this->admin_options['disclaimer'])); ?></textarea><br /><?php _e('HTML is allowed.', 'print-this-section'); ?><br />
			</td>
                    </tr>
                </table>
		<div class="submit">
			<input type="submit" name="update_print_this_settings" class="button-primary" value="<?php _e('Update Settings', 'print-this-section') ?>" />
		</div>
	</form>
</div>