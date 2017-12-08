<?php
session_start();

//include("header-content-page.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?PHP if($current_page!='movement.php'){echo 'ExecFile';}?> <?=$PageTitle;?></title>
<meta name="keywords" content="<?=$PageKeywords?>" />
<meta name="description" content="<?=$PageDescription?>" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link href="css/style.css" rel="stylesheet" type="text/css" />


<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/chosen.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/style-search-alert.css" type="text/css" media="all" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>

<script src="js/jquery.radios.checkboxes.js" type="text/javascript"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=DIR_JS?>validation.js" language="javascript"></script>


</head>
<body>

<div style="margin:0px auto;width:990px;">    
    <div style="padding-top:0px;">
        <div>
            <h1 style="padding-left:0px;"><a href="execf/public/index.php/homepage"><img width="257" height="24" src="css/images/new-logo.png"></a></h1>
        </div>
    </div>

    <div class="content_div" style="margin-top:20px;">

<?PHP

include("config.php");
include("functions.php");

   
com_db_connect() or die('Unable to connect to database server!');
?>	 
<div>
    <table style="border:none;"  width=\"90%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" align=\"center\">
    <tbody>
        <tr>
            <td style="border:none;" valign=\"top\" align=\"left\" class=\"terms-content-text\">
            <h2>Summary</h2>
            <p>The following is a summary of the key terms under which we offer and you agree to use the &quot;Execfile.com&rdquo; web site (the &quot;Site&quot;). However, both parties are obligated to adhere to the full agreement which is set forth below under Terms of Use (&quot;Terms&quot;). </p>
            <ul>
                <li>The Site contains proprietary notices and copyright information, the terms of which must be observed and followed.</li>
                <li>Information on the Site may be changed or updated without notice.</li>
                <li>Execfile.com may change, suspend or discontinue any aspect of the Site at any time, including the availability of any Site feature, database, or content.</li>
                <li>Execfile.com may impose limits on certain features and functionality or restrict your access to parts or all of the Site without notice or liability.</li>
                <li>You agree to comply with all federal and state laws in the use of any of the data obtained through the Site, specifically including, but not limited to, email addresses. </li>
            </ul>
            <p>The following Terms of Use and all applicable Plan Details form a legally binding contract between you (&lsquo;Subscriber&rsquo;) and Execfile.com&nbsp;(&lsquo;EXECFILE.COM&rsquo;). EXECFILE.COM is the owner and operator of the business contact database, including&nbsp;related services and systems (collectively the &lsquo;system&rsquo;). You desire to have authorized access to the system. EXECFILE.COM authorizes access to its system subject to the following terms and conditions of use (&lsquo;terms&rsquo;). Your access to or use of the system&nbsp;is subject to these terms and Execfile.com will not provide the Services except pursuant to these terms. This agreement is void where prohibited. In consideration for the mutual promises contained herein, you and EXECFILE.COM accept and agree to the following terms:</p>
            <h2>Terms of Use</h2>
            <p><strong>1)&nbsp;USE OF THE SITE</strong></p>
            <p><strong>1.1)&nbsp;</strong>The Site may be used only by you if you agree to be bound by these Terms, and you may not rent, lease, sublicense or transfer the Site or any data residing on it or any of your rights under this Agreement to anyone else. You may not develop or derive for commercial sale any data in any form whatsoever that incorporates or uses any part of the Site. Except with the prior written consent of Execfile.com, no data that resides in the Site may be transferred or made available by you to any person or entity.&nbsp;Violation of this limitation on use shall result in immediate termination of access to the Site and grounds for legal action against you. Use can be made for commercial purposes only after payment of Execfile.com's standard fees for one or more Execfile.com services. </p>
            <p><strong>1.2)</strong>&nbsp;Execfile.com may, in its sole discretion, terminate or suspend your access to all or part of the Site for any or no reason and with no prior notice to you.&nbsp;You may terminate this agreement at any time by discontinuing use of the Site. The provisions of Sections 4, 7, 8, 9 and 10 shall survive termination or expiration of this Agreement.</p>
            <p><strong>2)&nbsp;CONTENT </strong></p>
            <p><strong>2.1)</strong>&nbsp;All materials published on the Site including, but not limited to, news articles, photographs, company summaries, company descriptions, people summaries, contact information, and images (collectively known as the &quot;Content&quot;) are protected by copyright pursuant to U.S. and international copyright laws, and owned or controlled by Execfile.com or the party credited as the provider of the Content. You shall abide by all additional copyright notices, information, or restrictions contained in any Content accessed through the Site. Customer may not use the Execfile.com Services in a commercial service bureau environment including, but not limited to, any provision or export of data to third parties in any form whatsoever.</p>
            <p><strong>2.2)</strong>&nbsp;Execfile.com is the sole owner of the layout, functions, appearance, trademarks and other intellectual property comprising the Site. Additionally, Execfile.com is the sole owner of the compiled biographical and company data, but not the cached Web pages or material that have been copied from the cached pages which belong to their respective copyright owners.</p>
            <p><strong>2.3)</strong>&nbsp;Execfile.com is a search engine that extracts and summarizes information from the Web.&nbsp;This information may be inaccurate and we may make mistakes when extracting the information.&nbsp;Execfile.com assumes no responsibility regarding the accuracy of the information that is provided by Execfile.com and use of such information is your own risk. By furnishing information, Execfile.com does not grant any licenses to any copyrights, patents or any other intellectual property rights. </p>
            <p><strong>2.4)</strong>&nbsp;Information on the Site may be changed or updated without notice. Execfile.com may also make improvements and/or changes in the products and/or the programs available on the Site at any time without notice.</p>
            <p><strong>2.6)</strong>&nbsp;Execfile.com will utilize reasonable commercial efforts to protect the integrity of data collected by you and stored with the Site. However, Execfile.com shall not be liable for any loss or damage resulting from total or partial loss of your data or from any corruption of your data. Data can get lost or become corrupt as a result of a number of causes, including hardware failures, software failures or bugs, or communications failures. Execfile.com recommends that you periodically back up your information and Web Summaries onto media not associated with Execfile.com, including printing a hard copy of it.</p>
            <p><strong>2.7)&nbsp;</strong>Execfile.com may preserve and disclose content or user information (including queries made) if required to do so by law or in the good faith belief that doing so is necessary to: </p>
            <p><strong>(a)</strong> comply with legal process; </p>
            <p><strong>(b)</strong> enforce these Terms, </p>
            <p><strong>(c)</strong> respond to claims that any content violates the rights of third parties; </p>
            <p><strong>(d)</strong> protect the rights, property, or personal safety of Execfile.com, its users, or the public, </p>
            <p><strong>(e)</strong> administer the Site, or </p>
            <p><strong>(f)</strong> comply with the request of a user or a user\'s employer.</p>
            <p><strong>2.8)</strong>&nbsp;Execfile.com will utilize reasonable commercial efforts to provide the Site on a 24/7 basis but it shall not be responsible for any disruption, regardless of length.&nbsp;Furthermore, Execfile.com shall not be liable for losses or damages you may incur due to any errors or omissions in any Content or any inaccurate interpretations of data, or due to your inability to access data due to disruption of the Site.</p>
            <p><strong>3)&nbsp;USER RESPONSIBILITIES </strong></p>
            <p>In using the Site, you agree not to:</p>
            <p><strong>3.1)</strong>&nbsp;Knowingly transmit: </p>
            <p><strong>a)&nbsp;</strong>any information, data, images, or other materials (&quot;Material&quot;) that are unlawful, harmful, threatening, defamatory, vulgar, obscene, libelous or otherwise objectionable or that may invade another\'s right of privacy; or</p>
            <p><strong>b)</strong>&nbsp;any Material that infringes any intellectual property right, including but not limited to patent, trademark, service mark, trade secret, copyright or other proprietary rights of any third party. </p>
            <p><strong>3.2)</strong>&nbsp;Impersonate any person or entity or falsely state or otherwise misrepresent your affiliation with a person or entity; </p>
            <p><strong>3.3)</strong>&nbsp;Violate any law; </p>
            <p><strong>3.4)</strong>&nbsp;Violate or attempt to violate the security of the Site, including, without limitation:</p>
            <p><strong>a)&nbsp;</strong>log in to a server or account that you are not authorized to access; </p>
            <p><strong>b)</strong>&nbsp;attempt to test, scan, probe or hack the vulnerability of the Site or any network used by the Site or to breach security, encryption or other authentication measures; or</p>
            <p><strong>c)</strong>&nbsp;attempt to interfere with the Site by overloading, flooding, pinging, mail bombing or crashing it.</p>
            <p><strong>3.5)</strong>&nbsp;Reverse engineer, decompile or disassemble any portion of the Site. </p>
            <p><strong>3.6)</strong>&nbsp;Use or attempt to use any engine, software, tool, agent or other device or mechanism (including without limitation browsers, spiders, robots, avatars or intelligent agents) to navigate or search any portion of the Site, other than the search engine and search agents available from Execfile.com on the Site and generally available third party web browsers (e.g., Netscape Navigator and Microsoft Explorer).</p>
            <p><strong>3.7</strong>)&nbsp;Use the Site or any of the data obtained through the Site, specifically including but not limited to email addresses, to send email to any individual unless such email communication fully complies with all federal and state laws protecting said individual from unsolicited email.</p>
            <p><strong>6)&nbsp;FEES</strong></p>
            <p><strong>6.1) </strong>Execfile.com reserves the right at any time to charge fees for access to portions of the Site or the Site as a whole. However, in no event will you be charged for access to the Site unless we obtain your prior agreement to pay such charges.&nbsp;All fees paid to Execfile.com are non-refundable upon purchase, activation, or renewal.</p>
            <p><strong>7)&nbsp;REPRESENTATIONS AND WARRANTIES </strong></p>
            <p><strong>7.1)&nbsp;You represent,</strong> warrant and covenant (a) that no Materials of any kind submitted through your account will (i) violate, plagiarize, or infringe upon the rights of any third party, including copyright, trademark, privacy or other personal or proprietary rights; or (ii) contain libelous or otherwise unlawful material; and (b) that you are at least thirteen (13) years old. You hereby indemnify, defend and hold harmless Execfile.com, and all officers, directors, owners, agents, information providers, affiliates, licensors and licensees (collectively, the &quot;Indemnified Parties&quot; ) from and against any and all liability and costs, including, without limitation, reasonable attorneys\' fees, incurred by the Indemnified Parties in connection with any claim arising out of any breach by you or any user of your account of this Agreement or the foregoing representations, warranties and covenants. You shall cooperate as fully as reasonably required in the defense of any such claim. Execfile.com reserves the right, at its own expense, to assume the exclusive defense and control of any matter subject to indemnification by you.</p>
            <p><strong>8)&nbsp;DISCLAIMERS and LIMITATIONS. </strong></p>
            <p><strong>8.1)</strong>&nbsp;YOU ASSUME ALL RESPONSIBILITY AND RISK FOR YOUR USE OF THE SITE. THE SITE AND THE INFORMATION MADE AVAILABLE ON IT ARE PROVIDED &quot;AS IS&quot; WITHOUT WARRANTIES OF ANY KIND, EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO WARRANTIES OF TITLE, NONINFRINGEMENT, OR IMPLIED WARRANTIES OF MERCHANTABILITY OR FITNESS FOR A PARTICULAR PURPOSE. EXECFILE.COM EXPRESSLY DISCLAIMS ANY WARRANTY THAT THE INFORMATION ON THE SITE SHALL BE UNINTERRUPTED OR ERROR FREE. EXECFILE.COM DOES NOT ASSUME ANY LEGAL LIABILITY OR RESPONSIBILITY FOR THE ACCURACY, COMPLETENESS, OR USEFULNESS OF ANY INFORMATION USED OR DISCLOSED ON THE SITE.</p>
            <p><strong>8.2)</strong>&nbsp;IN NO EVENT SHALL EXECFILE.COM BE LIABLE FOR ANY INDIRECT, PUNITIVE, INCIDENTAL, SPECIAL OR CONSEQUENTIAL DAMAGES ARISING OUT OF OR IN ANY WAY CONNECTED WITH YOUR USE OF THE SITE OR WITH THE DELAY OR INABILITY TO USE IT. EXECFILE.COM'S LIABILITY FOR ANY DIRECT DAMAGES SHALL BE LIMITED TO THE AMOUNT OF FEES YOU HAVE PAID FOR THE SITE FOR THE THEN-CURRENT PERIOD.&nbsp;SOME STATES OR JURISDICTIONS DO NOT ALLOW THE EXCLUSION OR LIMITATION OF LIABILITY FOR CONSEQUENTIAL OR INCIDENTAL DAMAGES AND THUS THE ABOVE LIMITATION MAY NOT APPLY TO YOU. IF THIS LIMITATION OF LIABILITY OR THE EXCLUSION OF WARRANTY SET FORTH ABOVE IS HELD INAPPLICABLE OR UNENFORCEABLE FOR ANY REASON, EXECFILE.COM'S MAXIMUM LIABILITY FOR ANY TYPE OF DAMAGES SHALL BE LIMITED TO $100. </p>
            <p><strong>9)&nbsp;MUTUAL INDEMNIFICATION.</strong></p>
            <p><strong>9.1)</strong>&nbsp;Each party agrees to indemnify and hold harmless the other party from and against any cost, loss or expense (including attorney\'s fees) resulting from any claims by third parties for loss, damage or injury allegedly caused by the actions, omissions or misrepresentations of the other party, its agents or employees provided that the indemnified party provides the indemnifying party with (a) prompt written notice of such claim or action, (b) sole control and authority over the defense or settlement of such claim or action and (c) proper and full information and reasonable assistance to defend and/or settle any such claim or action.</p>
            <p><strong>10)&nbsp;MISCELLANEOUS </strong></p>
            <p><strong>10.1) Relationship.</strong>&nbsp;You agree that no joint venture, partnership, employment or agency relationship exists between you and Execfile.com as a result of this Agreement and/or your use of the Site. </p>
            <p><strong>10.2) Entire Agreement.</strong>&nbsp;These Terms represent the entire binding agreement between you and Execfile.com, and each party\'s respective successors and assigns, and supersede any and all prior understandings, statements or representations, whether electronic, oral or written, regarding the Site or the information therein.&nbsp;A printed version of this Agreement and of any notice given shall be admissible in judicial or administrative proceedings based upon or relating to these Terms to the same extent and subject to the same conditions as other business documents and records originally generated and maintained in printed form.</p>
            <p><strong>10.3) Modifications,</strong> Assignment and Waiver. Execfile.com shall have the right to modify these Terms at any time by posting them on the Site and providing notice on the Site that they have been changed.&nbsp;Changes will be binding on you on the date they are posted on the Site (or as otherwise stated in any notice to you of such changes). A link will be provided to the current Terms, and Execfile.com recommends that you review the details of any such changes as they are binding on you regarding future use of the Site.&nbsp;Any use of the Site will be considered acceptance by you of the then-current Terms.&nbsp;If at any time you find the Terms unacceptable and do not agree to such Terms, you must terminate use of the Site.&nbsp;Any new or different terms supplied by you are specifically rejected by Execfile.com.&nbsp;Execfile.com may assign this Agreement at its discretion. You may not assign any part of this Agreement without Execfile.com\'s prior written consent. No waiver of any obligation or right of either party shall be effective unless in writing, executed by the party against whom it is being enforced. </p>
            <p><strong>10.4) Jurisdiction</strong>.&nbsp;This Agreement shall be governed by the applicable New York state and federal laws, without regard to its conflict of laws rules, and you hereby give your consent to have any action or dispute between yourself and Execfile.com resolved exclusively within the jurisdiction of the state and federal courts located in New York State. Use of the Site is unauthorized in any jurisdiction that does not give effect to all provisions of these terms and conditions, including without limitation this paragraph. </p>
            <p><strong>10.5) Equitable Relief.</strong>&nbsp;You understand and agree that, in addition to money damages, Execfile.com shall be entitled to equitable relief where appropriate upon your breach of any portion of this Agreement.</p>
            <p><strong>10.6) Severability.</strong>&nbsp;The Terms are severable and may be construed to the extent of their enforceability in light of the parties\' mutual intent. </p>
            <p><strong>10.7) Force Majeure.</strong> If the performance of this Agreement or any obligations hereunder is prevented or interfered with by reason of fire or other casualty or accident, strikes or labor disputes, war or other violence, any law, proclamation, regulation, or requirement of any government agency, or any other act or condition beyond the reasonable control of a party hereto, that party upon giving prompt notice to the other party shall be excused from such performance during such occurrence.</p>
            <p><strong>10.8) Legal Expenses.</strong> The prevailing party in any legal action brought by one party against the other that arises out of this Agreement shall be entitled, in addition to any other rights and remedies it may have, to reimbursement for its legal expenses, including court costs and reasonable attorneys\' fees.</p>
            <p><strong>10.10)&nbsp;Notices and Other Communications.</strong>&nbsp;Notices required or permitted hereunder that are intended for you personally and not all users of the Site shall be made to you at the most recent email address on file with Execfile.com and shall be made to Execfile.com by email to &quot;<a href=\"mailto:info@Execfile.com\">info@Execfile.com</a>&quot; </p>
            </td>
        </tr>
    </tbody>
</table>

 </div><!-- /.email-alert -->
 
     </div>
</div>
<?php      
//include("static_footer.php");
//include(DIR_INCLUDES."footer-content-page.php");
?>