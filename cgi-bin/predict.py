#!C:/Users/Tristan.LAPTOP-UODU4SRG/AppData/Local/Programs/Python/Python38/python
import tensorflow as tf
import cgi, sys, codecs, os
import numpy as np
import psycopg2
from google.analytics.data_v1beta import BetaAnalyticsDataClient
from google.analytics.data_v1beta.types import Dimension, Metric, FilterExpression, Filter
from google.analytics.data_v1beta.types import RunRealtimeReportRequest

def checkSaving(id_produit):
    conn = psycopg2.connect(
        database="tamia",
        user="postgres",
        password="0000",
        host="localhost",
        port="5432"
    )

    cur = conn.cursor()

    cur.execute(f"SELECT saving_p FROM produits WHERE id_p = {id_produit};")
    return cur.fetchone()[0]

def get_data(property_id, filters, event_name):
    '''
        Récupération des évènements sur l'interface GA4 en fonction des paramètres:
        - property_id (unique pour chaque site)
        - filters (les évènements renseignés par l'utilisateur)
        - event_name (l'évènement définissant le nombre de vente d'un produit spécifique)
    '''

    client = BetaAnalyticsDataClient()

    report_request = RunRealtimeReportRequest(
        property=f'properties/{property_id}',
        dimensions=[Dimension(name='eventName')],
        metrics=[Metric(name='eventCount')],
        dimension_filter=FilterExpression(
                        filter=Filter(
                            field_name="eventName",
                            in_list_filter=Filter.InListFilter(values=filters+[event_name])
                        )
                    )
    )

    try:
        response = client.run_realtime_report(report_request)
    except Exception as e:
        return False

    data = {}
    out = 0
    for row in response.rows:
        if row.dimension_values[0].value == event_name:
            out = int(row.metric_values[0].value)
        else:
            data[row.dimension_values[0].value] = int(row.metric_values[0].value)
    
    return data, out

sys.stdout = codecs.getwriter("utf-8")(sys.stdout.detach())

print("content-type:text/html;charset=utf-8\n")

data=cgi.FieldStorage()

site = data.getvalue("site")
produit = data.getvalue("produit")

property_id = data.getvalue("property_id")
filters = data.getvalue("filters").split(";") 
event_name = data.getvalue("event_name")
# site = "1"
# produit = "1"

# property_id = "347904942"
# filters = "page_view;scroll;user_engagement;purchase;session_start;first_visit;accountCreated".split(";")
# event_name = "Atshirt"

os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = '../../Tamia_App/ga4_tamia.json'

if os.path.exists(f"../../Tamia_App/Models/{site}/{produit}"): # not checkSaving(produit) and
    
    data, _ = get_data(property_id, filters, event_name)
    X = []
    Xstr = ""
    
    for event in filters:
        if event in data:
            X.append(data[event])
            Xstr += ";"+str(data[event])
        else: 
            X.append(0)
            Xstr += ";"+str(0)
    model = tf.keras.models.load_model(f"../../Tamia_App/Models/{site}/{produit}")
    result = model.predict(np.array([X]), verbose=False)
    print(str(int(result))+Xstr)
else:
    print(-0.1)