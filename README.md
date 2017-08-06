# CiteIt
Web app that allows for easy creation of citations using popular citation styles including MLA, APA, and Chicago. This is accomplished by scraping meta tags of provided URLs using [PHP Simple HTML DOM Parser](http://simplehtmldom.sourceforge.net/).

### TODO:
* Use pdfmake instead of jsPDF
* Add ability to cite multiple authors
* Fix citations for authors whose names don't follow 'First Last' style
* Redesign UI
* Add "undo" when removing old citations
* Order old citaitons by time instead of lexicographically
* Switch date and month for accessed date for Chicago and APA
* Allow old citations to be edited
* Implent karma/jasmine and write unit tests
* Only display #squareTwo if there is a citation
