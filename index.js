const images = document.querySelectorAll('.img');

images.forEach(image => {
    image.addEventListener('mouseover', () => {
        image.style.transform = 'scale(1.2)'; 
        image.style.transition = 'transform 0.3s ease-in-out'; 
        image.style.zIndex = '1';
        image.style.boxShadow = '0 0 10px rgba(0,0,0,0.5)';
    });
    image.addEventListener('mouseout', () => {
        image.style.transform = 'scale(1)'; 
        image.style.transition = 'transform 0.3s ease-in-out'; 
        image.style.zIndex = '0';
        image.style.boxShadow = 'none';
    });
});



