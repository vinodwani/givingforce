$(document).on('click','#charityStatus',function(e) {
    var charityId = $(this).closest('tr').attr('id');
    var button = $(this);
    
    $.ajax({
         data: {"status": $(this).attr("value"), "charityId":charityId},
         type: "post",
         url: base_url+'/charity/update',
         success: function(data) {
            var content = '';
             var obj = $.parseJSON(data);
             
             button.val(obj.status);
             if (obj.status == 1) {
                content = 'Disapprove';
                $('#charityFlag_'+charityId).html('Yes');
             } else {
                content = 'Approve';
                $('#charityFlag_'+charityId).html('No');
             }
             button.text(content);
         }
    });
});