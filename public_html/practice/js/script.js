function validate(form){
    //https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty
    //Technically this check isn't necessary since we're not using it across different forms, but
    //it's to show an example of how you can check for a property so you can reuse a validate function for similar
    //forms.
    errors = [];
    if(form.hasOwnProperty("title") && form.hasOwnProperty("visibility")){
        if (form.title.value == null ||
            form.title.value == undefined ||
            form.title.value.length == 0) {
            errors.push("title must not be empty");
        }
		if (form.visibility.value == null ||
            form.visibility.value == undefined ||
            form.visibility.value.length == 0 || form.visibility.value < 0) {
            errors.push("visibility must not be empty and a positive number");
        }
    }
	
    if(errors.length > 0){
        alert(errors);
        return false;//prevent form submission
    }
    return  true;//allow form submission
}
