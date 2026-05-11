$('.ajaxNoteBodyByGet').on('click', function(e) {
    e.preventDefault(); // Отменяем переход по ссылке

   
    let noteId = $(this).data('contentid'); // Получаем ID заметки
    let $link = $(this); // Сохраняем ссылку, чтобы потом изменить её текст или скрыть

    $.ajax({
        url: $(this).attr('href'), // Берем URL из атрибута href
        method: 'GET',
        data: { id: noteId },// Передаем ID на сервер
        dataType: 'json' ,
        success: function(response) {
            // response — это то, что вернет сервер (например, текст заметки или JSON)
            console.log(response);
            
            // Пример: заменяем текст кнопки на полученный контент
           // $link.closest('li').html(response); 

           var formattedResponse = response.replace(/\n/g, '<br>');
           $link.closest('li').html(formattedResponse);
        },
        error: function() {
            alert('Ошибка при загрузке данных');
        }
    });
});