window.addEventListener('DOMContentLoaded', (event) => {

    new Glider(document.querySelector('.glider'), {
        slidesToShow: 1,
        dots: '#dots',
        arrows: {
            prev: '.glider-prev',
            next: '.glider-next'
        }
    });
    
});