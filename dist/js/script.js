var pageYCord = 10;
function generatePDF() {
  var doc = new jsPDF();
  doc.setFont('times');
  doc.setFontSize(9); //will depend on citation style

  for(var key in localStorage) {
    doc.text(localStorage[key], 10, pageYCord);
    pageYCord+=10;
  }
  doc.save('myCitations.pdf');
}

function generateBetterPDF() {
  var docDefinition = {
     content: [
       { text: 'This paragraph will have a bigger font', fontSize: 12, margin: [ 1, 1, 1, 1 ] },
     ]
    };

  pdfMake.createPdf(docDefinition).download('optionalName.pdf');
}

var output = ''; 
localStorage.setItem(document.getElementById('finalCitationBox').innerHTML, document.getElementById('finalCitationBox').innerHTML);


for (var i in localStorage) {
  //if(localStorage[i] != document.getElementById('finalCitationBox').innerHTML) {
    console.log(localStorage[i]); //for debugging
  //}
}

var j = 0;
for (var i in localStorage) { //don't add newly created citation to "older citations"
  if(localStorage[i] != document.getElementById('finalCitationBox').innerHTML) {
    output+= '<p onclick="removeFromlocalStorage(this.id);hideCitation(this.id)" id="'+j+'">' + (localStorage[i])+'</p>';
    j++;
  }
}

$('#DivToPrintOut').html(output);

function clearS() {
  console.log("localStorage cleared");
  localStorage.clear();
}
  
function removeFromlocalStorage(citation) {
  for (var i in localStorage) {
    if(localStorage[i] === document.getElementById(citation).innerHTML) {
      console.log("removing " + localStorage[i]);
      localStorage.removeItem(document.getElementById(citation).innerHTML);
    }
  }
}

function hideCitation(citation) {
  $( "#" + citation ).remove();
}