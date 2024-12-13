<?php

namespace App\Http\Traits;

trait EmailTrait
{
    public function templateforemail($mBody, $templatename)
    {

        $this->message = "<table width='100%' align='center' border='0' cellpadding='0' cellspacing='0' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; width: 100%;' class='background'>
            <tbody>
                <tr>
                    <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0;' bgcolor='#F0F0F0'>
                        <!-- WRAPPER -->
                        <!-- Set wrapper width (twice) -->
                        <table border='0' cellpadding='0' cellspacing='0' align='center' width='560' style='border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit; max-width: 560px;' class='wrapper'>
                            <tbody>
                                <tr>
                                    <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; padding-top: 20px; padding-bottom: 20px;'>
                                        <!-- PREHEADER -->
                                        <!-- Set text color to background color -->
                                        <div style='display: none; visibility: hidden; overflow: hidden; opacity: 0; font-size: 1px; line-height: 1px; height: 0; max-height: 0; max-width: 0; color: #f0f0f0;' class='preheader'></div>

                                        <!-- LOGO -->

                                        <a target='_blank' style='text-decoration: none;' href='https://npav.net/'>
                                            <img
                                                border='0'
                                                vspace='0'
                                                hspace='0'
                                                src='https://www.adminconsole.net/AdminConsole/assets/images/logo.png'
                                                width='100'
                                                height='auto'
                                                alt='Logo'
                                                title='Logo'
                                                style='color: #000000; font-size: 10px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;'
                                            />
                                        </a>
                                    </td>
                                </tr>

                                <!-- End of WRAPPER -->
                            </tbody>
                        </table>

                        <!-- WRAPPER / CONTEINER -->
                        <!-- Set conteiner background color -->
                        <table border='0' cellpadding='0' cellspacing='0' align='center' bgcolor='#FFFFFF' width='560' style='border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit; max-width: 560px;' class='container'>
                            <!-- HEADER -->
                            <!-- Set text color and font family ('sans-serif' or 'Georgia, serif') -->
                            <tbody>
                                <tr>
                                    <td
                                        align='center'
                                        valign='top'
                                        style='
                                            border-collapse: collapse;
                                            border-spacing: 0;
                                            margin: 0;
                                            padding: 0;
                                            padding-left: 6.25%;
                                            padding-right: 6.25%;
                                            width: 87.5%;
                                            font-size: 24px;
                                            font-weight: bold;
                                            line-height: 130%;
                                            padding-top: 25px;
                                            color: #000000;
                                            font-family: sans-serif;
                                        '
                                        class='header'
                                    >" . $templatename . "

                                    </td>
                                </tr>

                                <!-- SUBHEADER -->
                                <!-- Set text color and font family ('sans-serif' or 'Georgia, serif') -->
                                <tr>
                                    <td
                                        align='center'
                                        valign='top'
                                        style='
                                            border-collapse: collapse;
                                            border-spacing: 0;
                                            margin: 0;
                                            padding: 0;
                                            padding-bottom: 3px;
                                            padding-left: 6.25%;
                                            padding-right: 6.25%;
                                            width: 87.5%;
                                            font-size: 18px;
                                            font-weight: 300;
                                            line-height: 150%;
                                            padding-top: 5px;
                                            color: #000000;
                                            font-family: sans-serif;
                                        '
                                        class='subheader'
                                    ></td>
                                </tr>

                                <!-- HERO IMAGE -->
                                <!--                         <tr>
                                    <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-top: 20px;' class='hero'>
                                        <a target='_blank' style='text-decoration: none;' href='https://github.com/konsav/email-templates/'>
                                            <img
                                                border='0'
                                                vspace='0'
                                                hspace='0'
                                                src='https://raw.githubusercontent.com/konsav/email-templates/master/images/hero-wide.png'
                                                alt='Please enable images to view this content'
                                                title='Hero Image'
                                                width='560'
                                                style='width: 100%; max-width: 560px; color: #000000; font-size: 13px; margin: 0; padding: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: block;'
                                            />
                                        </a>
                                    </td>
                                </tr> -->

                                <!-- PARAGRAPH -->
                                <tr>
                                    <td
                                        align='left'
                                        valign='top'
                                        style='
                                            border-collapse: collapse;
                                            border-spacing: 0;
                                            margin: 0;
                                            padding: 0;
                                            padding-left: 6.25%;
                                            padding-right: 6.25%;
                                            width: 87.5%;
                                            font-size: 14px;
                                            font-weight: 400;
                                            line-height: 160%;
                                            padding-top: 25px;
                                            color: #000000;
                                            font-family: sans-serif;
                                        '
                                        class='paragraph'
                                    >
                                        " . $mBody . "
                                    </td>
                                </tr>

                                <!-- BUTTON -->

                                <!-- LINE -->
                                <!-- Set line color -->
                                <tr>
                                    <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; padding-top: 25px;' class='line'>
                                        <hr color='#E0E0E0' align='center' width='100%' size='1' noshade='' style='margin: 0; padding: 0;' />
                                    </td>
                                </tr>
                                <!-- PARAGRAPH -->
                                <!-- Set text color and font family ('sans-serif' or 'Georgia, serif'). Duplicate all text styles in links, including line-height -->
                                <tr>
                                    <td
                                        align='center'
                                        valign='top'
                                        style='
                                            border-collapse: collapse;
                                            border-spacing: 0;
                                            margin: 0;
                                            padding: 0;
                                            padding-left: 6.25%;
                                            padding-right: 6.25%;
                                            width: 87.5%;
                                            font-size: 17px;
                                            font-weight: 400;
                                            line-height: 160%;
                                            padding-top: 20px;
                                            padding-bottom: 25px;
                                            color: #000000;
                                            font-family: sans-serif;
                                        '
                                        class='paragraph'
                                    ></td>
                                </tr>

                                <!-- End of WRAPPER -->
                            </tbody>
                        </table>

                        <!-- WRAPPER -->
                        <!-- Set wrapper width (twice) -->
                        <table border='0' cellpadding='0' cellspacing='0' align='center' width='560' style='border-collapse: collapse; border-spacing: 0; padding: 0; width: inherit; max-width: 560px;' class='wrapper'>
                            <!-- SOCIAL NETWORKS -->
                            <!-- Image text color should be opposite to background color. Set your url, image src, alt and title. Alt text should fit the image size. Real image size should be x2 -->
                            <tbody>
                                <tr>
                                    <td align='center' valign='top' style='border-collapse: collapse; border-spacing: 0; margin: 0; padding: 0; padding-left: 6.25%; padding-right: 6.25%; width: 87.5%; padding-top: 25px;' class='social-icons'>
                                        <table width='256' border='0' cellpadding='0' cellspacing='0' align='center' style='border-collapse: collapse; border-spacing: 0; padding: 0;'>
                                            <tbody>
                                                <tr>
                                                    <!-- ICON 1 -->
                                                    <td align='center' valign='middle' style='margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;'>
                                                        <a target='_blank' href='https://www.facebook.com/NetProtectorNpav/' style='text-decoration: none;'>
                                                            <img
                                                                border='0'
                                                                vspace='0'
                                                                hspace='0'
                                                                style='padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;'
                                                                alt='F'
                                                                title='Facebook'
                                                                width='44'
                                                                height='44'
                                                                src='https://raw.githubusercontent.com/konsav/email-templates/master/images/social-icons/facebook.png'
                                                            />
                                                        </a>
                                                    </td>

                                                    <!-- ICON 2 -->
                                                    <td align='center' valign='middle' style='margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;'>
                                                        <a target='_blank' href='https://twitter.com/netprotector/' style='text-decoration: none;'>
                                                            <img
                                                                border='0'
                                                                vspace='0'
                                                                hspace='0'
                                                                style='padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;'
                                                                alt='T'
                                                                title='Twitter'
                                                                width='44'
                                                                height='44'
                                                                src='https://raw.githubusercontent.com/konsav/email-templates/master/images/social-icons/twitter.png'
                                                            />
                                                        </a>
                                                    </td>

                                                    <!-- ICON 3 -->
                                                    <td align='center' valign='middle' style='margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;'>
                                                        <a target='_blank' href='https://www.youtube.com/channel/UCQ8Ka-PVZ08DAzahAdI_dfw/videos' style='text-decoration: none;'>
                                                            <img
                                                                border='0'
                                                                vspace='0'
                                                                hspace='0'
                                                                style='padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;'
                                                                alt='G'
                                                                title='Google Plus'
                                                                width='44'
                                                                height='44'
                                                                src='https://raw.githubusercontent.com/konsav/email-templates/master/images/social-icons/googleplus.png'
                                                            />
                                                        </a>
                                                    </td>

                                                    <!-- ICON 4 -->
                                                    <td align='center' valign='middle' style='margin: 0; padding: 0; padding-left: 10px; padding-right: 10px; border-collapse: collapse; border-spacing: 0;'>
                                                        <a target='_blank' href='https://www.instagram.com/netprotector/' style='text-decoration: none;'>
                                                            <img
                                                                border='0'
                                                                vspace='0'
                                                                hspace='0'
                                                                style='padding: 0; margin: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic; border: none; display: inline-block; color: #000000;'
                                                                alt='I'
                                                                title='Instagram'
                                                                width='44'
                                                                height='44'
                                                                src='https://raw.githubusercontent.com/konsav/email-templates/master/images/social-icons/instagram.png'
                                                            />
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                                <!-- FOOTER -->
                                <!-- Set text color and font family ('sans-serif' or 'Georgia, serif'). Duplicate all text styles in links, including line-height -->
                                <tr>
                                    <td
                                        align='center'
                                        valign='top'
                                        style='
                                            border-collapse: collapse;
                                            border-spacing: 0;
                                            margin: 0;
                                            padding: 0;
                                            padding-left: 6.25%;
                                            padding-right: 6.25%;
                                            width: 87.5%;
                                            font-size: 13px;
                                            font-weight: 400;
                                            line-height: 150%;
                                            padding-top: 20px;
                                            padding-bottom: 20px;
                                            color: #999999;
                                            font-family: sans-serif;
                                        '
                                        class='footer'
                                    >
                                        <!-- ANALYTICS -->
                                    </td>
                                </tr>

                                <!-- End of WRAPPER -->
                            </tbody>
                        </table>

                        <!-- End of SECTION / BACKGROUND -->
                    </td>
                </tr>
            </tbody>
        </table>";
    }
}
