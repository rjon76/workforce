(function($){
$(document).ready(function(){
    
    var delete_ctext = 'Are you sure want to delete this shortcode ?';
    var last_sort = 'desc';
    
    var sort = function( ele, orderby ){
        var total = ele.length;
        while( total ){
            ele.each(function(){
                var $cur = $(this);
                var $next = $cur.next();
                if( $next.length ){
                    var cur_name = $cur.attr( 'data-name' ).toLowerCase();
                    var nxt_name = $next.attr( 'data-name' ).toLowerCase();
                    if( ( orderby == 'asc' && cur_name > nxt_name ) || ( orderby == 'desc' && cur_name < nxt_name ) ){
                        $next.after( $cur );
                    }
                }
            });
            total--;
        }
    }
    
    $( document ).on( 'click', '.sc_delete', function(e){
        
        e.preventDefault();
        
        var del_btn = $(this);
        var href = del_btn.attr( 'href' );
        var confirm_user = confirm( delete_ctext );
        
        if( confirm_user ){
            
            var ajax = $.get( href );
            del_btn.addClass( 'spin' );
            
            ajax.done(function( data ){
                if( data.search( 'DELETED' ) != -1 ){
                    del_btn.closest( 'li' ).fadeOut( 'slow', function(){
                        $(this).remove();
                    });
                }else{
                    alert( 'Delete failed ! - ' + data );
                }
            });
            
            ajax.fail(function(){
                alert( 'Auth failed !' );
            });
            
        }
        
    });
    
    $( document ).on( 'click', '.sc_delete_ep', function(e){
        
        e.preventDefault();
        
        var $delete_btn = $(this);
        var href = $delete_btn.attr( 'href' );
        var confirm_user = confirm( delete_ctext );
        
        if( confirm_user ){
            
            var ajax = $.get( href );
            $delete_btn.addClass( 'spin' );
            
            ajax.done(function( data ){
                if( data.search( 'DELETED' ) != -1 ){
                    var back_href = $( '.sc_back_btn' ).attr( 'href' );
                    window.location = back_href + '&msg=3';
                }else{
                    alert( 'Delete failed ! - ' + data );
                }
            });
            
            ajax.fail(function(){
                alert( 'Auth failed !' );
            });
            
            $delete_btn.removeClass( 'spin' );
            
        }
        
    });
    
    $( document ).on( 'click', '.sc_copy', function(e){
        
        e.preventDefault();
        
        var btn = $(this);
        var box = btn.closest( 'li' ).find( '.sc_copy_box' );
        
        $( '.sc_copy_box' ).not( box ).hide();
        
        box.fadeToggle();
        box.select();
        
    });
    
    $(window).load(function(){
        $( '.wp-media-buttons' ).append(function(){
            return '<button class="button button-primary sc_insert_params"><span class="dashicons dashicons-plus"></span> Insert shortcode paramerters <span class="dashicons dashicons-arrow-down"></span></button>';
        });
        $( '.params_wrap' ).appendTo( 'body' );
        $( '.quicktags-toolbar' ).append(function(){
            return '<a href="#" class="ed_button button button-small fright sc_enable_vedit" title="Enable visual editor"><span class="dashicons dashicons-visibility"></span></a>';
        });
    });
    
    $( document ).on( 'click', '.sc_insert_params', function(e){
        
        e.preventDefault();
        
        var offset = $(this).offset();
        var mtop = offset.top + $(this).outerHeight();
        
        $( '.params_wrap' ).css({
            top: mtop,
            left: offset.left
        }).toggle();
    });
    
    $( document ).on( 'click', '.cp_btn', function(){
        
        var $cp_box = $( '.cp_box' );
        var $cp_info = $( '.cp_info' );
        var param_val = $cp_box.val().trim();
        
        if( param_val != '' && $cp_box[0].checkValidity() ){
            send_to_editor( '%%' + param_val + '%%' );
            $cp_info.removeClass( 'red' );
            $( '.params_wrap' ).hide();
        }else{
            $cp_info.addClass( 'red' );
        }
        
    });
    
    $( document ).on( 'click', '.wp_params li', function(){
        
        send_to_editor( '$$' + $(this).data( 'id' ) + '$$' );
        $( '.params_wrap' ).hide();
        
    });
    
    $( document ).on( 'change', '.coffee_amt', function(){
        var btn = $( '.buy_coffee_btn' );
        btn.attr( 'href', btn.data( 'link' ) + $(this).val() );
    });
    
    $( document ).on( 'click', '.sort_btn', function(){
        last_sort = ( last_sort == 'asc' ) ? 'desc' : 'asc';
        sort( $( '.sc_list li' ), last_sort );
        $( '.sort_icon' ).toggleClass( 'dashicons-arrow-down-alt' );
        $( '.sort_icon' ).toggleClass( 'dashicons-arrow-up-alt' );
    });
    
    $( document ).on( 'change', '#import', function(){
        
        if( confirm( $( '.import_desc' ).text() ) ){
            $( '#import_form' ).submit();
        }
        
    });
    
    $( document ).on( 'click', '.sc_enable_vedit', function(e){
        e.preventDefault();
        window.location = window.location + '&visual_edit=1';
    });
    
});
})( jQuery );