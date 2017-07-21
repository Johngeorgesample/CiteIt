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