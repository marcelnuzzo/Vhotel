$('#add-service').click(function(){
    //Je récupère le numéro des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();
    console.log(index);

    //Je récupère le prototype des entrées
    const tmpl = $('#hotel_services').data('prototype').replace(/__name__/g, index);

    //J'injecte ce code au sein de la div
    $('#hotel_services').append(tmpl);

    $('#widgets-counter').val(index + 1);

    //Je gère le bouton supprimer
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#hotel_services div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();