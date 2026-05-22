document.addEventListener('DOMContentLoaded', ()=> {
    const addNewSurveyButton = document.getElementById('add-new-survey-button');

    addNewSurveyButton.addEventListener('click', ()=> {
        window.location.href = 'resources/views/private/form';
    })
})