import psycopg2 # python -m pip install psycopg2

'''
    - Informations de connexion à la BDD PostgreSQL
    - Création d'un curseur
'''

conn = psycopg2.connect(
    database="tamia",
    user="postgres",
    password="0000",
    host="localhost",
    port="5432"
)

cur = conn.cursor()