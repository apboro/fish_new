const renderResponse = (res) => {
  // handles if res is falsey
  if(!res){
    console.log(res.status)
  }
  // in case res comes back as a blank array
  if(!res.length){
    responseField.innerHTML = "<p>Try again!</p><p>There were no suggestions found!</p>"
    return
  }

  // creating an array to contain the HTML strings
  let wordList = []
  // looping through the response and maxxing out at 10
  for(let i = 0; i < Math.min(res.length, 10); i++){
    // creating a list of words
    wordList.push(`<li>${res[i].word}</li>`)
  }
  // joins the array of HTML strings into one string
  wordList = wordList.join("")

  // manipulates responseField to render the modified response
  responseField.innerHTML = `<p>You might be interested in:</p><ol>${wordList}</ol>`
  return
}

const url = "https://api.datamuse.com/words?";
const queryParams="rel_rhy="; 
// Selecting page elements

const inputField = document.querySelector('#input');
const submit = document.querySelector('#submit');
const responseField = document.querySelector('#responseField');

// AJAX function
const getSuggestions = () => {
const wordQuery = inputField.value;
  const endpoint=url+queryParams+wordQuery;
  const xhr = new XMLHttpRequest();
  xhr.responseType='json';
  xhr.onreadystatechange =() =>{
    if (xhr.readyState === XMLHttpRequest.DONE) {
  renderResponse(xhr.response)
}
  }
xhr.open("GET", endpoint);  
xhr.send();    
}
// Clear previous results and display results to webpage
const displaySuggestions = (event) => {
  event.preventDefault();
  while(responseField.firstChild){
    responseField.removeChild(responseField.firstChild);
  };
  getSuggestions();
}
submit.addEventListener('click', displaySuggestions);