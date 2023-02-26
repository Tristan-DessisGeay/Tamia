#!C:/Users/Tristan.LAPTOP-UODU4SRG/AppData/Local/Programs/Python/Python38/python
import cgi, sys, codecs, os
from google.analytics.data_v1beta import BetaAnalyticsDataClient # pip install six
from google.analytics.data_v1beta.types import RunRealtimeReportRequest, Metric


def test_connexion(property_id):
    '''
        Fonction permettant de connaitre la validité d'un property_id
    '''
    client = BetaAnalyticsDataClient()

    try:
        client.run_realtime_report(RunRealtimeReportRequest(property=f'properties/{property_id}',metrics=[Metric(name='activeUsers')]))
        return True
    except Exception as e:
        return False

sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

data=cgi.FieldStorage()

print("content-type:text/html;charset=utf-8\n")

property_id = str(data.getvalue("property_id"))

os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = '../../Tamia_App/ga4_tamia.json'

if test_connexion(property_id):
    print(1)
else:
    print(0)