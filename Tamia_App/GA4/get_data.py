from google.analytics.data_v1beta import BetaAnalyticsDataClient
from google.analytics.data_v1beta.types import Dimension, Metric, FilterExpression, Filter
from google.analytics.data_v1beta.types import RunRealtimeReportRequest

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