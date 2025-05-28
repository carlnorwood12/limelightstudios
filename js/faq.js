document.querySelectorAll('.faq-question').forEach(question => {
    question.addEventListener('click', () => {
        const answer = question.nextElementSibling;
        const isActive = question.classList.contains('active');
        
        // Close other open questions
        document.querySelectorAll('.faq-question.active').forEach(openQuestion => {
            if (openQuestion !== question) {
                openQuestion.classList.remove('active');
                const openAnswer = openQuestion.nextElementSibling;
                openAnswer.classList.remove('active');
                openAnswer.style.maxHeight = null;
            }
        });
        
        // Toggle current question
        if (isActive) {
            answer.style.maxHeight = null;
            question.classList.remove('active');
            answer.classList.remove('active');
        } else {
            answer.classList.add('active');
            answer.style.maxHeight = answer.scrollHeight + 'px';
            question.classList.add('active');
        }
    });
});