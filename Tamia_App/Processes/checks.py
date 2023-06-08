from time import sleep
from BDD.exists import site_exists, produit_exists
from BDD.news import get_news
from Files.create import create_site
from main import produits
from Processes.train_product import Train_product
from Files.drop import drop_site, drop_produit

def check_created():
    '''
        Lancement de nouveaux procéssus d'entrainement à partir des informations de la BDD toute les secondes
    '''
    max_id = 0
    while True:
        max_id, news = get_news(max_id)
        print("Check news:",[max_id, news])
        if news != []:
            by_sites = {}
            for row in news:
                if row[0] in by_sites:
                    by_sites[row[0]].append(list(row[1:]))
                else:
                    by_sites[row[0]] = [list(row[1:])]
            for site in by_sites:
                create_site(site)
                for produit in by_sites[site]:
                    thread = Train_product(*[site]+produit)
                    if site in produits:
                        produits[site].append(thread)
                    else:
                        produits[site] = [thread]
                    thread.start()
        sleep(1)

def check_dropped():
    '''
        Vérification de l'existence dans la base de données des produits et sites déjà considérés par Tamia toute les secondes
    '''
    while True:
        for site in produits:
            if not site_exists(site):
                print("Check dropped site:", site)
                for produit in produits[site]:
                    produit._run = False
                drop_site(site)
                produits.pop(site)
                break
            else:
                for produit in produits[site]:
                    if produit.run and not produit_exists(produit.id_produit):
                        print("Check dropped produit:", produit.id_produit)
                        produit._run = False
                        drop_produit(site, produit.id_produit)
                        produits[site].remove(produit)
        sleep(1)