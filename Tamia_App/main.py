'''
    Permettant de lancer les 2 procéssus principaux de Tamia :
    - check_created (pour les nouveaux produits)
    - check_dropped (pour les produits et sites supprimés)
'''

produits = {} # Conteneur des procéssus de d'entrainement des produits

if __name__ == '__main__':
    import os
    from Processes.checks import check_created, check_dropped
    from threading import Thread

    os.environ['GOOGLE_APPLICATION_CREDENTIALS'] = 'ga4_tamia.json' # Prise en compte du fichier de connexion à Console Cloud Google

    th1 = Thread(target=check_created)
    th2 = Thread(target=check_dropped)

    th1.start()
    th2.start()