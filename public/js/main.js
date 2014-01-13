$(document).ready(function(){
    $('.addtocart').click(function(){console.log($(this).attr('id'));
        $.ajax({
            type:'POST',
            url: '/cart/add',
            data: { 
            	id: $(this).attr('id'),
            	qty: 2,
            	price: 2.99,
            	name: $(this).parents('tr').find('.name').attr('id'),
    			size: 'M', 
    			color: 'Black'
            },
            dataType: "html",
            success: function(data, textStatus, jqXHR) {
                //scrollTo("checkout-steps");
                console.log('success');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
            }
        });
    });
});