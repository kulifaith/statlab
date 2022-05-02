<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style type="text/css">
  TD{font-size: 8pt; font-variant: normal; font-family: DejaVu Serif;}
    @page {size: 180mm 100mm; margin-top: 30px; margin-left: 15px; margin-right: 15px; margin-bottom: 80px; }
  </style>
</head>
<body>
 <table style="text-align:center;" width="100%">
  <tr>          
    <td  colspan="6" style="text-align:center;">
          <span style="font-size: 18px" ><b>NANA PROPERTIES LIMITED</b></span>
          <br>
          <br>
          <span style="font-size: 11px" >Tel: 0772 435 996 / 0772 603 559 </span>
          <br>
          <!-- <span style="font-size: 11px" >Email: lmkmedlab@yahoo.com</span>
          <br>  -->      
        </td>
  </tr>
  <tr>
    <td colspan="12">
      <span style="font-size: 14px;"><b>{{ 'RECEIPT'}}</b></span>
    </td>
  </tr>
</table>
<table width="100%">
  <tr>
    <td colspan="6" style="text-align:left;font-size: 12px;">
      <b>No.</b> {{$visitDate->id}}
    </td>
    <td colspan="6" style="text-align:right;font-size: 9px;"><i style="color: blue;">
      Date {{ date('Y-m-d', strtotime($visitDate->created_at)) }}</i>
    </td>
  </tr>
</table> 
<!-- <table width="100%">
    <tr>
      <td style="text-align:left;font-size: 9px;">
        CLIENT: {{$tenant->firstname}}
      </td>
    </tr>
</table> -->
<table style="border-bottom: 1px solid #cecfd5;" width="100%">
  <tr>
    <td width="30%" style="font-size: 10px;"><b>Received with thanks from</b></td>
    <td width="70%" style="text-align:left; font-size: 10px;"><i style="color: blue;">{{$tenant->firstname}} {{$tenant->middlename}} {{$tenant->lastname}}</i></td>
  </tr>
</table>
<table style="border-bottom: 1px solid #cecfd5;" width="100%">
  <tr>
    <td width="30%" style="font-size: 10px;"><b>The sum of shillings</b></td>
    <td width="70%" style="text-align:left; font-size: 10px;"><i style="color: blue;">{{$word}} shillings only</i></td>
  </tr>
</table>
<table style="border-bottom: 1px solid #cecfd5;" width="100%">
  <tr>
    <td width="25%" style="font-size: 10px;"><b>For the period</b></td>
    <td width="25%" style="text-align:left; font-size: 10px;"><i style="color: blue;">{{ date('d-M-Y', strtotime($visitDate->date_from)) }}</i></td>
    <td width="15%" style="text-align:left; font-size: 10px;"><b>To</b></td>
    <td width="35%" style="text-align:left; font-size: 10px;"><i style="color: blue;">{{ date('d-M-Y', strtotime($visitDate->date_to)) }}</i></td>
  </tr>
</table>
<table style="border-bottom: 1px solid #cecfd5;" width="100%">
  <tr>
    <td width="25%" style="font-size: 10px;"><b>Paid as</b></td>
    <td width="25%" style="text-align:left; font-size: 10px;"><i style="color: blue;">Cash/Cheque</i></td>
    <td width="15%" style="text-align:left; font-size: 10px;"><b>Balance:</b></td>
    <td width="35%" style="text-align:left; font-size: 10px;"><i style="color: blue;">@if($balanceleft == 0)
    NILL
@else{{ $balanceleft }} /=
@endif</i></td>
  </tr>
</table>
<table style="border-bottom: 1px solid #cecfd5;" width="100%">
  <tr>
    <td width="15%" style="font-size: 10px;"><b>Shs.</b></td>
    <td width="25%" style="text-align:left; border: 1px solid black;font-size: 10px;"><i style="color: blue;">{{$amountPaid}} /=</i></td>
    <td width="10%"></td>
    <td width="25%" style="text-align:left; font-size: 10px;"><b>Sign:</b></td>
    <td width="25%" style="text-align:left; font-size: 10px;"><i ></i></td>
  </tr>
</table>
<script type="text/php">
    if (isset($pdf)) {
        $x = 200;
        $y = 250;
        $text = "Thank you for trusting us";
        $texts = "{{config('kblis.certificate-info')}}";
        $pagelabel = "{{ $balanceleft}}";
        $font = null;
        $size = 8;
        $size2 = 6;
        $color = array(0,0,0);
        $color2 = array(250,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        $pdf->page_text(250, 800, $texts, $font, $size2, $color, $word_space, $char_space, $angle);

    }
</script>

</body>        
</html>