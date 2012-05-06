jQuery(document).ready(function(){

jQuery('.blogtoy > :nth-child(2)').prepend('<div class="space1"></div>').append('<div class="space2"></div>').hide().prev().click(function(){ jQuery(this).next().slideToggle("medium"); 
});

});