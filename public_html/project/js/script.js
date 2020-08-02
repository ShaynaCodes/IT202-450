function validate(form){
    //https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty
    //Technically this check isn't necessary since we're not using it across different forms, but
    //it's to show an example of how you can check for a property so you can reuse a validate function for similar
    //forms.
    errors = [];
    if(form.hasOwnProperty("email") && form.hasOwnProperty("password")){
        if (form.email.value == null ||
            form.email.value == undefined ||
            form.email.value.length == 0) {
            errors.push("email must not be empty");
        }
        if (form.password.value == null ||
            form.password.value == undefined ||
            form.password.value.length == 0 || form.password.value < 0) {
            errors.push("Password must not be empty ");
        }
    }
    if(errors.length > 0){
        alert(errors);
        return false;//prevent form submission
    }
    return  true;//allow form submission
}
