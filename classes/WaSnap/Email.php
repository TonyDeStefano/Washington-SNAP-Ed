<?php

namespace WaSnap;

class Email {

    /**
     * @param string $html
     *
     * @return string
     */
    public static function buildEmail( $html )
    {
        return self::getHeader() . $html . self::getFooter();
    }

    /**
     * @param string|array $to
     * @param string $subject
     * @param string $html
     * @param bool $build
     *
     * @return bool
     */
    public static function sendEmail( $to, $subject, $html, $build = FALSE )
    {
        if ( $build )
        {
            $html = self::buildEmail( $html );
        }

        $headers = array( 'Content-Type: text/html; charset=UTF-8' );

        return wp_mail( $to, $subject, $html, $headers );
    }

    public static function getHeader()
    {
        $today = date( 'F j, Y' );

        return <<<EOT
<style type="text/css">
body {
	margin: 0;
}
body, table, td, p, a, li, blockquote {
	-webkit-text-size-adjust: none!important;
	font-family: Merienda, 'Times New Roman', serif;
	font-style: normal;
	font-weight: 400;
}
button{
	width:90%;
}
@media screen and (max-width:600px) {
/*styling for objects with screen size less than 600px; */
body, table, td, p, a, li, blockquote {
	-webkit-text-size-adjust: none!important;
	font-family: Merienda, 'Times New Roman', serif;
}
table {
	/* All tables are 100% width */
	width: 100%;
}
.footer {
	/* Footer has 2 columns each of 48% width */
	height: auto !important;
	max-width: 48% !important;
	width: 48% !important;
}
table.responsiveImage {
	/* Container for images in catalog */
	height: auto !important;
	max-width: 30% !important;
	width: 30% !important;
}
table.responsiveContent {
	/* Content that accompanies the content in the catalog */
	height: auto !important;
	max-width: 66% !important;
	width: 66% !important;
}
.top {
	/* Each Columnar table in the header */
	height: auto !important;
	max-width: 48% !important;
	width: 48% !important;
}
.catalog {
	margin-left: 0%!important;
}

}
@media screen and (max-width:480px) {
/*styling for objects with screen size less than 480px; */
body, table, td, p, a, li, blockquote {
	-webkit-text-size-adjust: none!important;
	font-family: Merienda, 'Times New Roman', serif;
}
table {
	/* All tables are 100% width */
	width: 100% !important;
	border-style: none !important;
}
.footer {
	/* Each footer column in this case should occupy 96% width  and 4% is allowed for email client padding*/
	height: auto !important;
	max-width: 96% !important;
	width: 96% !important;
}
.table.responsiveImage {
	/* Container for each image now specifying full width */
	height: auto !important;
	max-width: 96% !important;
	width: 96% !important;
}
.table.responsiveContent {
	/* Content in catalog  occupying full width of cell */
	height: auto !important;
	max-width: 96% !important;
	width: 96% !important;
}
.top {
	/* Header columns occupying full width */
	height: auto !important;
	max-width: 100% !important;
	width: 100% !important;
}
.catalog {
	margin-left: 0%!important;
}
button{
	width:90%!important;
}
}
</style>
</head>
<body yahoo="yahoo">

<table bgcolor="#ffffff" class="top" width="600"  align="center" cellpadding="0" cellspacing="0" style="padding:10px 10px 10px 10px; font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; font-size: 10px; text-align: center; color: #666666; text-decoration: none;">

<table width="100%"  cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td><table width="600"  align="center" cellpadding="0" cellspacing="0">
          <!-- Main Wrapper Table with initial width set to 60opx -->
          <tbody>
            <tr style="background-color:#7baf0a;">
              <td><table bgcolor="#7baf0a" class="top" width="40%"  align="left" cellpadding="0" cellspacing="0" style="padding:10px 10px 10px 10px; border-bottom-right-radius: 15px;">
                  <!-- First header column with Logo -->
                  <tbody>
                    <tr>
                      <td style="bgcolor:#7baf0a; text-align:center; font-family: Merienda, 'Times New Roman', serif, sans-serif;"><img src="https://wasnap-ed.org/wp-content/uploads/2017/11/Final_logo_big.png" width="200" height="60" alt="SNAP-Education Logo"/></td>
                    </tr>
                  </tbody>
                </table>
                <table bgcolor="#7baf0a" class="top" width="50%"  align="right" cellpadding="0" cellspacing="0" style="padding:0px 10px 20px 10px; text-align:right; float: right;">
                  <!-- Second header column with ISSUE|DATE -->
                  <tbody>
                    <tr>
                      <td height="38" style="font-size: 16px; color:#ffffff; text-align:left; font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serifsans-serif; padding-left: 10px; float: right; text-align: right;">Curriculum & Communications Initiative</td></br></br>
                      
                      
                      
                      
                      
                      
                      
                    </tr>
                  </tbody>
                </table></td>
            </tr>
            <tr> 
              <!-- HTML Spacer row -->
              <td style="font-size: 0; line-height: 0;" height="20"><table width="96%" align="center"  cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="font-size: 11px; line-height: 0; text-align: right; color: #7baf0a;" height="10"><em>{$today}</em></td>
                  </tr>
                </table></td>
            </tr>
            <tr> 
              <!-- HTML IMAGE SPACER -->
              <td style="font-size: 0; line-height: 0;" height="20"></tr>
       
            <tr> 
              <!-- Introduction area -->
              <td><table width="96%"  align="center" cellpadding="0" cellspacing="0">
                  <tr> 
                    <!-- row container for TITLE/EMAIL THEME -->
                    <td style="font-size: 16px; line-height: 2.5em; color: #929292; font-family: Merienda, 'Times New Roman', serif, sans-serif;">
EOT;

    }

    public static function getFooter()
    {
        return <<<EOT
</td>
                  </tr>
                  <tr>
                    <td style="font-size: 0; line-height: 0;" height="20"><table width="96%" align="center"  cellpadding="0" cellspacing="0">
                        <tr> 
                          <!-- HTML Spacer row -->
                          <td style="font-size: 0; line-height: 0;" height="20">&nbsp;</td>
                        </tr>
                      </table></td>
                  </tr>
                </table></td>
            </tr>
            <tr> 
              <!-- HTML Spacer row -->
              <td style="font-size: 0; line-height: 0;" height="10">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <!-- HTML spacer row -->
              <td style="font-size: 0; line-height: 0;" height="20"><table width="96%" align="center"  cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="font-size: 0; line-height: 0;" height="20">&nbsp;</td>
                  </tr>
                </table></td>
            </tr>
            <tr bgcolor="#7baf0a">
              <td><table class="footer" width="42%"  align="left" cellpadding="0" cellspacing="0" height="200" style=" margin:20px;">
                  <!-- First column of footer content -->
                  <tr>
                    <td align="center" valign="top" style="padding-top: 20px;"><p style="font-size: 12px; font-weight:200; line-height: 1.5em; color: #fff; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; ">Washington State SNAP-Ed Communications <br>
                      WSU Extension, Puyallup WA<br>
                      <br>
                    2606 Pioneer Ave.<br>
                    Puyallup, WA 98137<br>
                    <br>
                    (253) 445-4598
                    </p></td>
                  </tr>
                </table>
                <table class="footer" width="42%"  align="left" cellpadding="0" cellspacing="0" height="200" style=" margin:20px;">
                  <!-- Second column of footer content -->
                  <tr>
                    <td align="center" valign="top"><p style="font-size: 12px; font-style: normal; font-weight:normal; color: #fff; line-height: 1.3; text-align:center;  padding-top: 20px;margin-right:20px; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; ">This message is from the WSU Curriculum & Communciation team regarding the Washington State SNAP-Ed website (wasnap-ed.org). Registration is intended for WA State SNAP-Ed Providers including administrators, contractors and staff. This will allow registrants to access the internal website, or commHUB, for program management resources and communication exchange.</p>
                      <p><a style="font-size: 14px; font-style: normal; font-weight:normal; color: #ffffff; line-height: 1.3; text-align:justify;  padding-top: 20px;margin-right:20px; font-family: Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; text-decoration: none;" href="mailto:szinn@wsu.edu" >Contact Us</a></p>
                      
                      <p align="right" >&nbsp;</p></td>
                  </tr>
                </table></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
  </tbody>
</table>
</body>
</html>
EOT;

    }

}