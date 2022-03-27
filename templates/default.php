<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xml:lang="en" lang="en">
    <head>
        <meta name="Author" content="<?= $core_settings->company ?>"/> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">

            @font-face {
                font-weight: normal;
            }
            @font-face {
                font-weight: bold;
            }
            body{
                color: #61686d;
                font: 12px Helvetica, Arial, Verdana, sans-serif;
                font-weight: normal;
                padding-bottom: 60px;
            }
            p{
                margin:0px;
                padding:0px;
            }
            a{
                text-decoration: none;
            }
            .center{
                text-align: center !important;
            }
            .right{
                text-align: right !important;
            }
            .left{
                text-align: left !important;
            }
            .top-background{
                /*
                  //dark version
                  background:#1D2A39;  
                  color:#FFFFFF;
                */
                background:#E5E9EC;
                width:100%; 
                margin:-44px -44px 0px;
                padding:40px 40px 5px;
            }

            .status {
                font-weight: normal;
                text-transform: uppercase;
                color: #FFF;
                font-size: 16px;
                margin-top: -5px;
                text-align: right;

            }

            .Accepted {color: #FC704C; }
            .Sent {color: #EAAA10; }
            .Invoiced {color: #B361FF; }
            .Declined {color: #FC704C; }

            .company-logo {
                max-height: 50px;
                margin-bottom: 10px;
            }

            .company-address {
                line-height:11px;
            }
            .recipient-address {
                line-height:13px;
            }
            .invoicereference{
                font-size: 22px;
                font-weight: normal;
                margin:10px 0;
            }

            #table{
                width:100%;
                margin:20px 0px;
            }

            #table tr.header th{
                font-weight: bold;
                color:#777777;
                font-size: 10px;
                text-transform: uppercase;
                border-bottom:2px solid #DDDDDD;
                padding:0 5px 10px;
            }
            #table tr td{
                font-weight: lighter;
                color:#444444;
                font-size: 12px;
                border-bottom:1px solid #DDDDDD;
                padding:15px 5px;

            }
            #table tr td .item-name{
                font-weight: bold;
                color:#444444;
            }
            #table tr td .description{
                font-weight: normal;
                color:#888888;
                font-size: 10px;
            }

            .padding{
                padding: 5px 0px;
            }
            .total-amount {
                padding: 8px 20px 8px 0;
                color: #FFFFFF;
                font-size: 17px;
                font-weight: normal;
                margin: 0;
                text-align: right;
            }

            .custom-terms {
                padding:20px 2px;
                border-bottom:1px solid #DDDDDD;
                font-size: 12px;
            }
            .over{
                text-transform: uppercase;
                font-size: 10px;
                font-weight: bold;

            }
            .under{
                font-size: 16px;
            }

            .total-heading {
                background: #30363F;
                color: #FFFFFF;
                text-align: right;
                padding:10px;

            }
            .side{
                padding:10px;
                background: #E5E9EC;
            }

            .footer{
                padding:5px 1px;
                font-size: 9px;
                text-align:center;
            }
            <?php if (isset($htmlPreview)) { ?>
                html{
                    background: #3E4042;
                }
                body{
                    padding:40px; width:750px;
                    background:#FFFFFF;
                    margin:50px auto;
                    min-height:800px;
                    box-shadow: 0px 0px 5px 0px #000;
                }
                .top-background {
                    margin: -44px -40px 0px;
                }
                .notification-div{
                    position:absolute;
                    background:#ED5564;
                    margin:0 auto;
                    top:10px;
                    color:#FFFFFF;
                    font-size: 14px;
                    font-weight: bold;
                    padding:10px;
                }
            <?php } ?>
        </style>

    </head>
    <body>
        <div class="top-background">
            <table width="100%" cellspacing="0" >
                <tr>
                    <td><img src="<?= print_link(!empty($core_settings['logo']) ? $core_settings['logo'] : SITE_LOGO); ?>" class="company-logo" /></td>
                    <td style="vertical-align: top;"><div class="status <?php echo $data['status']; ?>"> <?= print_lang('status'); ?></div></td>
                </tr>
                <tr>
                    <td style="vertical-align:top"><?= $core_settings['company']; ?></td>
                    <td class="right" style="vertical-align:top"><strong>RE:</strong><?= $data['client']; ?></td>
                </tr> 
                <tr>
                    <td style="vertical-align:top"><?= $core_settings['invoice_contact']; ?></td>
                    <td class="right" style="vertical-align:top"><strong>Att:</strong><?= $data['fatherName']; ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top"><?= $core_settings['invoice_address']; ?></td>
                    <td class="right" style="vertical-align:top"><?php ?></td>
                </tr>
                <tr>
                    <td style="vertical-align:top"><?= $core_settings['invoice_city']; ?></td>
                    <td class="right" style="vertical-align:top"><?= $data['parmanentAddress']; ?></td>
                </tr>
                <tr>
                    <td class="padding" style="vertical-align:top">
                        <span class="invoicereference"><?= $data['invoicenum'] ?></span><br/>
                        <span class="over"><?php echo date($core_settings['date_format'], strtotime($data['date'])); ?></span>
                    </td>
                    <td class="padding" align="right" style="vertical-align:bottom">
                        <?= print_lang('duedate'); ?> <?php echo date($core_settings['date_format'], strtotime($data['duedate'])); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <table id="table" cellspacing="0"> 
                <thead> 
                    <tr class="header"> 
                        <th class="left"><?= print_lang('invoice_item'); ?></th>
                        <th width="9%" class="center"><?= print_lang('application_hrs_qty'); ?></th>
                        <th width="15%" class="right"><?= print_lang('application_unit_price'); ?></th>
                        <th width="15%" class="right"><?= print_lang('application_sub_total'); ?></th>
                    </tr> 
                </thead> 
                <tbody> 
                    <?php
                    foreach ($items as $item) {
                        $i = 0;
                        $description = preg_replace("/\r|\n/", "<br>", $item['desciption']);
                        $description = str_replace("&lt;br&gt;", "<br>", $description);
                        ?>
                        <tr class="even">
                            <td>
                                <span class="item-name"></span><br/>
                                <span class="description"><?= $description; ?></span>
                            </td>
                            <td class="center"><?= $data['subtotal']; ?></td>
                            <td class="right"><?php echo number_format(sprintf("%01.2f", $data['subtotal'])); ?></td>
                            <td class="right"><?php echo number_format(sprintf("%01.2f", $data['subtotal'])); ?></td>
                        </tr>
                        <?php
                        $sum = $data['total'];
                        $discount = $data['discount'];

                        if ($data['taxname'] != "") {
                            $tax_value = $data['tax'];
                        } else {
                            $tax_value = $core_settings['tax'];
                        }

                        $tax = sprintf("%01.2f", $tax_value);
                    }
                    ?>
                </tbody> 
            </table> 
        </div>
        <div>
            <table width="100%">
                <tr>
                    <td class="side"><span class="over"><?= print_lang('application_sub_total'); ?></span><br/><span class="under"><?= number_format($data['subtotal']); ?></span></td>
                    <?php if ($discount != 0): ?><td class="side"><span class="over"><?= print_lang('application_discount'); ?></span><br/><span class="under">- <?= number_format($discount); ?></span></td><?php endif ?>
                    <td class="side"><span class="over"><?= print_lang('credit'); ?></span><br/><span class="under"> - <?= number_format($data['credit']); ?></span></td>
                    <?php if ($tax_value != "0") { ?><td class="side"><span class="over"><?= print_lang('application_tax'); ?> (<?= $tax_value ?>%)</span><br/><span class="under"> - <?= number_format($tax) ?></span></td><?php } ?>
                    <td class="total-heading"><span class="over"><?= print_lang('application_total'); ?></span><br/><span class="under"><?= number_format($sum); ?></span></td>
                </tr> 
            </table>

            <div class="custom-terms">
                <?php echo $core_settings['invoice_terms']; ?>
            </div>
            <div class="footer">
                <b><?= $core_settings['company']; ?></b> | <?= $core_settings['email']; ?>
                <?php 
                    if ($core_settings['invoice_tel'] != "") {
                        echo " | " . $core_settings['invoice_tel'];
                    } 
                ?>
            </div>
            <script type='text/php'>
                if ( isset($pdf) ) { 
                $font = Font_Metrics::get_font('helvetica', 'normal');
                $size = 9;
                $y = $pdf->get_height() - 24;
                $x = $pdf->get_width() - 15 - Font_Metrics::get_text_width('1/1', $font, $size);
                $pdf->page_text($x, $y, '{PAGE_NUM}/{PAGE_COUNT}', $font, $size);
                } 
            </script>
        </div>
    </body>
</html>
