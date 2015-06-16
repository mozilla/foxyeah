<?php 
add_action( 'admin_menu', 'remove_admin_menus' );
add_action( 'admin_menu', 'remove_admin_submenus' );

//Remove top level admin menus
function remove_admin_menus() {
    // remove_menu_page( 'edit-comments.php' );
    //remove_menu_page( 'link-manager.php' );
    //remove_menu_page( 'tools.php' );
    //remove_menu_page( 'plugins.php' );
    //remove_menu_page( 'users.php' );
    //remove_menu_page( 'options-general.php' );
    //remove_menu_page( 'upload.php' );
    // remove_menu_page( 'edit.php' );
    // remove_menu_page( 'edit.php?post_type=page' );
    // remove_menu_page( 'themes.php' );
}


//Remove sub level admin menus
function remove_admin_submenus() {
    // remove_submenu_page( 'themes.php', 'theme-editor.php' );
    // remove_submenu_page( 'themes.php', 'themes.php' );
    // remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
    // remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
    // remove_submenu_page( 'edit.php', 'post-new.php' );
    // remove_submenu_page( 'themes.php', 'nav-menus.php' );
    // remove_submenu_page( 'themes.php', 'widgets.php' );
    // remove_submenu_page( 'themes.php', 'theme-editor.php' );
    // remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
    // remove_submenu_page( 'plugins.php', 'plugin-install.php' );
    // remove_submenu_page( 'users.php', 'users.php' );
    // remove_submenu_page( 'users.php', 'user-new.php' );
    // remove_submenu_page( 'upload.php', 'media-new.php' );
    // remove_submenu_page( 'options-general.php', 'options-writing.php' );
    // remove_submenu_page( 'options-general.php', 'options-discussion.php' );
    // remove_submenu_page( 'options-general.php', 'options-reading.php' );
    // remove_submenu_page( 'options-general.php', 'options-discussion.php' );
    // remove_submenu_page( 'options-general.php', 'options-media.php' );
    // remove_submenu_page( 'options-general.php', 'options-privacy.php' );
    // remove_submenu_page( 'options-general.php', 'options-permalinks.php' );
    // remove_submenu_page( 'index.php', 'update-core.php' );
}

?>