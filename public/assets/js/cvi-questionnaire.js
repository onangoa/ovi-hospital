/**
 * Child Vitality Index Questionnaire JavaScript
 * Handles form interactions, validation, and user experience enhancements
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize form functionality
    initializeFormValidation();
    initializeProgressTracking();
    initializeFormInteractions();
    initializeScorePreview();
    
    /**
     * Initialize form validation
     */
    function initializeFormValidation() {
        const form = document.querySelector('form');
        const submitBtn = document.querySelector('.cvi-submit-btn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    showValidationErrors();
                }
            });
        }
    }
    
    /**
     * Validate the entire form
     */
    function validateForm() {
        const patientSelect = document.getElementById('user_id');
        let isValid = true;
        let errors = [];
        
        // Check if patient is selected
        if (!patientSelect.value) {
            errors.push('Please select a patient');
            isValid = false;
        }
        
        // Check if all questions are answered
        for (let i = 1; i <= 20; i++) {
            const questionInputs = document.querySelectorAll(`input[name="question${i}"]`);
            const isAnswered = Array.from(questionInputs).some(input => input.checked);
            
            if (!isAnswered) {
                errors.push(`Please answer question ${i}`);
                isValid = false;
            }
        }
        
        if (!isValid) {
            console.log('Validation errors:', errors);
        }
        
        return isValid;
    }
    
    /**
     * Show validation errors to user
     */
    function showValidationErrors() {
        // Remove existing error messages
        const existingErrors = document.querySelectorAll('.validation-error');
        existingErrors.forEach(error => error.remove());
        
        // Check patient selection
        const patientSelect = document.getElementById('user_id');
        if (!patientSelect.value) {
            showFieldError(patientSelect, 'Please select a patient');
        }
        
        // Check unanswered questions
        for (let i = 1; i <= 20; i++) {
            const questionInputs = document.querySelectorAll(`input[name="question${i}"]`);
            const isAnswered = Array.from(questionInputs).some(input => input.checked);
            
            if (!isAnswered) {
                const questionItem = questionInputs[0].closest('.cvi-question-item');
                showFieldError(questionItem, `Please answer this question`);
            }
        }
        
        // Scroll to first error
        const firstError = document.querySelector('.validation-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
    
    /**
     * Show error message for a specific field
     */
    function showFieldError(element, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'validation-error';
        errorDiv.style.cssText = `
            color: #dc3545;
            font-size: 0.9rem;
            margin-top: 5px;
            padding: 8px 12px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            animation: shake 0.5s ease-in-out;
        `;
        errorDiv.textContent = message;
        
        if (element.tagName === 'SELECT') {
            element.parentNode.appendChild(errorDiv);
        } else {
            element.appendChild(errorDiv);
        }
        
        // Add shake animation
        element.style.animation = 'shake 0.5s ease-in-out';
        setTimeout(() => {
            element.style.animation = '';
        }, 500);
    }
    
    /**
     * Initialize progress tracking
     */
    function initializeProgressTracking() {
        createProgressBar();
        updateProgress();
        
        // Update progress when questions are answered
        const radioInputs = document.querySelectorAll('input[type="radio"]');
        radioInputs.forEach(input => {
            input.addEventListener('change', updateProgress);
        });
    }
    
    /**
     * Create progress bar
     */
    function createProgressBar() {
        const header = document.querySelector('.cvi-questionnaire-header');
        if (header) {
            const progressContainer = document.createElement('div');
            progressContainer.className = 'progress-container';
            progressContainer.style.cssText = `
                margin-top: 20px;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 10px;
                padding: 3px;
            `;
            
            const progressBar = document.createElement('div');
            progressBar.id = 'progress-bar';
            progressBar.style.cssText = `
                height: 8px;
                background: linear-gradient(90deg, #28a745, #20c997);
                border-radius: 8px;
                width: 0%;
                transition: width 0.3s ease;
            `;
            
            const progressText = document.createElement('div');
            progressText.id = 'progress-text';
            progressText.style.cssText = `
                text-align: center;
                margin-top: 10px;
                font-size: 0.9rem;
                opacity: 0.9;
            `;
            
            progressContainer.appendChild(progressBar);
            header.appendChild(progressContainer);
            header.appendChild(progressText);
        }
    }
    
    /**
     * Update progress bar
     */
    function updateProgress() {
        let answeredQuestions = 0;
        const totalQuestions = 20;
        
        for (let i = 1; i <= totalQuestions; i++) {
            const questionInputs = document.querySelectorAll(`input[name="question${i}"]`);
            const isAnswered = Array.from(questionInputs).some(input => input.checked);
            if (isAnswered) answeredQuestions++;
        }
        
        const progressPercentage = (answeredQuestions / totalQuestions) * 100;
        
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        
        if (progressBar) {
            progressBar.style.width = progressPercentage + '%';
        }
        
        if (progressText) {
            progressText.textContent = `Progress: ${answeredQuestions}/${totalQuestions} questions answered (${Math.round(progressPercentage)}%)`;
        }
        
        // Update submit button state
        const submitBtn = document.querySelector('.cvi-submit-btn');
        if (submitBtn) {
            if (progressPercentage === 100) {
                submitBtn.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
                submitBtn.textContent = 'Submit Questionnaire';
            } else {
                submitBtn.style.background = 'linear-gradient(135deg, #6c757d, #5a6268)';
                submitBtn.textContent = `Complete All Questions (${answeredQuestions}/${totalQuestions})`;
            }
        }
    }
    
    /**
     * Initialize form interactions
     */
    function initializeFormInteractions() {
        // Add smooth scrolling for question groups
        const questionGroups = document.querySelectorAll('.cvi-question-group');
        questionGroups.forEach((group, index) => {
            group.style.animationDelay = (index * 0.1) + 's';
        });
        
        // Add click sound effect (optional)
        const radioInputs = document.querySelectorAll('input[type="radio"]');
        radioInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Remove validation error if exists
                const errorMsg = this.closest('.cvi-question-item').querySelector('.validation-error');
                if (errorMsg) {
                    errorMsg.remove();
                }
                
                // Add visual feedback
                const questionItem = this.closest('.cvi-question-item');
                questionItem.style.borderLeftColor = '#28a745';
                questionItem.style.background = '#f8fff9';
                
                setTimeout(() => {
                    questionItem.style.borderLeftColor = '#007bff';
                    questionItem.style.background = '#f8f9fa';
                }, 1000);
            });
        });
        
        // Auto-save functionality (optional)
        initializeAutoSave();
    }
    
    /**
     * Initialize auto-save functionality
     */
    function initializeAutoSave() {
        const form = document.querySelector('form');
        if (!form) return;
        
        // Load saved data
        loadSavedData();
        
        // Save data on change
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', saveFormData);
        });
    }
    
    /**
     * Save form data to localStorage
     */
    function saveFormData() {
        const formData = {};
        const form = document.querySelector('form');
        
        // Save patient selection
        const patientSelect = document.getElementById('user_id');
        if (patientSelect.value) {
            formData.user_id = patientSelect.value;
        }
        
        // Save question answers
        for (let i = 1; i <= 20; i++) {
            const questionInputs = document.querySelectorAll(`input[name="question${i}"]`);
            const checkedInput = Array.from(questionInputs).find(input => input.checked);
            if (checkedInput) {
                formData[`question${i}`] = checkedInput.value;
            }
        }
        
        // Save notes
        const notesTextarea = document.getElementById('notes');
        if (notesTextarea.value) {
            formData.notes = notesTextarea.value;
        }
        
        localStorage.setItem('cvi_questionnaire_data', JSON.stringify(formData));
    }
    
    /**
     * Load saved form data from localStorage
     */
    function loadSavedData() {
        const savedData = localStorage.getItem('cvi_questionnaire_data');
        if (!savedData) return;
        
        try {
            const formData = JSON.parse(savedData);
            
            // Load patient selection
            if (formData.user_id) {
                const patientSelect = document.getElementById('user_id');
                if (patientSelect) {
                    patientSelect.value = formData.user_id;
                }
            }
            
            // Load question answers
            for (let i = 1; i <= 20; i++) {
                if (formData[`question${i}`]) {
                    const input = document.querySelector(`input[name="question${i}"][value="${formData[`question${i}`]}"]`);
                    if (input) {
                        input.checked = true;
                    }
                }
            }
            
            // Load notes
            if (formData.notes) {
                const notesTextarea = document.getElementById('notes');
                if (notesTextarea) {
                    notesTextarea.value = formData.notes;
                }
            }
            
            // Update progress after loading
            updateProgress();
            
        } catch (error) {
            console.error('Error loading saved data:', error);
        }
    }
    
    /**
     * Initialize score preview
     */
    function initializeScorePreview() {
        createScorePreview();
        
        const radioInputs = document.querySelectorAll('input[type="radio"]');
        radioInputs.forEach(input => {
            input.addEventListener('change', updateScorePreview);
        });
    }
    
    /**
     * Create score preview section
     */
    function createScorePreview() {
        const submitSection = document.querySelector('.cvi-submit-section');
        if (submitSection) {
            const previewDiv = document.createElement('div');
            previewDiv.id = 'score-preview';
            previewDiv.style.cssText = `
                margin-bottom: 20px;
                padding: 20px;
                background: #e3f2fd;
                border-radius: 8px;
                border-left: 4px solid #2196f3;
                display: none;
            `;
            
            submitSection.insertBefore(previewDiv, submitSection.firstChild);
        }
    }
    
    /**
     * Update score preview
     */
    function updateScorePreview() {
        let score = 0;
        let answeredQuestions = 0;
        
        for (let i = 1; i <= 20; i++) {
            const questionInputs = document.querySelectorAll(`input[name="question${i}"]`);
            const checkedInput = Array.from(questionInputs).find(input => input.checked);
            
            if (checkedInput) {
                answeredQuestions++;
                if (checkedInput.value === 'yes') {
                    score += 5;
                }
            }
        }
        
        const previewDiv = document.getElementById('score-preview');
        if (previewDiv && answeredQuestions > 0) {
            let interpretation = '';
            if (score >= 0 && score <= 59) {
                interpretation = 'High Vitality Score';
            } else if (score >= 60 && score <= 79) {
                interpretation = 'Moderate Vitality Score';
            } else if (score >= 80 && score <= 89) {
                interpretation = 'Low Vitality Score';
            } else if (score >= 90 && score <= 100) {
                interpretation = 'Critical Vitality Score';
            }
            
            previewDiv.innerHTML = `
                <h4 style="margin: 0 0 10px 0; color: #1976d2;">Current Score Preview</h4>
                <p style="margin: 0; font-size: 1.1rem;">
                    <strong>Score:</strong> ${score}/100 | 
                    <strong>Questions Answered:</strong> ${answeredQuestions}/20 | 
                    <strong>Interpretation:</strong> ${interpretation}
                </p>
            `;
            previewDiv.style.display = 'block';
        }
    }
    
    /**
     * Clear saved data when form is submitted successfully
     */
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function() {
            if (validateForm()) {
                localStorage.removeItem('cvi_questionnaire_data');
            }
        });
    }
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);
