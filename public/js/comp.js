$(document).ready(function () {
    var currentElements = 2;
    function getForm(elements)
    {
        if(elements > 10)
            elements = 10;

        $.ajax({
           type: 'POST',
           url: '/science/getform',
           data: { elements: elements} ,
           dataType: 'html',
           success: function (data) {
               $("#GraphForm").html(data);
               $(".selectpicker").each(function(){
                   $(this).selectpicker('render');
               });

           }
        });
    }

    getForm(currentElements);

    $("#ajout").click(function(){
        currentElements++;
        $("#GraphForm").html();
        getForm(currentElements);
    });

});
