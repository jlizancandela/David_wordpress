<div class="wrap about-wrap full-width-layout qlwrap">
	<form method="post" id="qlwapp_scheme_form">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><?php esc_html_e( 'Font Family', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<select placeholder="<?php esc_html_e( 'Web Default', 'wp-whatsapp-chat' ); ?>" name="font_family" value="<?php echo esc_attr( $scheme['font_family'] ); ?>">
						<option value="inherit" <?php selected( $scheme['font_family'], 'inherit' ); ?>><?php esc_html_e( 'Web Default', 'wp-whatsapp-chat' ); ?></option>
						<option value="Arial" <?php selected( $scheme['font_family'], 'Arial' ); ?>>Arial (sans-serif)</option>
						<option value="Verdana" <?php selected( $scheme['font_family'], 'Verdana' ); ?>>Verdana (sans-serif)</option>
						<option value="Helvetica" <?php selected( $scheme['font_family'], 'Helvetica' ); ?>>Helvetica (sans-serif)</option>
						<option value="Tahoma" <?php selected( $scheme['font_family'], 'Tahoma' ); ?>>Tahoma (sans-serif)</option>
						<option value="Trebuchet MS" <?php selected( $scheme['font_family'], 'Trebuchet MS' ); ?>>Trebuchet MS (sans-serif)</option>
						<option value="Times New Roman" <?php selected( $scheme['font_family'], 'Times New Roman' ); ?>>Times New Roman (serif)</option>
						<option value="Georgia" <?php selected( $scheme['font_family'], 'Georgia' ); ?>>Georgia (serif)</option>
						<option value="Garamond" <?php selected( $scheme['font_family'], 'Garamond' ); ?>>Garamond (serif)</option>
						<option value="Courier New" <?php selected( $scheme['font_family'], 'Courier New' ); ?>>Courier New (monospace)</option>
						<option value="Brush Script MT" <?php selected( $scheme['font_family'], 'Brush Script MT' ); ?>>Brush Script MT (cursive)</option>
						<option value="Calibri" <?php selected( $scheme['font_family'], 'Calibri' ); ?>>Calibri (sans-serif)</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Font Size', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input placeholder="<?php esc_html_e( 'In pixels', 'wp-whatsapp-chat' ); ?>" type="number" name="font_size" value="<?php echo esc_attr( $scheme['font_size'] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Background', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="text" name="brand" value="<?php echo esc_attr( $scheme['brand'] ); ?>" />
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Color', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="text" name="text" value="<?php echo esc_attr( $scheme['text'] ); ?>" />
					</td>
				</tr>				
				<tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Icon Size', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input placeholder="<?php esc_html_e( 'In pixels', 'wp-whatsapp-chat' ); ?>" type="number" name="icon_size" value="<?php echo esc_attr( $scheme['icon_size'] ); ?>" />
					</td>
				</tr>				
				<tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Icon Font Size', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input placeholder="<?php esc_html_e( 'In pixels', 'wp-whatsapp-chat' ); ?>" type="number" name="icon_font_size" value="<?php echo esc_attr( $scheme['icon_font_size'] ); ?>" />
					</td>
				</tr>
				<!--tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Link', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="link" name="link" value="<?php echo esc_attr( $scheme['link'] ); ?>" />
						<p class="description hidden"><small><?php esc_html_e( 'This is a premium feature', 'wp-whatsapp-chat' ); ?></small></p>
					</td>
				</tr>
					<tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Message', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="link" name="message" value="<?php echo esc_attr( $scheme['message'] ); ?>" />
						<p class="description hidden"><small><?php esc_html_e( 'This is a premium feature', 'wp-whatsapp-chat' ); ?></small></p>
					</td>
				</tr>
				<tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Label', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="link" name="label" value="<?php echo esc_attr( $scheme['label'] ); ?>" />
						<p class="description hidden"><small><?php esc_html_e( 'This is a premium feature', 'wp-whatsapp-chat' ); ?></small></p>
					</td>
				</tr>
				<tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Name', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="link" name="name" value="<?php echo esc_attr( $scheme['name'] ); ?>" />
						<p class="description hidden"><small><?php esc_html_e( 'This is a premium feature', 'wp-whatsapp-chat' ); ?></small></p>
					</td>
				</tr-->
			</tbody>
		</table>
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<?php echo esc_html__( 'Contact settings', 'wp-whatsapp-chat' ); ?>
					</th>
				</tr>
				<tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Role color', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="link" name="contact_role_color" value="<?php echo esc_attr( $scheme['contact_role_color'] ); ?>" />
						<p class="description hidden"><small><?php esc_html_e( 'This is a premium feature', 'wp-whatsapp-chat' ); ?></small></p>
					</td>
				</tr>
				<tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Name color', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="link" name="contact_name_color" value="<?php echo esc_attr( $scheme['contact_name_color'] ); ?>" />
						<p class="description hidden"><small><?php esc_html_e( 'This is a premium feature', 'wp-whatsapp-chat' ); ?></small></p>
					</td>
				</tr>
				<tr class="qlwapp-premium-field">
					<th scope="row"><?php esc_html_e( 'Availability color', 'wp-whatsapp-chat' ); ?></th>
					<td>
						<input class="qlwapp-color-field" type="link" name="contact_availability_color" value="<?php echo esc_attr( $scheme['contact_availability_color'] ); ?>" />
						<p class="description hidden"><small><?php esc_html_e( 'This is a premium feature', 'wp-whatsapp-chat' ); ?></small></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php wp_nonce_field( 'qlwapp_save_scheme', 'qlwapp_scheme_form_nonce' ); ?>
		<p class="submit">
			<?php submit_button( esc_html__( 'Save', 'wp-whatsapp-chat' ), 'primary', 'submit', false ); ?>
			<span class="settings-save-status">
				<span class="saved"><?php esc_html_e( 'Saved successfully!' ); ?></span>
				<span class="spinner" style="float: none"></span>
			</span>
		</p>
	</form>
</div>
