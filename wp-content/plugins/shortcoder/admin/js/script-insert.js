(function($){
    
$(document).ready(function(){
    
    var last_sort = 'desc';
    
    var send_editor = function( content = '' ){
        if( typeof parent.send_to_editor === 'function' ){
            parent.send_to_editor( content );
        }else{
            alert( 'Editor does not exist. Cannot insert content !' );
        }
    }
    
    var close_window = function(){
        if( typeof parent.tb_remove === 'function' ){
            parent.tb_remove();
        }
    }
    
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
    
    $('.sc_shortcode_name').append('<span class="sc_toggle"></span>');
    
    $( document ).on( 'click', '.sc_insert', function(){
        
        var params = '';
        var scname = $(this).closest( '.sc_shortcode' ).attr( 'data-name' );
        var sc = '';
        
        $(this).parent().children().find('input[type="text"]').each(function(){
            if($(this).val() != ''){
                attr = $(this).attr('data-param');
                val = $(this).val().replace( /\"/g, '' );
                params += attr + '="' + val + '" ';
            }
        });
        
        sc = '[sc name="' + scname + '" ' + params + ']';
        send_editor( sc );
        close_window();
        
    });
    
    $( document ).on( 'click', '.sc_quick_insert', function(){
        
        var scname = $(this).closest( '.sc_shortcode' ).attr( 'data-name' );
        var sc = '[sc name="' + scname + '"]';
        
        send_editor( sc );
        close_window();
        
    });
    
    $( document ).on( 'click', '.sc_shortcode_name', function(e){
        $('.sc_params').slideUp();
        if($(this).next('.sc_params').is(':visible')){
            $(this).next('.sc_params').slideUp();
        }else{
            $(this).next('.sc_params').slideDown();
        }
    });
    
    $( document ).on( 'change', '.coffee_amt', function(){
        var btn = $( '.buy_coffee_btn' );
        btn.attr( 'href', btn.data( 'link' ) + $(this).val() );
    });
    
    $( document ).on( 'click', '.sort_btn', function(){
        last_sort = ( last_sort == 'asc' ) ? 'desc' : 'asc';
        sort( $( '.sc_shortcode' ), last_sort );
    });
    
});
    
})( jQuery );