// Lightbox functionality
document.addEventListener('DOMContentLoaded', function() {
    const lightbox = document.getElementById('lightbox');
    const modalImg = document.getElementById('img01');
    const closeBtn = document.querySelector('.close');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    
    // Get all gallery images
    const galleryImages = document.querySelectorAll('.gallery');
    let currentImageIndex = 0;
    
    // Convert NodeList to Array for easier manipulation
    const imagesArray = Array.from(galleryImages);
    
    // Open lightbox with specific image
    function openLightbox(index) {
        currentImageIndex = index;
        const img = imagesArray[currentImageIndex];
        lightbox.style.display = 'block';
        modalImg.src = img.src;
    }
    
    // Show next image
    function showNextImage() {
        currentImageIndex = (currentImageIndex + 1) % imagesArray.length;
        const img = imagesArray[currentImageIndex];
        modalImg.src = img.src;
    }
    
    // Show previous image
    function showPrevImage() {
        currentImageIndex = (currentImageIndex - 1 + imagesArray.length) % imagesArray.length;
        const img = imagesArray[currentImageIndex];
        modalImg.src = img.src;
    }
    
    // Add click event to all gallery images
    galleryImages.forEach((img, index) => {
        img.addEventListener('click', function() {
            openLightbox(index);
        });
    });
    
    // Navigation button events
    nextBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        showNextImage();
    });
    
    prevBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        showPrevImage();
    });
    
    // Close lightbox when clicking the close button
    closeBtn.addEventListener('click', function() {
        lightbox.style.display = 'none';
    });
    
    // Close lightbox when clicking outside the image
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            lightbox.style.display = 'none';
        }
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (lightbox.style.display === 'block') {
            switch(e.key) {
                case 'Escape':
                    lightbox.style.display = 'none';
                    break;
                case 'ArrowLeft':
                    showPrevImage();
                    break;
                case 'ArrowRight':
                    showNextImage();
                    break;
            }
        }
    });
});
