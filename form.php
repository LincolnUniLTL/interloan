<html><head><title>Interloan form</title></head>
<body><?php
  $to_email = "";    //email you want forms to go to
  $from_email = "";  //email you want students to receive their copy of the form from / reply-to
  $form_url = "";    //url of this php page itself
  $error_url = "";   //url of a page where you can send them if something goes wrong

 /* Requester Information */
  $Name = isset($_POST['Name']) ? urldecode($_POST['Name']) : '';
  $Email = isset($_POST['Email']) ? urldecode($_POST['Email']) : '';
  $Department = isset($_POST['Department']) ? urldecode($_POST['Department']) : '';
  $Phone = isset($_POST['Ext']) ? urldecode($_POST['Ext']) : '';
  $Status = isset($_POST['Status']) ? urldecode($_POST['Status']) : '';

/* Charge Information */
  $Urgent = isset($_POST['Urgent']) ? urldecode($_POST['Urgent']) : 'No';
  $Overseas = isset($_POST['Overseas']) ? urldecode($_POST['Overseas']) : 'No';
  $Charge = isset($_POST['Charge']) ? urldecode($_POST['Charge']) : '';
  $Acc = isset($_POST['Acc']) ? urldecode($_POST['Acc']) : '';
  $Dept = isset($_POST['Dept']) ? urldecode($_POST['Dept']) : '';
  $Activity = isset($_POST['Activity']) ? urldecode($_POST['Activity']) : '';
  $Funder = isset($_POST['Funder']) ? urldecode($_POST['Funder']) : '';
  $Person = isset($_POST['Person']) ? urldecode($_POST['Person']) : '';

/* Item Information */
  $rft_btitle = isset($_POST['rft_btitle']) ? urldecode($_POST['rft_btitle']) : (isset($_GET['rft_btitle']) ? urldecode($_GET['rft_btitle']) : (isset($_GET['rft_title']) ? urldecode($_GET['rft_title']) : ''));
  $rft_jtitle = isset($_POST['rft_jtitle']) ? urldecode($_POST['rft_jtitle']) : (isset($_GET['rft_jtitle']) ? urldecode($_GET['rft_jtitle']) : (isset($_GET['rft_title']) ? urldecode($_GET['rft_title']) : ''));
  $rft_isbn = isset($_POST['rft_isbn']) ? urldecode($_POST['rft_isbn']) : (isset($_GET['rft_isbn']) ? urldecode($_GET['rft_isbn']) : '');
  $rft_issn = isset($_POST['rft_issn']) ? urldecode($_POST['rft_issn']) : (isset($_GET['rft_issn']) ? urldecode($_GET['rft_issn']) : '');
  
  $ItemInfo = isset($_POST['ItemInfo']) ? urldecode($_POST['ItemInfo']) : (($rft_btitle != '' || $rft_isbn != '') ? 'radio4' : '');
  if ($ItemInfo==='' && ($rft_jtitle != '' || $rft_issn !='')) { $ItemInfo = 'radio5';}

  $rft_atitle = (isset($_POST['rft_atitle_m']) && $ItemInfo=='radio4') ? urldecode($_POST['rft_atitle_m']) : (isset($_POST['rft_atitle_s']) ? urldecode($_POST['rft_atitle_s']) : (isset($_GET['rft_atitle']) ? urldecode($_GET['rft_atitle']) : ''));
  $rft_au = (isset($_POST['rft_au_m']) && $ItemInfo=='radio4') ? urldecode($_POST['rft_au_m']) : (isset($_POST['rft_au_s']) ? urldecode($_POST['rft_au_s']) : (isset($_GET['rft_au']) ? urldecode($_GET['rft_au']) : ''));
  $rft_year = (isset($_POST['rft_year_m']) && $ItemInfo=='radio4') ? urldecode($_POST['rft_year_m']) : (isset($_POST['rft_year_s']) ? urldecode($_POST['rft_year_s']) : (isset($_GET['rft_year']) ? urldecode($_GET['rft_year']) : (isset($_GET['rft_date']) ? urldecode($_GET['rft_date']) : (isset($_GET['rft_pubdate']) ? urldecode($_GET['rft_pubdate']) : ''))));

  $rft_volume = isset($_POST['rft_volume']) ? urldecode($_POST['rft_volume']) : (isset($_GET['rft_volume']) ? urldecode($_GET['rft_volume']) : '');
  $rft_issue = isset($_POST['rft_issue']) ? urldecode($_POST['rft_issue']) : (isset($_GET['rft_issue']) ? urldecode($_GET['rft_issue']) : '');
  $rft_spage = isset($_POST['rft_spage']) ? urldecode($_POST['rft_spage']) : (isset($_GET['rft_spage']) ? urldecode($_GET['rft_spage']) : '');
  $rft_epage = isset($_POST['rft_epage']) ? urldecode($_POST['rft_epage']) : (isset($_GET['rft_epage']) ? urldecode($_GET['rft_epage']) : '');

  $Publisher = isset($_POST['Publisher']) ? urldecode($_POST['Publisher']) : (isset($_GET['publisher']) ? urldecode($_GET['publisher']) : '');
  $City = isset($_POST['pub_place']) ? urldecode($_POST['pub_place']) : (isset($_GET['place']) ? urldecode($_GET['place']) : '');
  $DOI = isset($_POST['DOI']) ? urldecode($_POST['DOI']) : (isset($_GET['doi']) ? urldecode($_GET['doi']) : '');
  $Edition = isset($_POST['Edition']) ? urldecode($_POST['Edition']) : (isset($_GET['edition']) ? urldecode($_GET['edition']) : '');

  $BibPaste = isset($_POST['BibPaste']) ? urldecode($_POST['BibPaste']) : '';
  $Source = isset($_POST['source']) ? urldecode($_POST['source']) : (isset($_GET['source']) ? urldecode($_GET['source']) : '');

/* Email information */
  $Formname = isset($_POST['Formname']) ? urldecode($_POST['Formname']) : '';
  $Copy = isset($_POST['Copy']) ? urldecode($_POST['Copy']) : '';
  $Submit = isset($_POST['Submit']) ? urldecode($_POST['Submit']) : '';

/* Deal with form submission */
  if ($Formname!='' && $Submit === 'Submit') {
	if ($Name==''||$Email==''||$Department==''||$Status=='') {
		echo "<p class='asterisk'>Please fill out all required fields.</p>";
	} else {
/* Email it */
	  $request = "";
	  if ($Urgent=="Yes") $request .= "Required urgently: Yes\r\n";
	  if ($Overseas=="Yes") $request .= "Try overseas if not in NZ: Yes\r\n";
	  if (($Urgent=="Yes"||$Overseas=="Yes")&&$Charge=="Debit") {
		$request .= "Debit Charge Code: " . $Acc . "-" . $Dept . "-" . $Activity . "-" . $Funder . "-" . $Person . "\r\n";
	  }
	  if (($Urgent=="Yes"||$Overseas=="Yes")&&$Charge=="EFTPOS") {
		$request .= "Pay by EFTPOS\r\n" ;
	  }

	  $request .= "\r\n==Item Information==\r\n";
	  if ($ItemInfo == "radio4") {
		$request .= "Author: " . $rft_au . "\r\n";
		$request .= "Title: " . $rft_btitle . "\r\n";
		$request .= "Chapter: " . $rft_atitle . "\r\n";
		$request .= "Edition: " . $Edition . "\r\n";
		$request .= "Year: " . $rft_year . "\r\n";
		$request .= "ISBN: " . $rft_isbn . "\r\n";
		$request .= "Publisher: " . $Publisher . "\r\n";
		$request .= "Place of publication: " . $City . "\r\n";
	  } elseif ($ItemInfo == "radio5") {
		  $request .= "Serial Title: " . $rft_jtitle . "\r\n";
		  $request .= "ISSN: " . $rft_issn . "\r\n";
		  $request .= "DOI: " . $DOI . "\r\n";
		  $request .= "Year: " . $rft_year . "\r\n";
		  $request .= "Volume: " . $rft_volume . "\r\n";
		  $request .= "Issue: " . $rft_issue . "\r\n";
		  $request .= "Start page: " . $rft_spage . "\r\n";
		  $request .= "End page: " . $rft_epage . "\r\n";
		  $request .= "Author(s): " . $rft_au . "\r\n";
		  $request .= "Title of paper: " . $rft_atitle . "\r\n";
	  } elseif ($ItemInfo == "radio6") {
		  $request .= $BibPaste . "\r\n";
	  }
	  if ($Source == "" || $Source == "/") {
		  $request .= "==Filled out manually by the user==\r\n";
	  } else {
		  $request .= "==Filled out automatically from " . $Source . " ==\r\n";
	  }
	  
	  $request .= "\r\n==Requester Information==\r\n";
	  $request .= "Name: " . $Name . "\r\n";
	  $request .= "Email: " . $Email . "\r\n";
	  $request .= "Phone: " . $Phone . "\r\n";
	  $request .= "Status: " . $Status . "\r\n";
	  $request .= "Department: " . $Department . "\r\n";
	  
	  $headers = 'From: ' . $from_email . "\r\n";
	  if ($Copy != '') {
		  $headers .= 'CC: ' . $Email . "\r\n";
	  } else {
		  $headers .= 'Reply-To: ' . $Email . "\r\n";
	  }
	  $headers .= 'X-Mailer: PHP/' . phpversion();
	  
	  $subject = $Formname;
	  if ($rft_atitle != '') {
		$subject .= ": " . $rft_atitle;
	  } elseif ($rft_btitle != '') {
		$subject .= ": " . $rft_btitle;
	  }
	 
	  if (mail($to_email, $subject, $request, $headers)) {
		echo "<p class='asterisk'>Your request has been sent with the details below.</p>";
	  } else {
		echo "<p class='asterisk'>There was a problem sending your request. Please try again or contact us through <a href='".$error_url."'>another method</a>.</p>";
	  }
	}
  }
/* Emailing ends */
  if ($Source!='Primo') {
?>
<p>Have you checked Primo to make sure that the library doesn't already have what you need?</p>
<?php
  }
?>
<!-- Form Starts -->
<!-- Form Fields Starts -->
<form id="form-main" action="<?php echo $form_url; ?>" method="post">
<h4>Requester Information</h4>
<p class="description">Interloans are normally available to <strong>staff and postgraduate students only</strong>.</p>
<p>
	<label for="Name" class="lft"><span class="asterisk">*</span>Full name</label>
	<input name="Name" id="Name" type="text"  value="<?php echo $Name; ?>" style="width:31.4em;" required="required">
</p>
<p>
	<label for="Email" class="lft"><span class="asterisk">*</span>Email</label>
	<input name="Email" id="Email" type="text"  value="<?php echo $Email; ?>" style="width:31.4em;" required="required">
</p>
<p>
	<label for="Department" class="lft"><span class="asterisk">*</span>Department</label>
	<input name="Department" id="Department" type="text"  value="<?php echo $Department; ?>" style="width:12em;" required="required" />

	<label for="Ext" class="right">Phone</label>
	<input name="Ext" id="Ext" type="text" value="<?php echo $Phone; ?>"  style="width:9em;" />
</p>
<p>
	<label for="Status" class="lft"><span class="asterisk">*</span>Status</label>
	<input name="Status" id="Staff" type="radio" value="Staff" class="checkbox" <?php if ($Status === 'Staff') echo 'checked="checked"'; ?> >
	<label for="Staff" class="horiz">Staff</label>
	<input name="Status" id="Postgraduate" type="radio" value="Postgrad" class="checkbox"  <?php if ($Status === 'Postgrad') echo 'checked="checked"'; ?> >
	<label for="Postgraduate" class="horiz">Postgrad</label>
</p>

<hr/>

<!-- Form Field Charge -->
<h4>Charge information</h4>
<p class="description">There is no charge for non-urgent items from New Zealand and Australia.</p>

<!-- Form Field Urgent -->
<p id="test1">This item is:<br/>
	<span class="oneChoice">
		<input name="Urgent" id="urgentY" type="radio" value="Yes" class="radio-button"  <?php if ($Urgent === 'Yes') echo 'checked="checked"'; ?> onclick='javascript:displayPay();' />
		<label for="urgentY" class="horiz">Urgent: I will pay $20</label>
	</span>
	<span class="oneChoice" style="position:absolute; left:30rem;">
		<input name="Urgent" id="urgentN" type="radio" value="No" class="radio-button"  <?php if ($Urgent === 'No') echo 'checked="checked"'; ?> onclick='javascript:displayPay();' />
		<label for="urgentN" class="horiz">Not urgent</label>
	</span>
</p>

<!-- Form Field Overseas -->
<p id="test2">If item is not available in New Zealand:<br/>
	<span class="oneChoice">
		<input type="radio" id="overseasY" name="Overseas" value="Yes" class="radio-button" <?php if ($Overseas === 'Yes') echo 'checked="checked"'; ?> onclick='javascript:displayPay();' />
		<label for="overseasY" class="horiz">Get it from overseas: I will pay $20</label>
	</span>
	<span class="oneChoice" style="position:absolute; left:30rem;">
		<input type="radio" id="overseasN" name="Overseas" value="No" class="radio-button"  <?php if ($Overseas === 'No') echo 'checked="checked"'; ?> onclick='javascript:displayPay();'  />
		<label for="overseasN" class="horiz">Don't get it from overseas</label>
	</span>
</p>

<!-- If paying -->
<div id="notpaying"></div>
<div id="paying">
<p>I will pay by:<br/>
    <span class="oneChoice">  
      <input type="radio" id="radio1" name="Charge" value="Debit" style="border:none;" <?php if ($Charge != 'EFTPOS') echo 'checked="checked"'; ?> onclick='javascript:displayMethod();' />
      <label for="radio1" class="postField">Debit charge code</label>
    </span>

     <span class="oneChoice">
      <input type="radio" id="radio3" name="Charge" value="EFTPOS" style="border:none;" <?php if ($Charge === 'EFTPOS') echo 'checked="checked"'; ?> onclick='javascript:displayMethod();' />
      <label for="radio3" class="postField">EFTPOS</label>
    </span>
</p>
<p>		
  <span id="fieldset1">
    <label for="Acc">&nbsp;&nbsp;&nbsp;Acc&nbsp;&nbsp;&nbsp;-<br />
    <input id="Acc" type="text" maxlength="4" style="width:3.5em"  value="<?php echo $Acc; ?>" name="Acc">-</label>
    <label for="Dept">Dept(T1) -<br />
    <input id="Dept" type="text" maxlength="4" style="width:3.5em" value="<?php echo $Dept; ?>" name="Dept">&nbsp;&nbsp;&nbsp;-</label>
    <label for="Activity">Activity(T2) -<br />
    <input id="Activity" type="text" maxlength="7" style="width:5.5em" value="<?php echo $Activity; ?>" name="Activity">&nbsp;-</label>
    <label for="Funder">Funder(T3) -<br />
    <input id="Funder" type="text" maxlength="4" style="width:3.5em" value="<?php echo $Funder; ?>" name="Funder">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-</label>
    <label for="Person">Person(T4)<br />
    <input id="Person" type="text" maxlength="7" style="width:5.5em" value="<?php echo $Person; ?>" name="Person"></label>
  </span>
</p>
<p>
  <span id="fieldset3">
    You can pay using an EFTPOS card at the Service Point when you collect the item.
  </span>
</p>
</div>

<hr/>

<h4>Item Information</h4>
<p class="description">Select one of the first two options to fill in individual fields, or the third option to paste in a full citation.</p>

<p>
    <span class="oneChoice">
      <input type="radio" id="radio4" name="ItemInfo" value="radio4" style="border:none;" <?php if ($ItemInfo === 'radio4') echo 'checked="checked"'; ?> onclick='javascript:displayType();' />
      <label for="radio4" class="postField">Book, Thesis, etc.</label>
    </span>
    <span class="oneChoice">
      <input type="radio" id="radio5" name="ItemInfo" value="radio5" style="border:none;" <?php if ($ItemInfo === 'radio5') echo 'checked="checked"'; ?> onclick='javascript:displayType();' />
      <label for="radio5" class="postField">Serial or conference paper</label>
    </span>
     <span class="oneChoice">
      <input type="radio" id="radio6" name="ItemInfo" value="radio6" style="border:none;" <?php if ($ItemInfo === 'radio6') echo 'checked="checked"'; ?> onclick='javascript:displayType();' />
      <label for="radio6" class="postField">Paste information</label>
    </span>
</p> 
		
<div id="Span1">
<h4>Book, Thesis, etc.</h4>	
<p>
	<label for="rft_au_m" class="lft">Author(s)</label>
	<input name="rft_au_m" id="rft_au_m" type="text" style="width:31.4em"  value="<?php echo $rft_au; ?>">
</p>		
<p>
	<label for="rft_year_m" class="lft">Year</label>
	<input name="rft_year_m" id="rft_year_m" type="text" maxlength="4" style="width:9em;" value="<?php echo $rft_year; ?>">
	<label for="Edition" class="right">Edition </label>
	<input name="Edition" id="Edition" type="text" style="width:9em;" placeholder="(if known)" value="<?php echo $Edition; ?>">
</p>
<p>
	<label for="rft_btitle" class="lft">Title</label>
	<input name="rft_btitle" id="rft_btitle" type="text" style="width:31.4em" value="<?php echo $rft_btitle; ?>">		
</p>
<p>
	<label for="rft_atitle_m" class="lft">Chapter</label>
	<input name="rft_atitle_m" id="rft_atitle_m" type="text" style="width:31.4em" placeholder="(if known)" value="<?php echo $rft_atitle; ?>">		
</p>
<p>
	<label for="rft_isbn" class="lft">ISBN</label>
	<input name="rft_isbn" id="rft_isbn" type="text" placeholder="(if known)" value="<?php echo $rft_isbn; ?>">
</p>
<p>
	<label for="Publisher" class="lft">Publisher</label>
    <input name="Publisher" id="Publisher" type="text" style="width:31.4em" value="<?php echo $Publisher; ?>">
</p>
<p>
	<label for="pub_place" class="lft">Place of publication</label>
    <input name="pub_place" id="pub_place" type="text" style="width:31.4em" value="<?php echo $City; ?>">
</p>
</div>

<div id="Span2">
<h4>Serials</h4>
<p class="description">e.g. Journals, Conference Proceedings, etc.</p>
<p>
	<label for="rft_au_s" class="lft">Author(s)</label>
	<input name="rft_au_s" id="rft_au_s" type="text" style="width:31.4em" value="<?php echo $rft_au; ?>">
</p>
<p>
	<label for="rft_year_s" class="lft">Year</label>
	<input name="rft_year_s" id="rft_year_s" type="text" maxlength="4" value="<?php echo $rft_year; ?>" >
</p>
<p>
	<label for="rft_atitle_s" class="lft">Title of Paper</label>
	<input name="rft_atitle_s" id="rft_atitle_s" type="text" style="width:31.4em" value="<?php echo $rft_atitle; ?>">
</p>
<p>
	<label for="rft_jtitle" class="lft">Serial Title</label>
	<input name="rft_jtitle" id="rft_jtitle" type="text" style="width:31.4em" value="<?php echo $rft_jtitle; ?>">
</p>		
<p>
	<label for="rft_volume" class="lft">Volume</label>
	<input name="rft_volume" id="rft_volume" type="text" style="width:9em;" value="<?php echo $rft_volume; ?>" />
	<label for="rft_issue" class="right">Issue</label>
	<input name="rft_issue" id="rft_issue" type="text" style="width:9em;" value="<?php echo $rft_issue; ?>" />	
</p>
<p>
	<label for="rft_spage" class="lft">Start Page</label>
	<input name="rft_spage" id="rft_spage" type="text" style="width:9em;" value="<?php echo $rft_spage; ?>" />
	<label for="rft_epage" class="right">End Page</label>
	<input name="rft_epage" id="rft_epage" type="text" style="width:9em;" value="<?php echo $rft_epage; ?>" />
</p>
<p>
	<label for="rft_issn" class="lft">ISSN</label>
	<input name="rft_issn" id="rft_issn" type="text" placeholder="(if known)" value="<?php echo $rft_issn; ?>">
</p>
<p>
	<label for="DOI" class="lft">DOI</label>
	<input name="DOI" id="DOI" type="text" placeholder="(if known)" style="width:31.4em" value="<?php echo $DOI; ?>">
</p>
</div>

<div id="Span3">
<h4>Paste into this box</h4>
<p>Bibliographic information copied from another source (only 1 item per form please):</p>
<p><textarea name="BibPaste" id="BibPaste" rows="4" cols="40"  ><?php echo $BibPaste; ?></textarea></p>
</div>
		
<hr/>

<!-- Form Fields Ends -->
<!-- Email a Copy & Submit Starts -->
	<div class="submit">
		<p><strong>Copyright:</strong> Copies supplied through the Library Interloan Service are for your private study or research, or must comply with s54 or s55 of the Copyright Act 1994.</p>	
		<input name="Copy" id="Copy" type="checkbox" value="Copy" />
		<label for="Copy">Email me a copy of this form</label>
		<input type="hidden" name="Formname" value="Interloan request" />
		<input type="hidden" name="source" value="<?php echo $Source; ?>" />
		<input class="form-button" name="Submit" id="Submit" type="submit" value="Submit" />					
	</div>
<!-- Email a Copy & Submit Ends -->
</form>
<br style="clear:both;" />
<br style="clear:both;" />
<!-- Form Ends -->
<script type="text/javascript">
function displayPay() {
if(document.getElementById('urgentN').checked==true && document.getElementById('overseasN').checked==true ) {
document.getElementById('paying').style='display:none;';
} else {
document.getElementById('paying').style='display:block;';
}
}

function displayMethod() {
if (document.getElementById('radio1').checked==true) {
document.getElementById('fieldset1').style='display:block;';
document.getElementById('fieldset3').style='display:none;';
} else if (document.getElementById('radio3').checked==true) {
document.getElementById('fieldset1').style='display:none;';
document.getElementById('fieldset3').style='display:block;';
}
}

function displayType() {
if (document.getElementById('radio4').checked==true) {
document.getElementById('Span1').style='display:block;';
document.getElementById('Span2').style='display:none;';
document.getElementById('Span3').style='display:none;';
} else if (document.getElementById('radio5').checked==true) {
document.getElementById('Span1').style='display:none;';
document.getElementById('Span2').style='display:block;';
document.getElementById('Span3').style='display:none;';
} else if (document.getElementById('radio6').checked==true) {
document.getElementById('Span1').style='display:none;';
document.getElementById('Span2').style='display:none;';
document.getElementById('Span3').style='display:block;';
} else {
document.getElementById('Span1').style='display:none;';
document.getElementById('Span2').style='display:none;';
document.getElementById('Span3').style='display:none;';
}
}

displayPay();
displayMethod();
displayType();
</script></body></html>