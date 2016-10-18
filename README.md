Prepopulated interlibrary loan form
===================================

This solution may be suitable for you if you:
* Want to give users a direct link from a Primo result to a prepopulated ILL form
* Use Alma but *don't* use its internal ILL functionality
* Can run PHP on your own server
* Want ILL requests to be emailed to your ILL team

You can see a working implementation from: http://primo-direct-apac.hosted.exlibrisgroup.com/LIN:All_resources:TN_informit814504053758056


On your server
--------------
Save form.php file to your server. Edit the variables at the top – the email you want forms to go to, the email you want students to receive their copy at, the url of this page itself, and the url of a page where you can send them if something goes wrong.
	
Next there’s a whole set of GET and POST variables. GET brings in the variables from Primo via OpenURL, POST is to deal with when they actually submit the form. You’ll only need to edit these if you add OpenUrl attributes.

Next comes code for when the form is actually submitted and if there are missing required fields; followed by how the email to interloans (Cced to submitters) should be formatted.

Next is the form itself, and the variables are just echoed into the value for each input field. You’re very likely to want to edit the html here as it’s set up for our own payment system etc. :-)

The complicating factor is having the code identify if they’re going to pay money then display the questions about how they’ll pay, and if it’s a book display those questions but if it’s an article display those, etc. This is where all the ifs and onclick values in the form, and the javascript at the bottom of the page, come in.


On the Alma side
--------------
You need to add a general electronic service - see Alma documentation: https://knowledge.exlibrisgroup.com/Alma/Product_Documentation/Alma_Online_Help_(English)/Alma-Primo_Integration/060Configuring_Alma’s_Delivery_System/120Adding_a_General_Electronic_Service

You’ll want the url to be something like the following – you may want to add more OpenUrl attributes but the example code currently uses only the following:
`http://your.domain.edu/path/to/form.php?&rft_au={rft.au}&rft_pubdate={rft.pub}&rft_title={rft.title}&rft_btitle={rft.btitle}&rft_isbn={rft.isbn}&rft_jtitle={rft.jtitle}&rft_atitle={rft.atitle}&rft_volume={rft.volume}&rft_issue={rft.issue}&rft_spage={rft.spage}&rft_epage={rft.epage}&rft_year={rft.year}&rft_date={rft.date}&rft_issn={rft.issn}&source=Primo`

