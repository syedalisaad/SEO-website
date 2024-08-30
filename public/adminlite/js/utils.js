function activeSidebarMenuByURL( ref_url )
{
    var ref_url = ref_url || window.location.href;
    var policy_params   = ['create', '$1/edit', 'index', '$1/show'];

    ref_url = ref_url.replace(/[0-9]+/g, "$1");
    //console.log('ref_url', ref_url);

    var block_li = menu_url = block_tree = null;
    const sidebarBlock = $('.constActiveSidebar');
    sidebarBlock.find('li, a').removeClass('menu-open').removeClass('active');

    sidebarBlock.find('ul.nav-sidebar li').each(function(index, value){

        block_li    = $(value);
        menu_url    = block_li.find('a').attr('href');

        if( null == menu_url || -1 != $.inArray(menu_url, [ '#', 'javascript:void(0)', 'undefined']) ) {
            return;
        }
        //console.log('menu_url', menu_url );

        menu_url = menu_url.replace(/[0-9]+/g, "$1");
        //console.log('menu_url', menu_url );

        var active_sidebar = function() {
            if( block_li.closest('.has-treeview').length ) {
                block_tree = block_li.closest('.has-treeview');
                block_tree.addClass('menu-open').find('a:first').addClass('active');
            }

            block_li.find('a').addClass('active');
        }

        if( menu_url  == ref_url ) {
            active_sidebar();
        }
        else
        {
            $.each( policy_params, function( policy_index, policy_value ){
                if ( menu_url + '/' + policy_value == ref_url ) {
                    active_sidebar();
                }
            })
        }
    });
}


$(function(){

    let base_url = $('meta[name=base-url]').attr('content');
    base_url = base_url.slice(0, base_url.lastIndexOf('/'));

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $loading = $('#const-spinner');
    $loading.hide();

    $("form")
        .on('submit', function(){

        $loading.show();

        setTimeout(function(){

            $loading.hide();

            return true;
        }, 1000)
    });

    $(document)
    .ajaxStart(function () {
        //$loading.show();
    })
    .ajaxStop(function () {
        //$loading.hide();
    });

    //Initialize Select2 Elements
    $('.select2').select2();

    const CURRENT_URL   = window.location.href;
    const CSRF_TOKEN    = $('meta[name=csrf-token]').attr('content');

    activeSidebarMenuByURL( CURRENT_URL );

    // Retrieve :: Level 2 Categories
   $('.const-level-1-categgories').on('change', function () {

       let render_subcategory  = $('select[name=subcategory_id]');
       let option_subcategory  = '<option value="" disabled="" selected="">Select your subcategory</option>';

       let api_url = (base_url + '/categories/retrieve/level2/' + $(this).val());

       $.get(api_url).done(function( response )
       {
           if( response.status == true ) {

               let data = response.collection;

               $.each( data, function(index, value){
                   option_subcategory += '<option value="'+index+'" >'+value+'</option>';
               });

               render_subcategory.html( option_subcategory );
               return;
           }
       });

       render_subcategory.html( option_subcategory );
   })

});
