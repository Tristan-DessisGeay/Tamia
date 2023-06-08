from BDD.saving import saving
from Files.create import save_model
from GA4.get_data import get_data

from time import sleep
from threading import Thread
import numpy as np
import tensorflow as tf

class Train_product(Thread):

    '''
        - Récupération de données toutes les 30 minutes
        - Entrainement tous les jours 
        - Données / Résultats multipliées par le facteur temps
    '''

    def __init__(self, id_site, id_produit, event, frequence, eventList, propertyID):
        super().__init__()

        self._run = True
        self.id_site = id_site
        self.id_produit = id_produit
        self.event = event
        self.eventList = eventList.split(';')
        self.propertyID = propertyID

        if frequence == 1:
            self.facteur = 48
        elif frequence == 2:
            self.facteur = 48 * 7
        elif frequence == 3:
            self.facteur = 48 * 7 * 4

        self.model = tf.keras.Sequential([
            tf.keras.layers.Dense(32, activation="relu"),
            tf.keras.layers.Dense(16, activation="relu"),
            tf.keras.layers.Dense(8, activation="relu"),
            tf.keras.layers.Dense(1)
        ])

        self.model.compile(
            loss="mae",
            optimizer=tf.keras.optimizers.Adam()
        )

        self.X = []
        self.y = []

    def run(self):
        '''
            Boucle principale d'un produit comprenant la récupération d'informations puis l'entrainement du modèle
        '''
        while self._run:
            for _ in range(48):
                if self._run:
                    print("Lancement entrainement :", self.id_produit)
                    sleep(1800) # 30 minutes
                    data = get_data(self.propertyID, self.eventList, self.event)
                    if data:
                        data, out = data
                        self.y.append([out * self.facteur])
                        row = []
                        for event in self.eventList:
                            if event in data: row.append(data[event] * self.facteur)
                            else: row.append(0)
                        self.X.append(row)
                    else:
                        self._run = False
                        break
                else: break
            if self._run:
                dataset = tf.data.Dataset.from_tensor_slices((self.X, self.y)) \
                            .shuffle(3) \
                            .batch(48)
                history = self.model.fit(dataset, 
                                        epochs=10, 
                                        steps_per_epoch=len(dataset),
                                        verbose=False)
                save_model(self.id_site, self.id_produit, self.model, history)
            sleep(5)