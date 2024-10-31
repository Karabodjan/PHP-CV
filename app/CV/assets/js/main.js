// Get the theme selector before adding the event listener
const themeSelector = document.getElementById('theme-selector');

// Load theme from localStorage
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    document.body.className = savedTheme;
    themeSelector.value = savedTheme; 
}

// Change theme
themeSelector.addEventListener('change', function() {
    const selectedTheme = this.value;
    document.body.className = selectedTheme;
    localStorage.setItem('theme', selectedTheme); 
});

// Code for the modal
var modal = document.getElementById("myModal");
var btn = document.getElementById("updateBtn");
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks the <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks outside the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Generate PDF button event
document.getElementById('generate-pdf').addEventListener('click', () => {
    const element = document.querySelector('.container'); 
    const options = {
        margin:       [10, 10, 10, 10],
        filename:     'CV.pdf',
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'mm', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().from(element).set(options).save();
});
