from BDD.cursor import cur

def produit_exists(_id):
    '''
        Vérification de l'existence d'un produit depuis son id
    '''
    cur.execute(f"SELECT id_p FROM produits WHERE id_p = {_id};")
    return cur.fetchone() is not None

def site_exists(_id):
    '''
        Vérification de l'existence d'un site depuis son id
    '''
    cur.execute(f"SELECT id_s FROM sites WHERE id_s = {_id};")
    try:
        return cur.fetchone() is not None
    except: return False