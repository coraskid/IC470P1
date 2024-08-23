document.addEventListener('DOMContentLoaded', () => {
    const sortButton = document.getElementById('sort-date');
    const topicList = document.querySelector('.topic-list');
    
    sortButton.addEventListener('click', () => {
        const topics = Array.from(topicList.children);
        
        topics.sort((a, b) => {
            const dateA = new Date(a.getAttribute('data-date'));
            const dateB = new Date(b.getAttribute('data-date'));
            return dateB - dateA; // Sort in descending order
        });
        
        // Reattach sorted topics to the DOM
        topicList.innerHTML = '';
        topics.forEach(topic => topicList.appendChild(topic));
    });
});