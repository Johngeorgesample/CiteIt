  // var output = ''; 
  // localStorage.setItem(Math.random(), document.getElementById('finalCitationBox').innerHTML);

  // for (var key in localStorage) {
  //   if(localStorage[key] != document.getElementById('finalCitationBox').innerHTML) {
  //     console.log(key + ':' + localStorage[key]); //for debugging
  //   }
  // }

  // for (var key in localStorage) {
  // 	if(localStorage[key] != document.getElementById('finalCitationBox').innerHTML) {
  //     output = output+(localStorage[key])+'<br><br>';
  //   }
  // }

  // $('#DivToPrintOut').html(output);

  // function clearS() {
  // 	localStorage.clear();
  // }
  
  var pageYCord = 20;
  function generatePDF() {
    var doc = new jsPDF();
    doc.setFontSize(9); //will depend on citation style

    for(var key in localStorage) {
      doc.text(localStorage[key], 10, pageYCord);
      pageYCord+=10;
    }
    doc.save('myCitations.pdf');
  }