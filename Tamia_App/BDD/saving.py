from BDD.cursor import cur

def saving(id_produit, value):
    '''
        Actualisation du status de sauvegarde d'un produit
    '''
    id_produit= str(id_produit)
    cur.execute(f"UPDATE produits SET saving_p={'true' if value else 'false'};")