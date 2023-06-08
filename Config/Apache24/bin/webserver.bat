@echo off

more +1 "C:\Apache24\conf\httpd.conf" > tmp.txt

if %1 EQU default goto default
echo Define SRVDIR "%cd%" > "C:\Apache24\conf\httpd.conf"
goto end

:default
echo Define SRVDIR "c:/Apache24/httpd" > "C:\Apache24\conf\httpd.conf"

:end
type tmp.txt >> "C:\Apache24\conf\httpd.conf"
del tmp.txt
httpd.exe -k restart -n "Apache2.4"
