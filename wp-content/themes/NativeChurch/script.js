jQuery(document).ready(function(){
    jQuery('img').each(function(){
        var src = this.src;
        this.src = src.replace('95.183.10.70', 'pavelrai.ru');
    })
})