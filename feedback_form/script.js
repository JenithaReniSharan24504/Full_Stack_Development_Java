// Get elements
let nameInput = document.getElementById("name");
let emailInput = document.getElementById("email");
let feedbackInput = document.getElementById("feedback");
let submitBtn = document.getElementById("submitBtn");

let nameError = document.getElementById("nameError");
let emailError = document.getElementById("emailError");
let feedbackError = document.getElementById("feedbackError");
let message = document.getElementById("message");


// ✅ Function to validate Name
function validateName() {
    let name = nameInput.value;

    if (name.length < 3) {
        nameError.innerText = "Name must be at least 3 characters";
        return false;
    } else {
        nameError.innerText = "";
        return true;
    }
}


// ✅ Function to validate Email
function validateEmail() {
    let email = emailInput.value;

    if (!email.includes("@") || !email.includes(".")) {
        emailError.innerText = "Enter a valid email";
        return false;
    } else {
        emailError.innerText = "";
        return true;
    }
}


// ✅ Function to validate Feedback
function validateFeedback() {
    let feedback = feedbackInput.value;

    if (feedback.length < 5) {
        feedbackError.innerText = "Feedback must be at least 5 characters";
        return false;
    } else {
        feedbackError.innerText = "";
        return true;
    }
}


// ✅ Highlight fields on hover (mouse events)
function addHoverEffect(inputField) {
    inputField.addEventListener("mouseover", function () {
        inputField.style.border = "2px solid blue";
    });

    inputField.addEventListener("mouseout", function () {
        inputField.style.border = "2px solid #ccc";
    });
}

addHoverEffect(nameInput);
addHoverEffect(emailInput);
addHoverEffect(feedbackInput);


// ✅ Validate on keypress (keyup event)
nameInput.addEventListener("keyup", validateName);
emailInput.addEventListener("keyup", validateEmail);
feedbackInput.addEventListener("keyup", validateFeedback);


// ✅ Double click submit button
submitBtn.addEventListener("dblclick", function () {

    let validName = validateName();
    let validEmail = validateEmail();
    let validFeedback = validateFeedback();

    if (validName && validEmail && validFeedback) {
        message.innerText = "✅ Feedback Submitted Successfully!";
        message.style.color = "green";
    } else {
        message.innerText = "❌ Please fix errors before submitting!";
        message.style.color = "red";
    }
});