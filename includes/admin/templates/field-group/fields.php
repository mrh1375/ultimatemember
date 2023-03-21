<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields         = array();
$field_group_id = 0;
if ( isset( $_GET['tab'] ) && 'edit' === sanitize_key( $_GET['tab'] ) ) {
	$field_group_id = isset( $_GET['id'] ) ? absint( $_GET['id'] ) : 0;
	if ( ! empty( $field_group_id ) ) {
		$fields = UM()->admin()->field_group()->get_fields( $field_group_id );
	}
}

UM()->admin()->field_group()->field_row_template();
?>

<div class="um-fields-column um-field-group-builder" data-group_id="<?php echo esc_attr( $field_group_id ); ?>">
	<div class="um-fields-column-header<?php if ( empty( $fields ) ) { ?> hidden<?php } ?>">
		<div class="um-fields-column-header-order"><?php esc_html_e( '#', 'ultimate-member' ); ?></div>
		<div class="um-fields-column-header-name"><?php esc_html_e( 'Name', 'ultimate-member' ); ?></div>
		<div class="um-fields-column-header-metakey"><?php esc_html_e( 'Metakey', 'ultimate-member' ); ?></div>
		<div class="um-fields-column-header-type"><?php esc_html_e( 'Type', 'ultimate-member' ); ?></div>
		<div class="um-fields-column-header-actions">&nbsp;</div>
	</div>
	<div class="um-fields-column-content<?php if ( empty( $fields ) ) { ?> hidden<?php } ?>">
		<?php if ( ! empty( $fields ) ) { ?>
			<?php foreach ( $fields as $k => $field ) {
				// text-type field is default field type for the builder
				$field_settings_tabs     = UM()->admin()->field_group()->get_field_tabs( $field['type'] );
				$field_settings_settings = UM()->admin()->field_group()->get_field_settings( $field['type'], $field['id'] );

				$order    = $k + 1;
				$type     = UM()->admin()->field_group()->get_field_type( $field );
				$meta_key = UM()->admin()->field_group()->get_field_metakey( $field );
				?>
				<div class="um-field-row" data-field="<?php echo esc_attr( $field['id'] ); ?>">
					<input type="hidden" class="um-field-row-id" name="field_group[fields][<?php echo esc_attr( $field['id'] ); ?>][id]" value="<?php echo esc_attr( $field['id'] ); ?>" />
					<input type="hidden" class="um-field-row-parent-id" name="field_group[fields][<?php echo esc_attr( $field['id'] ); ?>][parent_id]" value="<?php echo esc_attr( $field['parent_id'] ); ?>" />
					<input type="hidden" class="um-field-row-order" name="field_group[fields][<?php echo esc_attr( $field['id'] ); ?>][order]" value="<?php echo esc_attr( $order ); ?>" />
					<div class="um-field-row-header um-field-row-toggle-edit">
						<span class="um-field-row-move-link">
							<?php echo esc_html( $order ); ?>
						</span>
						<span class="um-field-row-title um-field-row-toggle-edit">
							<?php
							if ( ! empty( $field['title'] ) ) {
								echo esc_html( $field['title'] );
							} else {
								esc_html_e( '(no title)', 'ultimate-member' );
							}
							?>
						</span>
						<span class="um-field-row-metakey um-field-row-toggle-edit"><?php echo ! empty( $meta_key ) ? esc_html( $meta_key ) : esc_html__( '(no metakey)', 'ultimate-member' ); ?></span>
						<span class="um-field-row-type um-field-row-toggle-edit"><?php echo esc_html( $type ); ?></span>
						<span class="um-field-row-actions um-field-row-toggle-edit">
							<a href="javascript:void(0);" class="um-field-row-action-edit"><?php esc_html_e( 'Edit', 'ultimate-member' ); ?></a>
							<a href="javascript:void(0);" class="um-field-row-action-duplicate"><?php esc_html_e( 'Duplicate', 'ultimate-member' ); ?></a>
							<a href="javascript:void(0);" class="um-field-row-action-delete"><?php esc_html_e( 'Delete', 'ultimate-member' ); ?></a>
						</span>
					</div>
					<div class="um-field-row-content">
						<div class="um-field-row-tabs">
							<?php
							foreach ( $field_settings_tabs as $tab_key => $tab_title ) {
								$classes = array();
								if ( 'general' === $tab_key ) {
									// General tab is selected by default for the new field.
									$classes[] = 'current';
								}
								?>

								<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-tab="<?php echo esc_attr( $tab_key ); ?>">
									<?php echo esc_html( $tab_title ); ?>
								</div>

								<?php
							}
							?>
						</div>
						<div class="um-field-row-tabs-content">
							<?php
							foreach ( $field_settings_settings as $tab_key => $settings_fields ) {
								$classes = array();
								if ( 'general' === $tab_key ) {
									// General tab is selected by default for the new field.
									$classes[] = 'current';
								}
								?>
								<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>" data-tab="<?php echo esc_attr( $tab_key ); ?>">
									<?php
									echo UM()->admin()->field_group()->get_tab_fields_html( $tab_key, array( 'type' => UM()->admin()->field_group()->get_field_type( $field, true ), 'index' => $field['id'] ) );
									?>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>
	</div>
	<div class="um-fields-column-empty-content<?php if ( ! empty( $fields ) ) { ?> hidden<?php } ?>">
		<strong><?php esc_html_e( 'There aren\'t any fields yet. Add them below.', 'ultimate-member' ); ?></strong>
	</div>
	<div class="um-fields-column-footer">
		<input type="button" class="um-add-field-to-column button button-primary" value="<?php esc_attr_e( 'Add new field', 'ultimate-member' ); ?>" />
	</div>
</div>
