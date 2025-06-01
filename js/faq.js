document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const faqItem = question.parentElement; // Get the parent .faq-item
        const answer = question.nextElementSibling;
        const isActive = faqItem.classList.contains('active'); // Check active on parent
                
        // Close other open questions
        document.querySelectorAll('.faq-item.active').forEach(openItem => {
            if (openItem !== faqItem) {
                openItem.classList.remove('active');
                const openAnswer = openItem.querySelector('.faq-answer');
                openAnswer.style.maxHeight = null;
            }
        });
                
        // Toggle current question
        if (isActive) {
            answer.style.maxHeight = null;
            faqItem.classList.remove('active'); // Remove from parent
        } else {
            answer.style.maxHeight = answer.scrollHeight + 'px';
            faqItem.classList.add('active'); // Add to parent
        }
    });
});