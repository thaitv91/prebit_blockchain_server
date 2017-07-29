<?php
namespace common\extensions;


class MailTemplate
{
   public function loadMailtemplate($username, $content)
   {
   	$template = '<style type="text/css">
            /* Some resets and issue fixes */
            body{font-family:Roboto,"Helvetica Neue",Helvetica,Arial,sans-serif; width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0; }
            .ReadMsgBody { width: 100%; }
            .ExternalClass {width:100%;}
            .backgroundTable {margin:0 auto; padding:0; width:100%!important;}
            .ExternalClass * {line-height: 115%;}
            /* End reset */
            span.preheader{
              display: none;
              font-size: 1px;
              visibility: hidden;
              opacity: 0;
              color: transparent;
              height: 0;
              width: 0;
            }
            a {
                text-decoration: none;
                color: inherit;
            }
            table, td {
                border-collapse: collapse;
            }
            /* These are our tablet/medium screen media queries */
            @media screen and (max-width: 795px) {
              /* Display block allows us to stack elements */
              *[class="mobile-column"], .mobile-column {display: block;}
              /* Some more stacking elements */
              *[class="mob-column"], .mob-column {float: none !important;width: 100% !important;}
              /* Hide stuff */
              *[class="hide"], .hide {display:none !important;}
              /* For the 2x2 stack */
              *[class="condensed"], .condensed {padding-bottom:40px !important; display: block;}
              /* Centers content on mobile */
              *[class="center"], .center {text-align:center !important; width:100% !important; height:auto !important;}
              /* 100percent width section with 20px padding */
              *[class="100pad"] {width:100% !important; padding:20px;}
              /* 100percent width section with 20px padding left & right */
              *[class="100padleftright"] {width:100% !important; padding:0 20px 0 20px;}
              /* 100percent width section with 20px padding top & bottom */
              *[class="100padtopbottom"] {width:100% !important; padding:20px 0 20px 0;}
              /* 100percent width section with 20px padding top & bottom */
              *[class="hr"], .hr {width:100% !important;}
              /* This sets elements to 100% width and fixes the height issues too, a god send */
              *[class="p10"], .p10   {width:10% !important; height:auto !important;}
              *[class="p20"], .p20   {width:20% !important; height:auto !important;}
              *[class="p30"], .p30   {width:30% !important; height:auto !important;}
              *[class="p40"], .p40   {width:40% !important; height:auto !important;}
              *[class="p50"], .p50   {width:50% !important; height:auto !important;}
              *[class="p60"], .p60   {width:60% !important; height:auto !important;}
              *[class="p70"], .p70   {width:70% !important; height:auto !important;}
              *[class="p80"], .p80   {width:80% !important; height:auto !important;}
              *[class="p90"], .p90   {width:90% !important; height:auto !important;}
              *[class="p100"], .p100 {width:100% !important; height:auto !important;}
              *[class="p15"], .p15   {width:15% !important; height:auto !important;}
              *[class="p25"], .p25   {width:25% !important; height:auto !important;}
              *[class="p33"], .p33   {width:33% !important; height:auto !important;}
              *[class="p35"], .p35   {width:35% !important; height:auto !important;}
              *[class="p45"], .p45   {width:45% !important; height:auto !important;}
              *[class="p55"], .p55   {width:55% !important; height:auto !important;}
              *[class="p65"], .p65   {width:65% !important; height:auto !important;}
              *[class="p75"], .p75   {width:75% !important; height:auto !important;}
              *[class="p85"], .p85   {width:85% !important; height:auto !important;}
              *[class="p95"], .p95   {width:95% !important; height:auto !important;}
              *[class="alignleft"] {text-align: left !important;}
              *[class="100button"] {width:100% !important;}
            }
            /* These are our smartphone/small screen media queries */
            @media screen and (max-width: 450px) {
                *[class="xs-no-pad"], .xs-no-pad {padding: 0 !important;}
                /* Width on small screen devices */
                *[class="xs-p25"], .xs-p25 {width:25% !important; height:auto !important;}
                *[class="xs-p50"], .xs-p50 {width:50% !important; height:auto !important;}
                *[class="xs-p75"], .xs-p75 {width:75% !important; height:auto !important;}
                *[class="xs-p100"], .xs-p100 {width:100% !important; height:auto !important;}
                /* Hide stuff */
                *[class="xs-hide"], .xs-hide {display:none !important;}
            }
          </style>
        <body style="-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; background-color: #d8d8d8; margin: 0; padding: 0; width: 100%;">
          <table class="p100" style="background-color: #D8D8D8; margin: 0 auto; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="867">
            <tr>
              <td align="center" valign="top">
                <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 617px;" width="800" cellspacing="0" cellpadding="0" border="0" align="center">
                  <tr>
                    <td style="background-position: center center; background-size: cover;" align="center" valign="top">
                      <table class="p90" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                        <tr>
                          <td align="center" valign="top">
                            <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0" align="center">
                              <tr>
                                <td valign="top" align="left">
                                  <!--[if gte mso 9]>
                                       <table align="left" border="0" cellpadding="0" cellspacing="0" width="600">
                                       <tr>
                                       <td align="left" valign="top" width="130">
                                      <![endif]-->
                                  <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                    <tr>
                                      <td style="height: 25px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">
                                        <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;" cellspacing="0" cellpadding="0" border="0" align="center">
                                        
                                          <tr>
                                            <td align="center" valign="top">
                                              <a href="#" style="border: none; display: block; outline: none; text-decoration: none;">
                                                <img src="https://system.pre-bit.org/images/logo.png" alt="logo" style="-ms-interpolation-mode: bicubic; border: 0; display: block; outline: 0; text-decoration: none; width: 223px;" width="223" border="0">
                                              </a>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td class="hide" style="height: 25px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                                        </tr>
                                        </table>
                                      </td>
                                    </tr>
                                  </table>  
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          <table style="background-color: #d8d8d8; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" bgcolor="#D8D8D8" width="100%">
            <tr>
              <td align="center" valign="top">
                <table class="p100" style="background: #fff; margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 80%;" width="800" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                    <td class="hide" style="height: 50px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                  </tr>
                  <tr>
                     <td style="width: 30px;" width="30" valign="top" align="left">&nbsp;</td>
                     <td align="left" valign="top">
                        <font face="Arial, sans-serif">
                           <span style="color:#3494aa; font-weight:bold">Dear '.$username.',</span>
                           <br>
                           <br>
                           '.$content.'
                           
                           <p style="margin-bottom:0">Have a great day,</p>
                           <p style="margin-top:0">The PreBit Team</p>
                        </font>
                     </td>
                     
                  </tr>
                  <tr>
                    <td class="hide" style="height: 50px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

          <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 100%;" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
              <td align="center" valign="top">
                <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 800px;" width="800" cellspacing="0" cellpadding="0" border="0">
                  <tr>
                    <td align="center" valign="top">
                      <table class="p100" style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                          <td style="width: 30px;" width="30" valign="top" align="left">&nbsp;</td>
                          <td align="center" valign="top">
                            <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;" cellspacing="0" cellpadding="0" border="0" align="center">
                              <tr>
                                <td style="height: 20px; line-height: 20px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="center" valign="top">
                                  <table style="margin: 0; mso-table-lspace: 0; mso-table-rspace: 0; padding: 0;" cellspacing="0" cellpadding="0" border="0" align="center">
                                    <tr>
                                      <td style="width: 40px;" width="40" align="left" valign="top">
                                        <a href="#" style="border: none; display: block; height: 35px; line-height: 35px; outline: none; text-decoration: none; width: 35px;">
                                          <img src="http://bitway.giaonhanviec.com/email/icon-facebook.png" alt="Facebook" style="-ms-interpolation-mode: bicubic; border: 0; display: block; height: 35px; line-height: 35px; outline: 0; text-decoration: none; width: 35px;" width="35" border="0">
                                        </a>
                                      </td>
                                      <td style="width: 40px;" width="40" align="left" valign="top">
                                        <a href="#" style="border: none; display: block; height: 35px; line-height: 35px; outline: none; text-decoration: none; width: 35px;">
                                          <img src="http://bitway.giaonhanviec.com/email/icon-youtube.png" alt="Youtube" style="-ms-interpolation-mode: bicubic; border: 0; display: block; height: 35px; line-height: 35px; outline: 0; text-decoration: none; width: 35px;" width="35" border="0">
                                        </a>
                                      </td>
                                      <td style="width: 40px;" width="40" align="left" valign="top">
                                        <a href="#" style="border: none; display: block; height: 35px; line-height: 35px; outline: none; text-decoration: none; width: 35px;">
                                          <img src="http://bitway.giaonhanviec.com/email/icon-flickr.png" alt="Flick" style="-ms-interpolation-mode: bicubic; border: 0; display: block; height: 35px; line-height: 35px; outline: 0; text-decoration: none; width: 35px;" width="35" border="0">
                                        </a>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                              <tr>
                                <td style="height: 30px; line-height: 30px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                              </tr>
                              <tr>
                              <td style="color: #626262;font-size: 13px; font-weight: normal; letter-spacing: 0.02em; line-height: 23px; text-align: center; mso-line-height-rule: exactly;" valign="top" align="left">
                                <a href="#" class="text3" style="text-decoration:none; border-right: 1px solid #626262; margin-right: 10px; padding-right:10px; color: #626262; display: inline-block;  font-size: 12px; font-weight: normal; letter-spacing: 0.02em; line-height: 12px; outline: none; text-align: center;"><font face="Arial, sans-serif">Unsubscribe here</font>
                                </a>
                                <a href="#" class="text3" style="text-decoration:none; border-right: 1px solid #626262; margin-right: 10px;padding-right: 10px; color: #626262; display: inline-block;  font-size: 12px; font-weight: normal; letter-spacing: 0.02em; line-height: 12px; outline: none; text-align: center; "><font face="Arial, sans-serif">Privacy Policy</font>
                                </a>
                                <a href="#" class="text3" style="text-decoration:none; border: none; color: #626262; display: inline-block;font-size: 12px; font-weight: normal; letter-spacing: 0.02em; line-height: 12px; outline: none; text-align: center;"><font face="Arial, sans-serif">Contact Support</font>
                                </a>
                              </td>
                            </tr>
      
                              <tr>
                                <td style="color: #626262; font-size: 12px; line-height: 25px; font-weight: normal; letter-spacing: 0.02em; text-align: center;" valign="top" align="left">
                                </td>
                              </tr>
                              <tr>
                                <td class="hide" style="height: 15px; line-height: 25px; mso-line-height-rule: exactly;" valign="top" align="left">&nbsp;</td>
                            </tr>                     
                            </table>
                          </td>
                          <td style="width: 15px;" width="30" valign="top" align="left">&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </body>';
   	
      return $template;
   }
}
