let myForm = document.getElementById('form');
let error = document.getElementById('error');

let form = function(event) {
        event.preventDefault()
        let httpRequest;
        //relance le function ajax
        makeRequest()

        function makeRequest() {
            httpRequest = new XMLHttpRequest();
            if (!httpRequest) {
                alert('Abandon :( Impossible de créer une instance de XMLHTTP');
                return false;
            }
        }

        function alertContents() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                if (httpRequest.status === 200) {
                    //recived data from php 
                    let result = JSON.parse(httpRequest.responseText);
                    if (result.success == "false") {
                        error.innerHTML = result.message;
                    } else {
                        window.location = "home";
                    }
                } else {
                    alert('You have problem in connection please try again later');
                }
            }
        }
        //sending data to php 
        httpRequest.onreadystatechange = alertContents;
        httpRequest.open('POST', 'connect');
        formData = new FormData(myForm);
        httpRequest.send(formData);
    }
    //function excuted when code is uploaded
document.addEventListener("DOMContentLoaded", () => {
    myForm.addEventListener("submit", form)
})