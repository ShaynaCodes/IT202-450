function validate(form){
    //https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty
    //Technically this check isn't necessary since we're not using it across different forms, but
    //it's to show an example of how you can check for a property so you can reuse a validate function for similar
    //forms.
    errors = [];
    if(form.hasOwnProperty("question")){
        if (form.question.value == null ||
            form.question.value == undefined ||
            form.question.value.length == 0) {
            errors.push("Question must not be empty");
        }
    }
    if(errors.length > 0){
        alert(errors);
        return false;//prevent form submission
    }
    return  true;//allow form submission
}
