import os
from BDD.saving import saving

def create_site(id_site):
    '''
        Création d'un nouveau dossier dédié au stockage des modèles de produits de ce site
    '''
    id_site = str(id_site)
    if not os.path.exists(f"Models\\{id_site}"):
        os.system(f"mkdir Models\\{id_site}")

def save_model(id_site, id_produit, model, history):
    '''
        Sauvegarde des données d'un modèle + sauvegarde de la courbe actuelle d'apprentissage
    '''
    saving(id_produit, True)
    id_produit = str(id_produit)
    id_site = str(id_site)
    model.save(f"Models\\{id_site}\\{id_produit}")
    histStr = [str(i) for i in history.history['loss']]
    os.system(f"echo {';'.join(histStr)} > Models\\{id_site}\\{id_produit}.txt")
    saving(id_produit, False)