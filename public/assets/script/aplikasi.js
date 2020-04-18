$(document).ready(function(){
    var key = localStorage.getItem('user_token');
    var user = 1;
    if (!key) {
        $.ajax({
            url: APP_URL+'/logout',
            type: 'POST',
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {id : user},
        })
        .done(function(resp) {
            if (resp.success) {
              localStorage.removeItem('user_name');
              localStorage.removeItem('user_token');
              localStorage.removeItem('user_id');
              window.location.href = APP_URL;
                    
            }
            else
            $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
        })
        .fail(function() {
            $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
            
        });

    }

   
});