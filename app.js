import axios from 'axios';
import * as cheerio from 'cheerio';
import { writeFileSync } from 'node:fs';

async function app(url, fichierJson) {
    try {
        const response = await axios.get(url);

        const $ = cheerio.load(response.data);

        const articles = [];
        $('article.votre_classe_article').each((i, element) => {
            const titre = $(element).find('h2').text();
            const lien = $(element).find('a').attr('href');
            const resume = $(element).find('p').text();
            articles.push({ titre, lien, resume });
        });

        writeFileSync(fichierJson, JSON.stringify(articles, null, 2));
        console.log(`Données sauvegardées dans ${fichierJson}`);

    } catch (error) {
        console.error(`Erreur lors de la requête : ${error.message}`);
    }
}

// Exemple d'utilisation (dans un autre fichier ou en bas de celui-ci)
const urlVeille = "https://www.votre_site_de_veille_techno.com/actualites";
const fichierJson = "veille_techno.json";
app(urlVeille, fichierJson);
// console.log('Scraper lancé !')
