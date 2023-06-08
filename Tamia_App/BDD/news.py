from BDD.cursor import cur

def get_news(max_id):
    '''
        Obtension des derniers produits ajoutés à la BDD à partir du max_id
    '''
    max_id = str(max_id)
    cur.execute(f"SELECT produits.id_s, id_p, event_p, frequence_p, eventlist_p, propertyid_s FROM produits, sites WHERE sites.id_s=produits.id_s AND id_p > {max_id};")
    news = cur.fetchall()
    cur.execute("SELECT max(id_p) FROM produits;")
    max_id = cur.fetchone()[0]
    if max_id == None: max_id=0
    return (max_id, news)