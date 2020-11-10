<html>
<head>
<script src="script/jquery-3.3.1.min.js"></script>
<script src="script/jquery.googoose.js"></script>

</head>



<?php    
    $user_id = $_POST['user_id'];    
    $user_name = $_POST['user_name'];
    $user_class = $_POST['user_class'];  
    $user_phone = $_POST['user_phone'];
    $item_no = $_POST['item_no'];  
    $item_name = $_POST['item_name'];
    $item_ps = $_POST['item_ps'];
    $item_reason = $_POST['item_reason'];

    $start_date = $_POST['start_date'];         
    $end_date = $_POST['end_date'];
    $note = "";
    if(isset($_POST['item_no'])){
        $note = $_POST['item_no'];
    }  
?>

<body>
<div id='long_data'>
<div class=WordSection1 style='layout-grid:18.0pt'>

<p class=MsoNormal align=center style='mso-margin-top-alt:auto;mso-margin-bottom-alt:
auto;text-align:center;line-height:22.0pt;mso-line-height-rule:exactly'><span style='mso-ignore:vglayout;position:
relative;z-index:251657728'><span style='position:absolute;left:-80px;top:-10px;
width:90px;height:90px'><img width=60 height=60
src="http://120.96.63.167/boom/showpage/image002.jpg" v:shapes="_x0000_s1026"></span></span><span
style='font-size:20.0pt;font-family:標楷體'>資訊管理系 設備借用單<span lang=EN-US><o:p></o:p></span></span></p>

<p class=MsoNormal align=right style='text-align:right;word-break:break-all'><span
lang=EN-US style='mso-bidi-font-size:12.0pt;font-family:"新細明體","serif"'><o:p>&nbsp;</o:p></span></p>

<div align=center>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none;mso-border-alt:solid windowtext .5pt;
 mso-yfti-tbllook:1184;mso-padding-alt:0cm 5.4pt 0cm 5.4pt;mso-border-insideh:
 .5pt solid windowtext;mso-border-insidev:.5pt solid windowtext'>
 <tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;height:54.0pt'>
  <td width=151 style='width:90.45pt;border:solid windowtext 1.0pt;mso-border-alt:
  solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:54.0pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:16.0pt;font-family:標楷體'>班級<span lang=EN-US><o:p></o:p></span></span></p>
  </td>
  <td width=295 style='width:177.2pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:54.0pt'>
  <p class=MsoNormal><span lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p><?php echo $user_class; ?></o:p></span></p>
  </td>
  <td width=130 style='width:77.95pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:54.0pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:16.0pt;font-family:標楷體'>學號<span lang=EN-US><o:p></o:p></span></span></p>
  </td>
  <td width=301 style='width:180.85pt;border:solid windowtext 1.0pt;border-left:
  none;mso-border-left-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:54.0pt'>
  <p class=MsoNormal><span lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p><?php echo $user_id; ?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:1;height:54.0pt'>
  <td width=151 style='width:90.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:54.0pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:16.0pt;font-family:標楷體'>姓名<span lang=EN-US><o:p></o:p></span></span></p>
  </td>
  <td width=295 style='width:177.2pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:54.0pt'>
  <p class=MsoNormal><span lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p><?php echo $user_name; ?></o:p></span></p>
  </td>
  <td width=130 style='width:77.95pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:54.0pt'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:16.0pt;font-family:標楷體'>手機<span lang=EN-US><o:p></o:p></span></span></p>
  </td>
  <td width=301 style='width:180.85pt;border-top:none;border-left:none;
  border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:54.0pt'>
  <p class=MsoNormal><span lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p><?php echo $user_phone; ?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:2;height:3.0cm'>
  <td width=151 style='width:90.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:16.0pt;font-family:標楷體'>設備名稱<span lang=EN-US><o:p></o:p></span></span></p>
  </td>
  <td width=727 colspan=3  style='width:436.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal><span lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p><?php echo $item_name; ?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:3;height:3.0cm'>
  <td width=151 style='width:90.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:16.0pt;font-family:標楷體'>財產編號<span lang=EN-US><o:p></o:p></span></span></p>
  </td>
  <td width=727 colspan=3  style='width:436.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal><span lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p><?php echo $item_no; ?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:4;height:3.0cm'>
  <td width=151 style='width:90.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:16.0pt;font-family:標楷體'>借用附件<span lang=EN-US><o:p></o:p></span></span></p>
  </td>
  <td width=727 colspan=3  style='width:436.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal><span lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p><?php echo $note; ?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:5;height:3.0cm'>
  <td width=151 style='width:90.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:16.0pt;font-family:標楷體'>借用原因<span lang=EN-US><o:p></o:p></span></span></p>
  </td>
  <td width=727 colspan=3 valign=top style='width:436.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal><span lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p><?php echo $item_reason; ?></o:p></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:6;height:3.0cm'>
  <td width=151 style='width:90.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:16.0pt;font-family:
  標楷體'>借用日期<span lang=EN-US><o:p></o:p></span></span></b></p>
  </td>
  <td width=727 colspan=3 style='width:436.0pt;border-top:none;border-left:
  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:3.0cm'>
  <p class=MsoNormal><span style='font-size:16.0pt;font-family:標楷體'><?php echo $start_date; ?></span></p>
  </td>
 </tr>
 <tr style='mso-yfti-irow:7;mso-yfti-lastrow:yes;height:86.75pt'>
  <td width=151 style='width:90.45pt;border:solid windowtext 1.0pt;border-top:
  none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:86.75pt'>
  <p class=MsoNormal align=center style='text-align:center'><b
  style='mso-bidi-font-weight:normal'><span style='font-size:16.0pt;font-family:
  標楷體'>歸還日期<span lang=EN-US><o:p></o:p></span></span></b></p>
  </td>
  <td width=727 colspan=3 valign=bottom style='width:436.0pt;border-top:none;
  border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
  mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
  mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:86.75pt'>
  <p class=MsoNormal><span style='font-size:16.0pt;font-family:標楷體'><?php echo $end_date; ?></span></p>
  <p class=MsoNormal align=right style='text-align:right'><span
  style='font-size:11.0pt;mso-bidi-font-size:16.0pt;font-family:標楷體;background:
  silver;mso-highlight:silver'>最多為借用日期兩<span class=GramE>週</span>內</span><span
  lang=EN-US style='font-size:16.0pt;font-family:標楷體'><o:p></o:p></span></p>
  </td>
 </tr>
</table>

</div>


<p class=MsoNormal><span lang=EN-US style='font-size:14.0pt;font-family:"新細明體","serif"'><o:p>&nbsp;</o:p></span></p>

<p class=MsoNormal align=right style='text-align:right'><span style='font-size:
14.0pt;font-family:"新細明體","serif"'>專題指導老師：<span lang=EN-US>______________________<u><o:p></o:p></u></span></span></p>

</div>
</div>
<script>
/*
	$(document).googoose({
		area: '#long_data',
		filename:'設備長期借用單'
	})*/

</script>
</body>

</html>