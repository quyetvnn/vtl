var ADMIN_LOG = {
    init_highlight_changed_data: function(){
        if(!($('.success-area').length && $('.error-area').length)){
            return;
        }

        var new_data = [];
        $.each($('.success-area li'), function(index, item){
            if($(item).html() && $(item).html().indexOf('<ul>') === -1){
                new_data.push({
                    item: item,
                    value: $(item).text().replace(/\s/g,'')
                });
            }
        });

        var old_data = [];
        $.each($('.error-area li'), function(index, item){
            if($(item).html() && $(item).html().indexOf('<ul>') === -1){
                old_data.push({
                    item: item,
                    value: $(item).text().replace(/\s/g,'')
                });
            }
        });

        for(var i = 0; i < new_data.length; i++){
            if(typeof(old_data[i]) != "undefined" && old_data[i].value != new_data[i].value) {
                $(old_data[i].item).addClass('text-red');
                $(new_data[i].item).addClass('text-red');
            }
        }
    },
}