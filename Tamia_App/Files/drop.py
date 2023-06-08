import os

def drop_produit(id_site, id_produit):
    '''
        Suppression des données d'un modèle de produit + celle de l'historique d'apprentissage de ce même produit
    '''
    id_site = str(id_site)
    id_produit = str(id_produit)
    if os.path.exists(f"Models\\{id_site}\\{id_produit}"):
        os.system(f"rmdir /s /q Models\\{id_site}\\{id_produit}")
        os.system(f"del Models\\{id_site}\\{id_produit}.txt")

def drop_site(id_site):
    '''
        Suppression d'un dossier d'un site spécifique ainsi que toutes les données produit qu'il contenait
    '''
    id_site = str(id_site)
    if os.path.exists(f"Models\\{id_site}"):
        os.system(f"rmdir /s /q Models\\{id_site}")