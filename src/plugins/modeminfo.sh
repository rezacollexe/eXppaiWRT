#!/bin/sh
#
# sysinfo.sh dla OpenWRT AA Cezary Jackiewicz 2013
# 
#	1.00	CJ	Pierwsza wersja kodu
#	1.01	RD	Drobna przebudowa
#	1.02	RD	Korekta b³êdu wy¶w. zajeto¶ci Flash-a, dodanie kolorów
#	1.03	RD	Dodanie nazwy routera, zmiana formatowania
#	1.04	RD	Kosmetyka, sugestie @mikhnal. Zmiana przetwarzania info. o wan.
#	1.05	RD	Zmiana algorytmu pobierania danych dla wan i lan
#	1.06	RD	Parametryzacja kolorów i pojawiania siê podkre¶leñ
#	1.07	RD	Modyfikacja zwi±zana z poprawnym wy¶wietlaniem interfejsu dla prot.3g
#	1.08	RD	Modyfikacja wy¶wietlania DNS-ów dla wan, dodanie uptime dla interfejsów
#	1.09	RD	Dodanie statusu "Down" dla wy³±czonego wifi, zmiana wy¶wietlania dla WLAN(sta)
#	1.10	RD	Korekta wy¶wietlania dla WLAN(sta)
#	1.11	RD	Korekta wy¶wietlania stanu pamiêci, sugestie @dopsz 
#	1.12	RD	Zmiana kolejno¶ci wy¶wietlania warto¶ci stanu pamiêci + kosmetyka 
#	1.13	RD	Dodanie info o dhcp w LAN, zmiana sposobu wy¶wietlania informacji o LAN
#	1.14	RD	Dodanie informacji o ostatnich 5 b³êdach
#	1.15	RD	Zmiana stderr
#	1.16	RD	Dodanie wy¶wietlania informacji o swap
#	1.17	RD	Zmiana wyliczania informacji o flash
#	1.18	RD	Zmiana wy¶wietlania informacji o flash
#	1.19	RD	Zmiana wy¶wietlania informacji o sprzêcie
#	1.20	RD	Zmiana wy¶wietlania informacji o sprzêcie
#	1.21	RD	Dopasowyanie szeroko¶ci do zawarto¶ci /etc/banner
#	1.22	RD	Dodanie wyœwietlania w HTML-u
#
# Destination /sbin/sysinfo.sh
#
#. /usr/share/libubox/jshn.sh

cpu_temp="/sys/class/hwmon/hwmon0/temp1_input"
filename="/tmp/status1.file"
line=$(sed '5q;d' $filename)
echo -e "Modem : $line"
line=$(sed '6q;d' $filename)
echo -e "Operator : $line"
line=$(sed '3q;d' $filename)
echo -e "Signal Strength : $line"
line=$(sed '7q;d' $filename)
echo -e "Network : $line"
line=$(sed '1q;d' $cpu_temp)
res_calc=$(($line/1000)) 
echo -e "Suhu STB : $res_calc °C"
line=$(sed '30q;d' $filename)
echo -e "Suhu Modem : $line"
echo -e "============================="
filename="/tmp/status2.file"
line=$(sed '5q;d' $filename)
echo -e "Modem : $line"
line=$(sed '6q;d' $filename)
echo -e "Operator : $line"
line=$(sed '3q;d' $filename)
echo -e "Signal Strength : $line"
line=$(sed '7q;d' $filename)
echo -e "Network : $line"
line=$(sed '1q;d' $cpu_temp)
res_calc=$(($line/1000)) 
echo -e "Suhu STB : $res_calc °C"
line=$(sed '30q;d' $filename)
echo -e "Suhu Modem : $line"
#footer_xppaiwrt

#finalize
#exit 0
# Done.
