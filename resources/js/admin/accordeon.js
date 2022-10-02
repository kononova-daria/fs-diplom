document.addEventListener('DOMContentLoaded', function() {
    const headers = Array.from(document.getElementsByClassName('conf-step-header'));
    headers.forEach(header => header.addEventListener('click', () => {
        header.classList.toggle('conf-step-header_closed');
        header.classList.toggle('conf-step-header_opened');
    }));
});
