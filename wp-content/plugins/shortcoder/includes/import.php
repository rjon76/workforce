<?php

class Shortcoder_Import{
    
    public static function init(){
        
        add_action( 'wp_ajax_sc_export', array( __CLASS__, 'do_export' ) );
        
    }
    
    public static function import_form(){
        
        echo '<form method="post" enctype="multipart/form-data" id="import_form">';
        echo '<p class="import_desc"> ' . __( 'Are you sure want to import shortcodes ?', 'shortcoder' ) . '</p>';
        echo '<input type="file" name="import" id="import" accept="text/plain"/>';
        wp_nonce_field( 'sc_import_data' );
        echo '<input type="submit" />';
        echo '</form>';
        
    }
    
    public static function check_import(){
        
        if( isset( $_POST ) && !empty( $_FILES[ 'import' ][ 'tmp_name' ] ) ){
            
            check_admin_referer( 'sc_import_data' );
            
            $file = wp_import_handle_upload();

            if ( isset( $file['error'] ) ){
                self::print_notice( __( 'Failed to import file. Error: ', 'shortcoder' ) . $file['error'] );
                return false;
            }

            $file_id = absint( $file['id'] );
            $file_path = get_attached_file( $file_id );
            
            self::do_import( $file_path );
            
        }
        
    }
    
    public static function do_import( $file_path ){
        
        if ( !is_file( $file_path ) ){
            self::print_notice( __( 'Uploaded file does not exist for import. ', 'shortcoder' ) . $file_path );
        }
        
        $imported_json = file_get_contents( $file_path );
        $imported_data = json_decode( $imported_json, true );
        
        if( $imported_data && !empty( $imported_data ) ){
            
            $shortcodes = Shortcoder::list_all();
            $import_count = 0;
            
            if( isset( $imported_data[ 'shortcodes' ] ) ){
                
                foreach( $imported_data[ 'shortcodes' ] as $name => $content ){
                    $shortcodes[ $name ] = wp_parse_args( $content, Shortcoder::defaults() );
                    $import_count++;
                }
                
                if( update_option( 'shortcoder_data', $shortcodes ) ){
                    self::print_notice( $import_count . __( ' shortcodes imported successfully !', 'shortcoder' ), 'success' );
                }else{
                    self::print_notice( __( 'shortcodes are not updated because all the shortcodes remain the same.', 'shortcoder' ) );
                    return false;
                }
                
            }
            
        }else{
            self::print_notice( __( 'Failed to decode JSON in imported data.', 'shortcoder' ) );
        }
        
    }
    
    public static function do_export(){
        
        check_admin_referer( 'sc_export_data' );
        
        $export_file_name = 'shortcoder export ' . date( 'm/d/Y' ) . '.txt';
        $shortcodes = Shortcoder::list_all();
        
        $to_export = array(
            'shortcodes' => $shortcodes
        );
        
        $export_json = json_encode( $to_export );

        header('Content-Disposition: attachment; filename="' . $export_file_name . '"');
        header('Content-Type: text/plain');
        header('Content-Length: ' . strlen( $export_json ));
        header('Connection: close');
        
        echo $export_json;
        
    }
    
    public static function print_notice( $msg, $type = 'error' ){
        echo '<div class="notice notice-' . $type . ' is-dismissible"><p>' . $msg . '</p></div>';
    }
    
}

Shortcoder_Import::init();

?>