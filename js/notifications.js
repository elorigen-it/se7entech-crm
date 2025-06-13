$(document).ready(function(){
    
    function load_unseen_notification(view = '')
    {
    $.ajax({
    url:SE7ENTECH.base_url + "/fetch.php",
    method:"POST",
    data:{view:view},
    dataType:"json",
    success:function(data)
    {
        // $('.dropdown-menu').html(data.notification);
        if(data.unseen_notification > 0)
        {
        $('.count').html(data.unseen_notification);
        }
    }
    });
    }
    
    load_unseen_notification();
    
    $('#comment_form').on('submit', function(event){
    event.preventDefault();
    if($('#subject').val() != '' && $('#comment').val() != '')
    {
    var form_data = $(this).serialize();
    $.ajax({
        url:SE7ENTECH.base_url + "/insert.php",
        method:"POST",
        data:form_data,
        success:function(data)
        {
        $('#comment_form')[0].reset();
        load_unseen_notification();
        }
    });
    }
    else
    {
    alert("Both Fields are Required");
    }
    });
    
    $(document).on('click', '.dropdown-toggle', function(){
    $('.count').html('');
    load_unseen_notification('yes');
    });
    
    setInterval(function(){ 
    load_unseen_notification();; 
    }, 5000);
    
    });