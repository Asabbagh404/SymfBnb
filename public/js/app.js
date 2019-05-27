$("#add-image").click(function(){
    const index = +$('#widgets-counter').val();
    var datahtml = $("#annonce_images").data('prototype').replace(/_name/g, index);
    $("#annonce_images").append(datahtml);
    $('#widgets-counter').val(index + 1 )
    HandleDeleteButtons();
});

function HandleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        var target = this.dataset.target;
        console.log(target);
        $(target).remove();
    });
}
