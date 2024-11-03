document.addEventListener('DOMContentLoaded', function() {
    console.log('Test Page JavaScript Loaded');

    const testButton = document.createElement('button');
    testButton.textContent = 'Click Me';
    testButton.className = 'mt-4 px-4 py-2 bg-blue-500 text-white rounded';

    testButton.addEventListener('click', function() {
        alert('Button Clicked!');
    });

    document.querySelector('.p-6').appendChild(testButton);
});