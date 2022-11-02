// Установка слушателя события наведения на картнки с общим классом
const zoom_objects = $('.product__image-zoom'); // Массив
const zoom = $('#zoom'); // Чтобы не обращаться через $ каждый раз (оптимизация)

// Навешивание стольких слушателей, сколько картинок для зумирования
for(let i = 0; i < zoom_objects.length; i++) {
  $(zoom_objects[i]).on('mouseover', function() {
    zoom.attr('src', $(this).attr('src')).css({
      'width': '340px',
      'height': '492px'
    });
  });
}

$('#zoom').on('mouseover', function(e) {
    // Реализация зумирования при помощи сторонней библиотеки
    $('#zoom').attr('data-magnify-src', $('#zoom').attr('src'));
    $('#zoom').magnify();


    // Реализация зумирования при помощи стандартного jQuery
    /*$('.product__images-zoom').wrap('<div></div>', {
      class: 'product__temp-div-to-zoom'
    }).css({
      'display':'inline-block',
      'overflow': 'hidden'
    });*/

    //$('#zoom').css({
    //  'transform': 'scale(1.3)'
    //});
});

/*
// Реализация зумирования при помощи стандартного jQuery
$('#zoom').on('mouseout', function(e) {
  $('#zoom').css({
    'transform': 'scale(1)'
  });

  $('.product__images-zoom').unwrap(); // Удаление приближения
  $('.product__images-zoom').attr('style',null);
  $('#zoom').attr('style',null);
});
*/

$('#buy').on('click', function(e) {
    let layout = 'topRight';
    let count = $('#count').text();
    let n = noty({
          'text'        : 'В корзину добавлено ' + count + ' товаров',
          'text-align'  : 'center',
          'type'        : 'alert',
          'layout'      : layout,
          'timeout'     : '1500',
          'animateOpen': {
                          'width': '[ "toggle", "swing" ]',
                          'height': '[ "toggle", "swing" ]',
                          'opacity': 'toggle',
                          'bottom': '-10px'
                        },
          'animateClose': {
                          'width': '[ "toggle", "swing" ]',
                          'height': '[ "toggle", "swing" ]',
                          'opacity': 'toggle',
                          'bottom': '5px'
                        },
          'closeOnSelfClick': false
      });
});
