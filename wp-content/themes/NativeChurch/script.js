jQuery(document).ready(function($){
    compose_pagination();
    
    $(document).find('input[name=pagination_gal]').on('click', function(){
        var current_page = $('.paging-input_0 .total-pages_0:first-child').text().trim();
        var move_page = this.value;
        var temp_value;
        
        if(current_page < move_page) {
            move_page = parseInt(move_page) - 1;
            spider_page_0(this, move_page, 1);
        }
        if(current_page > move_page) {
            move_page = parseInt(move_page) + 1;
            spider_page_0(this, move_page, -1);
        }
        
        //compose_pagination();  
        
        console.log(current_page, move_page);
    })

    function compose_pagination(){
        var el ='';
        var page_count = $('.paging-input_0 .total-pages_0:last-child').text().trim();
        for(var i=1; i<=page_count; i++){
            if(i == 1) el = '<label class="radio-inline"><input type="radio" name="pagination_gal" value="'+i+'" checked></label>';
            else el = '<label class="radio-inline"><input type="radio" name="pagination_gal" value="'+i+'"></label>';
            $('#bwg_container1_0').append(el);
        }
    }
})

