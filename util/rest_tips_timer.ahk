
; D:\officePlat\AutoHotkey.exe  D:\0workspace\atiplat_eeJS\com.attilax\util\rest_tips_timer.ahk
loop
{
	if ( A_Min>45  )
	{

		IfExist, d:\rest_alarm_lit_dis
		{
		
		
		}
		else
		{
				;//lit alarm
					 FileAppend, rest_alarm_lit, d:\rest_alarm_lit.txt
					 msgbox,%A_Min%
		 }

	}
	
	if( A_Min<=45)
	{
		;//rest disalbe 
		FileDelete, d:\rest_alarm_lit_dis.txt
	}

sleep,3000

}