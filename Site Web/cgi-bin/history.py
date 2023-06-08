#!C:/Users/Tristan.LAPTOP-UODU4SRG/AppData/Local/Programs/Python/Python38/python
import cgi, sys, codecs, os

sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

data=cgi.FieldStorage()

print("content-type:text/html;charset=utf-8\n")

site = data.getvalue("site")
produit = data.getvalue("produit")

if os.path.exists(f"../../Tamia_App/Models/{site}/{produit}.txt"):
    history_file = open(f"../../Tamia_App/Models/{site}/{produit}.txt", "r")
    print(history_file.read())
    history_file.close()
else:
    print(0)