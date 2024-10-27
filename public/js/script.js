ClassicEditor.create(document.querySelector('#editor')).catch( error => {
    console.error(error);
});

function toggleMobileSearch() {
    const mobileSearch = document.querySelector('#mobile-search');
    mobileSearch.classList.toggle('active');
}

function closeMobileSearch() {
    const mobileSearch = document.querySelector('#mobile-search');
    mobileSearch.classList.remove('active');
}

function closeToast() {
    const progressBar = document.querySelector('.toast-progress');
    const toast = document.querySelector('.toast-success');
    progressBar.classList.remove('show');
    toast.classList.remove('show');
}

function previewImage(event) {
    const imagePreview = document.getElementById('imagePreview');
    const deleteFileButton = document.querySelector('.delete-file');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            deleteFileButton.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.style.display = 'none';
        deleteFileButton.style.display = 'none';
    }
}

function deleteFile() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const deleteFileButton = document.querySelector('.delete-file');
    
    imageInput.value = "";
    imagePreview.src = "#";
    imagePreview.style.display = 'none'; // Hide the image
    deleteFileButton.style.display = 'none'; // Hide delete button
}

/*=============== SLIDER ===============*/ 
const slider = document.getElementById('crs-slider');
const prevButton = document.getElementById('crs-btn-prev');
const nextButton = document.getElementById('crs-btn-next');

let scrollPosition = 0;

function scrollNext() {
    const itemWidth = slider.offsetWidth;
    scrollPosition += itemWidth;
    if (scrollPosition > slider.scrollWidth - slider.clientWidth) {
        scrollPosition = slider.scrollWidth - slider.clientWidth;
    }
    slider.scroll({
        left: scrollPosition,
        behavior: 'smooth'
    });
}

function scrollPrev() {
    const itemWidth = slider.offsetWidth;
    scrollPosition -= itemWidth;
    if (scrollPosition < 0) {
        scrollPosition = 0;
    }
    slider.scroll({
        left: scrollPosition,
        behavior: 'smooth'
    });
}