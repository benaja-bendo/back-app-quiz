# with open('hello_world.txt', 'w') as fichier:
#     fichier.write("hello world")

import requests
from bs4 import BeautifulSoup
import json

def scraper_veille_techno(url, fichier_json):
    """Récupère les informations de veille technologique depuis une URL et les stocke en JSON."""

    try:
        response = requests.get(url)
        response.raise_for_status()  # Vérifie si la requête a réussi

        soup = BeautifulSoup(response.content, 'html.parser')

        # Extraction des données (à personnaliser selon la structure du site)
        articles = []
        for article in soup.find_all('article', class_='votre_classe_article'):
            titre = article.find('h2').text
            lien = article.find('a')['href']
            resume = article.find('p').text  # Ou une autre balise pour le résumé
            articles.append({'titre': titre, 'lien': lien, 'resume': resume})

        # Sauvegarde en JSON
        with open(fichier_json, 'w') as f:
            json.dump(articles, f, indent=4)  # indent pour la lisibilité

        print(f"Données sauvegardées dans {fichier_json}")

    except requests.exceptions.RequestException as e:
        print(f"Erreur lors de la requête : {e}")

# url_veille = "https://www.votre_site_de_veille_techno.com/actualites"
url_veille = "https://www.lesnumeriques.com/souris/logi tech-g309-lightspeed-p75280/test.html"
fichier_json = "veille_techno.json"
scraper_veille_techno(url_veille, fichier_json)
